<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

$mensaje = '';
$tipo_mensaje = '';

// Procesar Formulario de Ahorro Programado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_activar'])) {
    $monto_mensual = (float) str_replace(['Gs.', '.', ','], '', $_POST['monto_mensual']);
    $plazo_meses = (int) $_POST['plazo_meses'];
    $cuenta_origen_id = (int) $_POST['cuenta_origen'];
    
    if ($monto_mensual < 50000) {
        $mensaje = "El monto mensual mínimo para un ahorro programado es de Gs. 50.000.";
        $tipo_mensaje = "error";
    } elseif ($plazo_meses < 6 || $plazo_meses > 48) {
        $mensaje = "El plazo seleccionado no es válido (debe ser entre 6 y 48 meses).";
        $tipo_mensaje = "error";
    } else {
        try {
            $pdo->beginTransaction();
            
            // 1. Verificar Cuenta Origen
            $stmt = $pdo->prepare("SELECT id, saldo, numero_cuenta FROM cuentas WHERE id = ? AND socio_id = ? AND estado = 'activa' FOR UPDATE");
            $stmt->execute([$cuenta_origen_id, $socio_id]);
            $cuenta = $stmt->fetch();
            
            if (!$cuenta) {
                throw new Exception("La cuenta seleccionada no es válida o no está activa.");
            }
            
            if ($cuenta['saldo'] < $monto_mensual) {
                throw new Exception("Saldo insuficiente en su caja de ahorro. Saldo actual: " . formatCurrency($cuenta['saldo']));
            }
            
            // 2. Ejecutar Descuento del primer mes
            $stmtUpdate = $pdo->prepare("UPDATE cuentas SET saldo = saldo - ? WHERE id = ?");
            $stmtUpdate->execute([$monto_mensual, $cuenta['id']]);
            
            // 3. Crear Plan de Ahorro Programado
            $stmtInsert = $pdo->prepare("INSERT INTO ahorros_programados (socio_id, monto_mensual, plazo_meses, fecha_inicio, estado) VALUES (?, ?, ?, CURDATE(), 'activo')");
            $stmtInsert->execute([$socio_id, $monto_mensual, $plazo_meses]);
            $ahorro_id = $pdo->lastInsertId();
            
            // 4. Registrar Transacción Histórica
            $descripcion = "Débito Apertura Ahorro Programado #" . $ahorro_id;
            $stmtTx = $pdo->prepare("INSERT INTO transacciones (cuenta_id, tipo, monto, descripcion, fecha) VALUES (?, 'retiro', ?, ?, NOW())");
            $stmtTx->execute([$cuenta['id'], $monto_mensual, $descripcion]);
            
            // 5. Crear Notificación
            $tituloNotif = "Ahorro Programado Creado";
            $mensajeNotif = "Se ha activado su plan de Ahorro Programado #" . $ahorro_id . " por " . formatCurrency($monto_mensual) . " mensual a " . $plazo_meses . " meses. Se debitó el primer mes de la Cta. " . $cuenta['numero_cuenta'];
            $stmtNotif = $pdo->prepare("INSERT INTO notificaciones (socio_id, titulo, mensaje) VALUES (?, ?, ?)");
            $stmtNotif->execute([$socio_id, $tituloNotif, $mensajeNotif]);
            
            $pdo->commit();
            
            $mensaje = "¡Felicidades! Su plan de ahorro programado ha sido activado con éxito. Se debitó " . formatCurrency($monto_mensual) . " de su Caja de Ahorro.";
            $tipo_mensaje = "exito";
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $mensaje = $e->getMessage();
            $tipo_mensaje = "error";
        }
    }
}

// Obtener todos los planes del socio
$stmt = $pdo->prepare("SELECT * FROM ahorros_programados WHERE socio_id = ? ORDER BY fecha_inicio DESC");
$stmt->execute([$socio_id]);
$misPlanes = $stmt->fetchAll();

$planesActivosCount = 0;
$totalAcumulado = 0;
$siguienteAporte = 0;

foreach ($misPlanes as &$plan) {
    if ($plan['estado'] === 'activo') {
        $planesActivosCount++;
        $siguienteAporte += $plan['monto_mensual'];
    }
    
    // Calcular meses transcurridos desde fecha_inicio
    $fechaInicio = strtotime($plan['fecha_inicio']);
    $hoy = time();
    
    $years = date('Y', $hoy) - date('Y', $fechaInicio);
    $months = date('m', $hoy) - date('m', $fechaInicio);
    $mesesTranscurridos = ($years * 12) + $months + 1; // +1 porque el primer mes se cobra al inicio
    if ($mesesTranscurridos < 1) $mesesTranscurridos = 1;
    
    $plan['meses_transcurridos'] = min($plan['plazo_meses'], $mesesTranscurridos);
    $plan['acumulado'] = $plan['monto_mensual'] * $plan['meses_transcurridos'];
    $plan['porcentaje_progreso'] = ($plan['meses_transcurridos'] / $plan['plazo_meses']) * 100;
    
    if ($plan['estado'] !== 'cancelado') {
        $totalAcumulado += $plan['acumulado'];
    }
}
unset($plan);

