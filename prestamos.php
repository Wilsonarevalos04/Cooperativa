<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

$mensaje = '';
$tipo_mensaje = '';

// Procesar Formulario de Solicitud de Préstamo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_solicitar'])) {
    $monto_solicitado = (float) str_replace(['Gs.', '.', ','], '', $_POST['monto_solicitado']);
    $plazo_meses = (int) $_POST['plazo_meses'];
    $interes_base = 15.00; // Tasa de interes por defecto simulada (15%)

    if ($monto_solicitado < 500000) {
        $mensaje = "El monto mínimo para solicitar un préstamo es de Gs. 500.000.";
        $tipo_mensaje = "error";
    } elseif ($plazo_meses < 1 || $plazo_meses > 60) {
        $mensaje = "El plazo debe ser entre 1 y 60 meses.";
        $tipo_mensaje = "error";
    } else {
        try {
            $pdo->beginTransaction();
            
            // --- INICIO MOTOR DE SCORING ---
            $score = 50; // Puntaje base
            $rechazado = false;
            $motivo_rechazo = "";

            // 1. Validar Morosidad (Si tiene alguna cuota atrasada)
            $stmtMoro = $pdo->prepare("SELECT COUNT(*) as atrasados FROM cuotas c JOIN prestamos p ON c.prestamo_id = p.id WHERE p.socio_id = ? AND c.estado = 'atrasado'");
            $stmtMoro->execute([$socio_id]);
            $morosidad = $stmtMoro->fetch();
            if ($morosidad['atrasados'] > 0) {
                $rechazado = true;
                $motivo_rechazo = "Historial Crediticio Negativo: Posee cuotas en estado de atraso.";
            }

            // 2. Validar Capacidad de Ahorro (Garantía del 10%)
            $stmtAhorro = $pdo->prepare("SELECT SUM(saldo) as saldo_total FROM cuentas WHERE socio_id = ? AND estado = 'activa'");
            $stmtAhorro->execute([$socio_id]);
            $ahorros = $stmtAhorro->fetch();
            $saldo_total = $ahorros['saldo_total'] ?? 0;
            
            if (!$rechazado) {
                if ($saldo_total < ($monto_solicitado * 0.10)) {
                    $rechazado = true;
                    $motivo_rechazo = "Falta de Garantía Financiera: Sus ahorros no cubren el encaje del 10% requerido (Usted posee " . formatCurrency($saldo_total) . " ahorrado).";
                } else {
                    $score += 20; // Buen aval
                }
            }

            // 3. Validar Sobre-endeudamiento (Préstamos vigentes)
            $stmtDeudas = $pdo->prepare("SELECT COUNT(*) as prestamos_activos FROM prestamos WHERE socio_id = ? AND estado = 'aprobado'");
            $stmtDeudas->execute([$socio_id]);
            $deuda = $stmtDeudas->fetch();
            if ($deuda['prestamos_activos'] >= 2) {
                $score -= 30; // Castigo por ya tener múltiples operaciones abiertas
            }
            if ($score < 60 && !$rechazado) {
                $rechazado = true;
                $motivo_rechazo = "Riesgo de Endeudamiento: Su perfil de riesgo es alto. Ya posee préstamos múltiples.";
            }
            // --- FIN MOTOR DE SCORING ---

            if ($rechazado) {
                // Registrar solicitud como rechazada para historial
                $stmt = $pdo->prepare("INSERT INTO prestamos (socio_id, monto, interes, plazo_meses, estado, fecha_solicitud) VALUES (?, ?, ?, ?, 'rechazado', NOW())");
                $stmt->execute([$socio_id, $monto_solicitado, $interes_base, $plazo_meses]);
                
                $pdo->commit();
                
                $mensaje = "Solicitud Denegada. Motivo: " . $motivo_rechazo;
                $tipo_mensaje = "error";
            } else {
                // Insertar solicitud aprobada (Score >= 60)
                $stmt = $pdo->prepare("INSERT INTO prestamos (socio_id, monto, interes, plazo_meses, estado, fecha_solicitud) VALUES (?, ?, ?, ?, 'aprobado', NOW())");
                $stmt->execute([$socio_id, $monto_solicitado, $interes_base, $plazo_meses]);
                $prestamo_id = $pdo->lastInsertId();
                
                // Calcular cuota fija mensual aproximada
                $monto_total_con_interes = $monto_solicitado + ($monto_solicitado * ($interes_base / 100));
                $monto_cuota = $monto_total_con_interes / $plazo_meses;
                
                $stmtCuota = $pdo->prepare("INSERT INTO cuotas (prestamo_id, numero_cuota, monto, fecha_vencimiento, estado) VALUES (?, ?, ?, ?, 'pendiente')");
                for ($i = 1; $i <= $plazo_meses; $i++) {
                    $fecha_vencimiento = date('Y-m-d', strtotime("+$i months"));
                    $stmtCuota->execute([$prestamo_id, $i, $monto_cuota, $fecha_vencimiento]);
                }
                
                $stmtCta = $pdo->prepare("SELECT id FROM cuentas WHERE socio_id = ? AND estado = 'activa' LIMIT 1");
                $stmtCta->execute([$socio_id]);
                $cta = $stmtCta->fetch();
                if ($cta) {
                    $pdo->prepare("UPDATE cuentas SET saldo = saldo + ? WHERE id = ?")->execute([$monto_solicitado, $cta['id']]);
                    $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, descripcion, fecha) VALUES (?, 'deposito', ?, ?, NOW())")
                        ->execute([$cta['id'], $monto_solicitado, 'Desembolso de Préstamo Aprobado #' . $prestamo_id]);
                }
                
                $pdo->commit();
                
                $mensaje = "¡Felicidades! Evaluación Positiva (Score: " . $score . " pts). Préstamo aprobado y fondos depositados en tu cuenta.";
                $tipo_mensaje = "exito";
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $mensaje = "Error al registrar la solicitud: " . $e->getMessage();
            $tipo_mensaje = "error";
        }
    }
}

