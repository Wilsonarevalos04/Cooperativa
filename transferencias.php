<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

$mensaje = '';
$tipo_mensaje = '';

// Procesar Formulario de Transferencia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_transferir'])) {
    $cuenta_origen_id = (int) $_POST['cuenta_origen'];
    $numero_cuenta_destino = trim($_POST['cuenta_destino']);
    $monto = (float) str_replace(['Gs.', '.', ','], '', $_POST['monto']);

    if ($monto <= 0) {
        $mensaje = "El monto a transferir debe ser mayor a cero.";
        $tipo_mensaje = "error";
    } else {
        try {
            $pdo->beginTransaction();

            // 1. Verificar Cuenta Origen (que sea de él y tenga saldo)
            $stmt = $pdo->prepare("SELECT id, saldo, numero_cuenta FROM cuentas WHERE id = ? AND socio_id = ? AND estado = 'activa' FOR UPDATE");
            $stmt->execute([$cuenta_origen_id, $socio_id]);
            $cuentaOrigen = $stmt->fetch();

            if (!$cuentaOrigen) {
                throw new Exception("La cuenta de origen seleccionada es inválida o no está activa.");
            }

            if ($cuentaOrigen['saldo'] < $monto) {
                throw new Exception("Saldo insuficiente en la cuenta de origen. Su saldo actual es " . formatCurrency($cuentaOrigen['saldo']));
            }

            if ($cuentaOrigen['numero_cuenta'] === $numero_cuenta_destino) {
                throw new Exception("No puede transferir dinero a la misma cuenta de origen.");
            }

            // 2. Verificar Cuenta Destino
            $stmt = $pdo->prepare("SELECT id, socio_id, saldo FROM cuentas WHERE numero_cuenta = ? AND estado = 'activa' FOR UPDATE");
            $stmt->execute([$numero_cuenta_destino]);
            $cuentaDestino = $stmt->fetch();

            if (!$cuentaDestino) {
                throw new Exception("La cuenta de destino no existe o no se encuentra activa en el sistema.");
            }

            // 3. Obtener nombre del socio destino (para mensaje visual de éxito)
            $stmt = $pdo->prepare("SELECT nombre, apellido FROM socios WHERE id = ?");
            $stmt->execute([$cuentaDestino['socio_id']]);
            $socioDestino = $stmt->fetch();
            $nombre_destino = $socioDestino ? $socioDestino['nombre'] . ' ' . $socioDestino['apellido'] : 'Socio Desconocido';

            // 4. Actualizar Saldos
            // Restar a origen
            $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo - ? WHERE id = ?");
            $stmt->execute([$monto, $cuentaOrigen['id']]);

            // Sumar a destino
            $stmt = $pdo->prepare("UPDATE cuentas SET saldo = saldo + ? WHERE id = ?");
            $stmt->execute([$monto, $cuentaDestino['id']]);

            // 5. Registrar Transacciones Históricas
            // Registro Origen (Transferencia Saliente)
            $descOrigen = "Transferencia enviada a Cta. " . $numero_cuenta_destino . " (" . $nombre_destino . ")";
            $stmt = $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, descripcion, fecha) VALUES (?, 'transferencia', ?, ?, NOW())");
            $stmt->execute([$cuentaOrigen['id'], $monto, $descOrigen]);

            // Registro Destino (Transferencia Entrante)
            // La registramos como 'transferencia' (o 'deposito' según se convenga, usaremos 'transferencia' indicando que fue recibida)
            $descDestino = "Transferencia recibida de Cta. " . $cuentaOrigen['numero_cuenta'] . " (" . $nombre_completo . ")";
            $stmt = $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, descripcion, fecha) VALUES (?, 'transferencia', ?, ?, NOW())");
            $stmt->execute([$cuentaDestino['id'], $monto, $descDestino]);

            // Confirmar Transacción Segura
            $pdo->commit();

            $mensaje = "Exito! Transferencia de " . formatCurrency($monto) . " enviada correctamente a " . $nombre_destino . ".";
            $tipo_mensaje = "exito";

        } catch (Exception $e) {
            $pdo->rollBack();
            $mensaje = $e->getMessage();
            $tipo_mensaje = "error";
        }
    }
}

