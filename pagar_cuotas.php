<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

$mensaje = '';
$tipo_mensaje = '';

// Procesar Pago de Cuota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_pagar_cuota'])) {
    $cuota_id = (int) $_POST['cuota_id'];
    $cuenta_origen_id = (int) $_POST['cuenta_origen'];

    try {
        $pdo->beginTransaction();

        // 1. Obtener detalles de la cuota y verificar que esté pendiente y pertenezca al socio
        $stmt = $pdo->prepare("
            SELECT c.id, c.monto, c.numero_cuota, c.estado, p.id as prestamo_id 
            FROM cuotas c 
            JOIN prestamos p ON c.prestamo_id = p.id 
            WHERE c.id = ? AND p.socio_id = ? AND c.estado = 'pendiente' FOR UPDATE
        ");
        $stmt->execute([$cuota_id, $socio_id]);
        $cuota = $stmt->fetch();

        if (!$cuota) {
            throw new Exception("La cuota seleccionada no existe o ya fue pagada.");
        }

        // 2. Verificar Cuenta de Ahorro para el descuento
        $stmt = $pdo->prepare("SELECT id, saldo, numero_cuenta FROM cuentas WHERE id = ? AND socio_id = ? AND estado = 'activa' FOR UPDATE");
        $stmt->execute([$cuenta_origen_id, $socio_id]);
        $cuentaOrigen = $stmt->fetch();

        if (!$cuentaOrigen) {
            throw new Exception("La cuenta seleccionada no es válida.");
        }

        if ($cuentaOrigen['saldo'] < $cuota['monto']) {
            throw new Exception("Saldo insuficiente en su caja de ahorro. Saldo disponible: " . formatCurrency($cuentaOrigen['saldo']));
        }

        // 3. Ejecutar Descuento en Cuenta
        $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo - ? WHERE id = ?");
        $stmt->execute([$cuota['monto'], $cuentaOrigen['id']]);

        // 4. Marcar Cuota como Pagada
        $stmt = $pdo->prepare("UPDATE cuotas SET estado = 'pagado' WHERE id = ?");
        $stmt->execute([$cuota['id']]);

        // 5. Insertar en tabla de pagos
        $stmt = $pdo->prepare("INSERT INTO pagos (prestamo_id, monto, fecha_pago, metodo) VALUES (?, ?, NOW(), 'transferencia')");
        $stmt->execute([$cuota['prestamo_id'], $cuota['monto']]);

        // 6. Registrar Transacción Histórica (Extracto Bancario)
        $descripcion = "Pago de Cuota Nro. " . $cuota['numero_cuota'] . " - Préstamo #" . $cuota['prestamo_id'];
        $stmt = $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, descripcion, fecha) VALUES (?, 'retiro', ?, ?, NOW())");
        $stmt->execute([$cuentaOrigen['id'], $cuota['monto'], $descripcion]);

        // 7. (Opcional) Verificar si el préstamo se pagó en su totalidad
        $stmt = $pdo->prepare("SELECT COUNT(*) as pendientes FROM cuotas WHERE prestamo_id = ? AND estado != 'pagado'");
        $stmt->execute([$cuota['prestamo_id']]);
        $pendientes = $stmt->fetch()['pendientes'];

        if ($pendientes == 0) {
            // Cancelar el préstamo
            $stmt = $pdo->prepare("UPDATE prestamos SET estado = 'pagado' WHERE id = ?");
            $stmt->execute([$cuota['prestamo_id']]);
        }

        $pdo->commit();

        $mensaje = "¡Pago procesado con éxito! Se descontó " . formatCurrency($cuota['monto']) . " de la Cta. " . $cuentaOrigen['numero_cuenta'];
        $tipo_mensaje = "exito";

    } catch (Exception $e) {
        $pdo->rollBack();
        $mensaje = $e->getMessage();
        $tipo_mensaje = "error";
    }
}

// Obtener Cuotas Pendientes del Socio
$cuotasPendientesQuery = "
    SELECT c.id, c.numero_cuota, c.monto, c.fecha_vencimiento, p.monto as prestamo_monto, p.id as prestamo_id 
    FROM cuotas c 
    JOIN prestamos p ON c.prestamo_id = p.id 
    WHERE p.socio_id = ? AND c.estado = 'pendiente' 
    ORDER BY c.fecha_vencimiento ASC