// Obtener los préstamos del socio
$stmt = $pdo->prepare("SELECT * FROM prestamos WHERE socio_id = ? ORDER BY fecha_solicitud DESC");
$stmt->execute([$socio_id]);
$misPrestamos = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Préstamos | Cooperativa Futuro</title>
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
        
        .badge-estado {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .bg-pendiente { background: rgba(247, 169, 22, 0.1); color: var(--accent-color); }
        .bg-aprobado { background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); }
        .bg-rechazado { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .bg-pagado { background: rgba(100, 116, 139, 0.1); color: #64748b; }
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
                <li class="active">
                    <a href="prestamos.php"><i class="ph ph-bank"></i> Préstamos Vigentes</a>
                </li>
                <li>
                    <a href="ahorros_programados.php"><i class="ph ph-calendar-check"></i> Ahorros Programados</a>
                </li>
                
                <li style="padding: 24px 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Operaciones</li>
                <li>
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Gestión de Préstamos</div>
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
                
                <?php if(!empty($mensaje)): ?>
                    <div class="alert-box <?php echo $tipo_mensaje === 'exito' ? 'alert-success' : 'alert-error'; ?>" style="max-width: 900px; margin: 0 auto 24px;">
                        <i class="<?php echo $tipo_mensaje === 'exito' ? 'ph-fill ph-check-circle' : 'ph-fill ph-warning-circle'; ?>" style="font-size: 1.5rem;"></i>
                        <div><?php echo htmlspecialchars($mensaje); ?></div>
                    </div>
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
                    
                    <!-- Solicitar Préstamo -->
                    <div class="glass-panel" style="padding: 32px;">
                        <h2 style="margin-bottom: 24px; font-size: 1.5rem; display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-hand-coins" style="color: var(--secondary-color);"></i> Nueva Solicitud
                        </h2>
                        
                        <form action="prestamos.php" method="POST">
                            <label class="form-label" for="monto_solicitado">¿Cuánto dinero necesitas?</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 16px; top: 18px; font-weight: 700; color: var(--primary-color); font-size: 1.1rem;">Gs.</span>
                                <input type="number" name="monto_solicitado" id="monto_solicitado" class="form-input-lg" style="padding-left: 56px; font-size: 1.5rem; font-weight: 700; color: var(--primary-color);" placeholder="500000" min="500000" step="100000" required>
                            </div>

                            <label class="form-label" for="plazo_meses">Plazo de Pago (Meses)</label>
                            <div style="position: relative;">
                                <i class="ph ph-calendar" style="position: absolute; left: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                                <select name="plazo_meses" id="plazo_meses" class="form-select" style="padding-left: 48px; appearance: none; -webkit-appearance: none;" required>
                                    <option value="" disabled selected>Seleccione plazo deseado...</option>
                                    <option value="6">6 Meses</option>
                                    <option value="12">12 Meses</option>
                                    <option value="18">18 Meses</option>
                                    <option value="24">24 Meses</option>
                                    <option value="36">36 Meses</option>
                                    <option value="48">48 Meses</option>
                                </select>
                                <i class="ph ph-caret-down" style="position: absolute; right: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                            </div>

                            <div style="background-color: #f8fafc; padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 0.85rem; color: var(--text-light);">
                                * La tasa de interés referencial actual es de 15% (Efectiva Anual). Toda solicitud está sujeta a revisión y aprobación por la mesa directiva.
                            </div>

                            <button type="submit" name="btn_solicitar" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <i class="ph-fill ph-paper-plane-tilt"></i> Enviar a Revisión
                            </button>
                        </form>
                    </div>

                    <!-- Mi Historial de Préstamos -->
                    <div class="glass-panel" style="padding: 32px; display: flex; flex-direction: column;">
                        <h2 style="margin-bottom: 24px; font-size: 1.5rem; display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-clock-counter-clockwise" style="color: var(--primary-color);"></i> Historial de Préstamos
                        </h2>
                        
                        <div class="table-container" style="flex: 1; overflow-y: auto;">
                            <?php if(count($misPrestamos) > 0): ?>
                                <table class="r-table">
                                    <thead>
                                        <tr>
                                            <th>Detalle</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($misPrestamos as $p): ?>
                                        <tr>
                                            <td>
                                                <div style="font-weight: 700; color: var(--primary-color); font-size: 1.1rem;">
                                                    <?php echo formatCurrency($p['monto']); ?>
                                                </div>
                                                <div style="font-size: 0.8rem; color: var(--text-light);">
                                                    Plazo: <?php echo $p['plazo_meses']; ?> meses <br>
                                                    Solicitado: <?php echo date('d/M/Y', strtotime($p['fecha_solicitud'])); ?>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="badge-estado bg-<?php echo strtolower($p['estado']); ?>">
                                                    <?php echo htmlspecialchars($p['estado']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div style="text-align: center; color: var(--text-light); padding: 40px 0;">
                                    <i class="ph ph-files" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                                    <p>Aún no tienes un historial de préstamos en la base de datos.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
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