// Obtener las Cuentas del Socio para el listado desplegable
$stmt = $pdo->prepare("SELECT id, numero_cuenta, saldo FROM cuentas WHERE socio_id = ? AND estado = 'activa' AND tipo = 'ahorro'");
$stmt->execute([$socio_id]);
$misCuentas = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Transferencia | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
        }
        .form-select, .form-input-lg {
            width: 100%;
            padding: 16px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-md);
            font-size: 1.1rem;
            color: var(--text-dark);
            background-color: #f8fafc;
            transition: var(--transition-fast);
            margin-bottom: 24px;
        }
        .form-select:focus, .form-input-lg:focus {
            outline: none;
            border-color: var(--secondary-color);
            background-color: var(--white);
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
        
        .transfer-panel {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
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
                <li class="active">
                    <a href="transferencias.php"><i class="ph ph-arrows-left-right"></i> Transferencias</a>
                </li>
                <li>
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Centro de Transferencias</div>
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
                    <h1 style="font-size: 2.2rem; margin-bottom: 8px;">Enviar Dinero</h1>
                    <p>Mueva sus fondos de forma segura hacia otras cuentas de la cooperativa.</p>
                </div>

                <!-- Formulario de Transferencia -->
                <div class="transfer-panel">
                    
                    <?php if(!empty($mensaje)): ?>
                        <div class="alert-box <?php echo $tipo_mensaje === 'exito' ? 'alert-success' : 'alert-error'; ?>">
                            <i class="<?php echo $tipo_mensaje === 'exito' ? 'ph-fill ph-check-circle' : 'ph-fill ph-warning-circle'; ?>" style="font-size: 1.5rem;"></i>
                            <div><?php echo htmlspecialchars($mensaje); ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="glass-panel" style="padding: 40px;">
                        <form action="transferencias.php" method="POST" id="transferForm">
                            
                            <label class="form-label" for="cuenta_origen">Cuenta de Origen (A Debitar)</label>
                            <div style="position: relative;">
                                <i class="ph ph-wallet" style="position: absolute; left: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                                <select name="cuenta_origen" id="cuenta_origen" class="form-select" style="padding-left: 48px; appearance: none; -webkit-appearance: none;" required>
                                    <option value="" disabled selected>Seleccione una cuenta de ahorro...</option>
                                    <?php foreach($misCuentas as $cuenta): ?>
                                        <option value="<?php echo $cuenta['id']; ?>">
                                            Cta: <?php echo htmlspecialchars($cuenta['numero_cuenta']); ?> (Disponible: <?php echo formatCurrency($cuenta['saldo']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="ph ph-caret-down" style="position: absolute; right: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                            </div>

                            <div style="text-align: center; margin-top: -10px; margin-bottom: 14px;">
                                <div style="display: inline-flex; background: #e2e8f0; border-radius: 50%; padding: 8px; color: var(--primary-color);">
                                    <i class="ph ph-arrow-down" style="font-size: 1.2rem;"></i>
                                </div>
                            </div>

                            <label class="form-label" for="cuenta_destino">Nro. de Cuenta Destino</label>
                            <div style="position: relative;">
                                <i class="ph ph-bank" style="position: absolute; left: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem;"></i>
                                <input type="text" name="cuenta_destino" id="cuenta_destino" class="form-input-lg" style="padding-left: 48px;" placeholder="Ej. 102938475" required autocomplete="off">
                            </div>

                            <label class="form-label">Monto a Enviar (Gs.)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 16px; top: 18px; font-weight: 700; color: var(--primary-color); font-size: 1.1rem;">Gs.</span>
                                <input type="number" name="monto" id="monto" class="form-input-lg" style="padding-left: 56px; font-size: 1.5rem; font-weight: 700; color: var(--primary-color);" placeholder="0" min="1" step="1" required>
                            </div>

                            <div style="background-color: #f8fafc; padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 0.85rem; color: var(--text-light); display: flex; gap: 12px; align-items: flex-start;">
                                <i class="ph-fill ph-shield-check" style="font-size: 1.5rem; color: var(--secondary-color);"></i>
                                <div>
                                    <strong style="color: var(--text-dark);">Transferencia Asegurada</strong>
                                    <p style="margin-top: 4px;">Tus transacciones están protegidas y encriptadas. Asegúrate de verificar el número de cuenta antes de proceder.</p>
                                </div>
                            </div>

                            <button type="submit" name="btn_transferir" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <i class="ph-fill ph-paper-plane-tilt"></i> Ejecutar Transferencia
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
        </main>
    </div>

    <script>
        // Formateo de monto (opcional para UX visual, aunque el type number limita caracteres no númericos)
        
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

        document.getElementById('transferForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Procesando Transacción...';
            btn.style.opacity = '0.8';
        });
    </script>
    <script src="assets/js/notificaciones.js?v=1.1"></script>
</body>
</html>