// Obtener Cuentas Activas de Ahorro para débito
$stmt = $pdo->prepare("SELECT id, numero_cuenta, saldo FROM cuentas WHERE socio_id = ? AND estado = 'activa' AND tipo = 'ahorro'");
$stmt->execute([$socio_id]);
$misCuentas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorros Programados | Cooperativa Futuro</title>
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
        
        .plan-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            background: white;
            transition: var(--transition-normal);
            margin-bottom: 20px;
        }
        .plan-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .progress-bar-container {
            width: 100%;
            height: 10px;
            background-color: #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
            margin: 12px 0;
        }
        .progress-bar {
            height: 100%;
            background-color: var(--secondary-color);
            border-radius: 5px;
            transition: width 0.3s ease;
        }
        
        .badge-estado {
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-activo { background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); }
        .badge-finalizado { background: rgba(100, 116, 139, 0.1); color: #64748b; }
        .badge-cancelado { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
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
                <li class="active">
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
                    <a href="#"><i class="ph ph-user-circle"></i> Mi Perfil</a>
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Ahorros Programados</div>
                </div>
                
                <div class="user-profile">
                    <button style="background: none; border: none; font-size: 1.5rem; color: var(--text-light); cursor: pointer; position: relative;">
                        <i class="ph ph-bell"></i>
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
                
                <div class="page-title" style="margin-bottom: 32px;">
                    <h1 style="font-size: 2.2rem; margin-bottom: 4px;">Ahorro Programado</h1>
                    <p style="color: var(--text-light);">Asegura tus metas financieras con un ahorro sistemático y constante debitado automáticamente de tus cuentas.</p>
                </div>

                <?php if(!empty($mensaje)): ?>
                    <div class="alert-box <?php echo $tipo_mensaje === 'exito' ? 'alert-success' : 'alert-error'; ?>" style="max-width: 1100px; margin-bottom: 24px;">
                        <i class="<?php echo $tipo_mensaje === 'exito' ? 'ph-fill ph-check-circle' : 'ph-fill ph-warning-circle'; ?>" style="font-size: 1.5rem;"></i>
                        <div><?php echo htmlspecialchars($mensaje); ?></div>
                    </div>
                <?php endif; ?>

                <!-- Tarjetas de Resumen -->
                <div class="summary-grid" style="margin-bottom: 32px;">
                    <div class="glass-panel summary-card accent-green">
                        <i class="ph-fill ph-calendar-check card-icon"></i>
                        <div class="card-title">Planes Activos</div>
                        <div class="card-amount"><?php echo $planesActivosCount; ?></div>
                        <div style="font-size: 0.85rem; color: var(--secondary-color); font-weight: 500;">
                            Planes en curso
                        </div>
                    </div>
                    
                    <div class="glass-panel summary-card accent-blue">
                        <i class="ph-fill ph-chart-line-up card-icon"></i>
                        <div class="card-title">Total Ahorrado Acumulado</div>
                        <div class="card-amount"><?php echo formatCurrency($totalAcumulado); ?></div>
                        <div style="font-size: 0.85rem; color: var(--primary-color); font-weight: 500;">
                            Capital acumulado en planes
                        </div>
                    </div>

                    <div class="glass-panel summary-card accent-gold">
                        <i class="ph-fill ph-arrows-down card-icon"></i>
                        <div class="card-title">Siguiente Aporte Total</div>
                        <div class="card-amount"><?php echo formatCurrency($siguienteAporte); ?></div>
                        <div style="font-size: 0.85rem; color: var(--accent-color); font-weight: 500;">
                            Suma de aportes mensuales
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal: Grid de 2 Columnas -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 32px; align-items: start;">
                    
                    <!-- Columna 1: Listado de Planes de Ahorro -->
                    <div class="glass-panel" style="padding: 32px;">
                        <h2 style="margin-bottom: 24px; font-size: 1.4rem; display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-folder-open" style="color: var(--primary-color);"></i> Mis Planes de Ahorro
                        </h2>
                        
                        <?php if (count($misPlanes) > 0): ?>
                            <?php foreach ($misPlanes as $p): ?>
                                <div class="plan-card">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                        <div>
                                            <h3 style="font-size: 1.15rem; color: var(--primary-color);">Ahorro Programado #<?php echo $p['id']; ?></h3>
                                            <p style="font-size: 0.85rem; color: var(--text-light); margin-top: 2px;">Iniciado el <?php echo date('d/m/Y', strtotime($p['fecha_inicio'])); ?></p>
                                        </div>
                                        <span class="badge-estado badge-<?php echo strtolower($p['estado']); ?>">
                                            <?php echo htmlspecialchars($p['estado']); ?>
                                        </span>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; font-size: 0.9rem;">
                                        <div>
                                            <span style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase;">Aporte Mensual</span>
                                            <div style="font-weight: 700; color: var(--primary-color); font-size: 1.1rem; margin-top: 2px;"><?php echo formatCurrency($p['monto_mensual']); ?></div>
                                        </div>
                                        <div>
                                            <span style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase;">Total Acumulado</span>
                                            <div style="font-weight: 800; color: var(--secondary-color); font-size: 1.15rem; margin-top: 2px;"><?php echo formatCurrency($p['acumulado']); ?></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">
                                            <span>Progreso de Ahorro</span>
                                            <span>Mes <?php echo $p['meses_transcurridos']; ?> de <?php echo $p['plazo_meses']; ?></span>
                                        </div>
                                        <div class="progress-bar-container">
                                            <div class="progress-bar" style="width: <?php echo min(100, $p['porcentaje_progreso']); ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; color: var(--text-light); padding: 48px 0;">
                                <i class="ph ph-calendar-check" style="font-size: 4rem; opacity: 0.4; margin-bottom: 16px;"></i>
                                <h3 style="color: var(--text-dark); margin-bottom: 8px;">No posee planes activos</h3>
                                <p>Actualmente no está suscrito a ningún plan de ahorro mensual programado.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Columna 2: Crear Nuevo Plan -->
                    <div class="glass-panel" style="padding: 32px;">
                        <h2 style="margin-bottom: 24px; font-size: 1.4rem; display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-plus-circle" style="color: var(--secondary-color);"></i> Activar Nuevo Plan
                        </h2>
                        
                        <form action="ahorros_programados.php" method="POST" id="ahorroForm">
                            
                            <label class="form-label" for="cuenta_origen">Débito Mensual desde Cuenta</label>
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

                            <label class="form-label" for="monto_mensual">Monto a Ahorrar Mensualmente</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 16px; top: 18px; font-weight: 700; color: var(--primary-color); font-size: 1.1rem;">Gs.</span>
                                <input type="number" name="monto_mensual" id="monto_mensual" class="form-input-lg" style="padding-left: 56px; font-size: 1.4rem; font-weight: 700; color: var(--primary-color);" placeholder="100000" min="50000" step="50000" required>
                            </div>

                            <label class="form-label" for="plazo_meses">Plazo del Plan (Meses)</label>
                            <div style="position: relative;">
                                <i class="ph ph-calendar" style="position: absolute; left: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                                <select name="plazo_meses" id="plazo_meses" class="form-select" style="padding-left: 48px; appearance: none; -webkit-appearance: none;" required>
                                    <option value="" disabled selected>Seleccione plazo del plan...</option>
                                    <option value="6">6 Meses (Corto Plazo)</option>
                                    <option value="12">12 Meses (1 Año)</option>
                                    <option value="18">18 Meses (1.5 Años)</option>
                                    <option value="24">24 Meses (2 Años)</option>
                                    <option value="36">36 Meses (3 Años)</option>
                                    <option value="48">48 Meses (4 Años)</option>
                                </select>
                                <i class="ph ph-caret-down" style="position: absolute; right: 16px; top: 18px; color: #94a3b8; font-size: 1.2rem; pointer-events: none;"></i>
                            </div>

                            <div style="background-color: #f8fafc; padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 0.85rem; color: var(--text-light); line-height: 1.4;">
                                <span style="font-weight: 600; color: var(--text-dark);">Información Importante:</span>
                                <p style="margin-top: 4px;">Al pulsar "Activar Plan", se realizará el primer débito automático de forma inmediata como cobro del mes en curso. Los aportes posteriores se realizarán de manera mensual automatizada.</p>
                            </div>

                            <button type="submit" name="btn_activar" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <i class="ph-fill ph-rocket-launch"></i> Activar Plan de Ahorro
                            </button>
                        </form>
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

        document.getElementById('ahorroForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Procesando Solicitud...';
            btn.style.opacity = '0.8';
        });
    </script>
    <script src="assets/js/notificaciones.js?v=1.1"></script>
</body>
</html>