";
$stmt = $pdo->prepare($cuotasPendientesQuery);
$stmt->execute([$socio_id]);
$misCuotasPendientes = $stmt->fetchAll();

// Obtener Cuentas Activas para Descuento
$stmt = $pdo->prepare("SELECT id, numero_cuenta, saldo FROM cuentas WHERE socio_id = ? AND estado = 'activa' AND tipo = 'ahorro'");
$stmt->execute([$socio_id]);
$misCuentas = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Cuotas | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .form-select, .form-input-lg, .btn-small {
            transition: var(--transition-fast);
        }
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-md);
            background-color: #f8fafc;
            font-weight: 500;
        }
        .form-select:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(10, 176, 126, 0.1);
        }
        .alert-box {
            padding: 16px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }
        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .alert-success {
            background-color: rgba(10, 176, 126, 0.1);
            color: var(--secondary-color);
            border: 1px solid rgba(10, 176, 126, 0.2);
        }
        .btn-small {
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            border: none;
            color: white;
            background: var(--primary-color);
            font-weight: 600;
        }
        .btn-small:hover {
            background: var(--primary-light);
        }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <!-- Menú Lateral -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="portal_socios.php" class="logo">
                    <i class="ph-fill ph-leaf"></i>
                    Coop<span>Futuro</span>
                </a>
            </div>
            
            <ul class="sidebar-menu">
                <li style="padding: 0 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Mi Portal</li>
                <li>
                    <a href="portal_socios.php"><i class="ph ph-squares-four"></i> Resumen</a>
                </li>
                <li>
                    <a href="mis_cuentas.php"><i class="ph ph-wallet"></i> Mis Cuentas</a>
                </li>
                <li>
                    <a href="prestamos.php"><i class="ph ph-bank"></i> Préstamos Vigentes</a>
                </li>
                <li>
                    <a href="ahorros_programados.php"><i class="ph ph-calendar-check"></i> Ahorros Programados</a>
                </li>
                
                <li style="padding: 24px 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Operaciones</li>
                <li>
                    <a href="transferencias.php"><i class="ph ph-arrows-left-right"></i> Transferencias</a>
                </li>
                <li class="active">
                    <a href="pagar_cuotas.php"><i class="ph ph-receipt"></i> Pagar Cuotas</a>
                </li>
                <li>
                    <a href="extractos.php"><i class="ph ph-file-text"></i> Extractos</a>
                </li>
                
                <li style="padding: 24px 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Configuración</li>
                <li>
                    <a href="perfil.php"><i class="ph ph-user-circle"></i> Mi Perfil</a>
                </li>
                <li>
                    <a href="logout.php" style="color: #ef4444;"><i class="ph ph-sign-out"></i> Cerrar Sesión</a>
                </li>
            </ul>
        </aside>

        <!-- Contenido Principal -->
        <main class="dashboard-main">
            <!-- Cabecera -->
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button id="menuToggle" style="background: none; border: none; font-size: 1.5rem; color: var(--text-dark); cursor: pointer; display: none;">
                        <i class="ph ph-list"></i>
                    </button>
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Centro de Pagos</div>
                </div>
                
                <div class="user-profile">
                    <button style="background: none; border: none; font-size: 1.5rem; color: var(--text-light); cursor: pointer; position: relative;">
                        <i class="ph ph-bell"></i>
                        <span style="position: absolute; top: 0; right: 0; width: 10px; height: 10px; background: #ef4444; border-radius: 50%; border: 2px solid white;"></span>
                    </button>
                    <div class="avatar"><?php echo substr($_SESSION['socio_nombre'], 0, 1) . substr($_SESSION['socio_apellido'], 0, 1); ?></div>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-dark);"><?php echo htmlspecialchars($_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido']); ?></span>
                        <span style="font-size: 0.75rem; color: var(--text-light);">Socio #<?php echo $_SESSION['socio_id']; ?></span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                
                <div class="page-title text-center" style="margin-bottom: 40px;">
                    <h1 style="font-size: 2.2rem; margin-bottom: 8px;">Pagar Mis Cuotas</h1>
                    <p>Mantenga sus obligaciones al día debitando automáticamente desde sus cajas de ahorro.</p>
                </div>

                <?php if(!empty($mensaje)): ?>
                    <div class="alert-box <?php echo $tipo_mensaje === 'exito' ? 'alert-success' : 'alert-error'; ?>" style="max-width: 900px; margin: 0 auto 24px;">
                        <i class="<?php echo $tipo_mensaje === 'exito' ? 'ph-fill ph-check-circle' : 'ph-fill ph-warning-circle'; ?>" style="font-size: 1.5rem;"></i>
                        <div><?php echo htmlspecialchars($mensaje); ?></div>
                    </div>
                <?php endif; ?>

                <div class="glass-panel" style="max-width: 900px; margin: 0 auto; padding: 32px;">
                    
                    <?php if(count($misCuotasPendientes) > 0): ?>
                        <div class="table-container">
                            <table class="r-table">
                                <thead>
                                    <tr>
                                        <th>Detalles del Préstamo</th>
                                        <th>Vencimiento</th>
                                        <th>Monto Cuota</th>
                                        <th>Abonar con Cuenta</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($misCuotasPendientes as $cuota): ?>
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: var(--primary-color);">Crédito #<?php echo $cuota['prestamo_id']; ?></div>
                                            <div style="font-size: 0.8rem; color: var(--text-light);">Cuota Nro. <?php echo $cuota['numero_cuota']; ?></div>
                                        </td>
                                        <td>
                                            <?php 
                                            // Lógica visual básica de vencimiento
                                            $vence = strtotime($cuota['fecha_vencimiento']);
                                            $hoy = time();
                                            $diff = $vence - $hoy;
                                            $es_vencido = $diff < 0;
                                            $color_vence = $es_vencido ? '#ef4444' : 'var(--text-dark)';
                                            ?>
                                            <div style="font-weight: 600; color: <?php echo $color_vence; ?>">
                                                <i class="ph ph-calendar"></i> <?php echo date('d/M/Y', $vence); ?>
                                            </div>
                                            <?php if($es_vencido): ?>
                                                <div style="font-size: 0.75rem; color: #ef4444; font-weight: 600;">(Vencido)</div>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-weight: 800; color: var(--secondary-color); font-size: 1.1rem;">
                                            <?php echo formatCurrency($cuota['monto']); ?>
                                        </td>
                                        <form action="pagar_cuotas.php" method="POST" onsubmit="return confirm('¿Confirma el pago de la cuota debitando de su cuenta de ahorro?');">
                                            <input type="hidden" name="cuota_id" value="<?php echo $cuota['id']; ?>">
                                            <td style="width: 200px;">
                                                <select name="cuenta_origen" class="form-select" required>
                                                    <option value="" disabled selected>Elegir Cuenta</option>
                                                    <?php foreach($misCuentas as $cuenta): ?>
                                                        <option value="<?php echo $cuenta['id']; ?>">
                                                            Cta: <?php echo $cuenta['numero_cuenta']; ?> (<?php echo formatCurrency($cuenta['saldo']); ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="submit" name="btn_pagar_cuota" class="btn-small">Pagar Ahora</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; color: var(--text-light); padding: 40px 0;">
                            <i class="ph ph-check-circle" style="font-size: 4rem; color: var(--secondary-color); margin-bottom: 16px; opacity: 0.5;"></i>
                            <h3 style="color: var(--text-dark); margin-bottom: 8px;">¡Felicidades!</h3>
                            <p>Te encuentras al día. No tienes cuotas de préstamos pendientes por abonar.</p>
                        </div>
                    <?php endif; ?>

                </div>
                
            </div>
        </main>
    </div>

    <script>
        // Mobile Sidebar toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        
        if(window.innerWidth <= 992) {
            menuToggle.style.display = 'block';
            sidebar.style.display = 'none';
        }
        
        menuToggle.addEventListener('click', () => {
            if (sidebar.style.display === 'none') {
                sidebar.style.display = 'flex';
                sidebar.style.position = 'absolute';
                sidebar.style.minHeight = '100vh';
                sidebar.style.boxShadow = '10px 0 15px rgba(0,0,0,0.1)';
            } else {
                sidebar.style.display = 'none';
            }
        });
        
        window.addEventListener('resize', () => {
            if(window.innerWidth > 992) {
                menuToggle.style.display = 'none';
                sidebar.style.display = 'flex';
                sidebar.style.position = 'fixed';
            } else {
                menuToggle.style.display = 'block';
                sidebar.style.display = 'none';
            }
        });
    </script>
    <script src="assets/js/notificaciones.js?v=1.1"></script>
</body>
</html>
