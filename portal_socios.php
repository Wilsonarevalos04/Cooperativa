<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

// 1. Obtener Saldo Total de Cuentas de Ahorro
$stmt = $pdo->prepare("SELECT SUM(saldo) as saldo_total FROM cuentas WHERE socio_id = ? AND estado != 'cerrada'");
$stmt->execute([$socio_id]);
$resSaldo = $stmt->fetch();
$saldoTotal = $resSaldo['saldo_total'] ?? 0;

// 2. Obtener Préstamos Activos
$stmt = $pdo->prepare("SELECT COUNT(id) as cant_prestamos, SUM(monto) as monto_prestamos FROM prestamos WHERE socio_id = ? AND estado = 'aprobado'");
$stmt->execute([$socio_id]);
$resPrestamos = $stmt->fetch();
$cantPrestamos = $resPrestamos['cant_prestamos'] ?? 0;
$montoPrestamos = $resPrestamos['monto_prestamos'] ?? 0;

// 3. Obtener Próxima Cuota a Vencer
$stmt = $pdo->prepare("
    SELECT c.monto, c.fecha_vencimiento 
    FROM cuotas c 
    JOIN prestamos p ON c.prestamo_id = p.id 
    WHERE p.socio_id = ? AND c.estado = 'pendiente' 
    ORDER BY c.fecha_vencimiento ASC LIMIT 1
");
$stmt->execute([$socio_id]);
$proximaCuota = $stmt->fetch();

// 4. Últimos Movimientos
$stmt = $pdo->prepare("
    SELECT t.fecha, t.descripcion, t.monto, t.tipo 
    FROM transacciones t 
    JOIN cuentas c ON t.cuenta_id = c.id 
    WHERE c.socio_id = ? 
    ORDER BY t.fecha DESC LIMIT 5
");
$stmt->execute([$socio_id]);
$transacciones = $stmt->fetchAll();

// 5. Detalles de un Préstamo Activo (para el widget de progreso si tiene préstamos)
$prestamoDetalle = null;
if ($cantPrestamos > 0) {
    $stmt = $pdo->prepare("SELECT id, plazo_meses FROM prestamos WHERE socio_id = ? AND estado = 'aprobado' LIMIT 1");
    $stmt->execute([$socio_id]);
    $prestamoObj = $stmt->fetch();

    if ($prestamoObj) {
        $pId = $prestamoObj['id'];
        $stmtCuotas = $pdo->prepare("SELECT COUNT(*) as pagadas FROM cuotas WHERE prestamo_id = ? AND estado = 'pagado'");
        $stmtCuotas->execute([$pId]);
        $pagadas = $stmtCuotas->fetch()['pagadas'] ?? 0;

        $prestamoDetalle = [
            'id' => $pId,
            'plazo' => $prestamoObj['plazo_meses'],
            'pagadas' => $pagadas,
            'porcentaje' => $prestamoObj['plazo_meses'] > 0 ? ($pagadas / $prestamoObj['plazo_meses']) * 100 : 0
        ];
        
        $stmtTabla = $pdo->prepare("SELECT numero_cuota, monto, fecha_vencimiento, estado FROM cuotas WHERE prestamo_id = ? ORDER BY numero_cuota ASC");
        $stmtTabla->execute([$pId]);
        $prestamoDetalle['cuotas'] = $stmtTabla->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Socios | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                <li class="active">
                    <a href="portal_socios.php"><i class="ph ph-squares-four"></i> Resumen</a>
                </li>
                <li>
                    <a href="mis_cuentas.php"><i class="ph ph-wallet"></i> Mis Cuentas</a>
                </li>
                <li>
                    <a href="prestamos.php"><i class="ph ph-bank"></i> Préstamos Vigentes</a>
                </li>
                <li>
                    <a href="#"><i class="ph ph-calendar-check"></i> Ahorros Programados</a>
                </li>
                
                <li style="padding: 24px 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Operaciones</li>
                <li>
                    <a href="transferencias.php"><i class="ph ph-arrows-left-right"></i> Transferencias</a>
                </li>
                <li>
                    <a href="pagar_cuotas.php"><i class="ph ph-receipt"></i> Pagar Cuotas</a>
                </li>
                <li>
                    <a href="#"><i class="ph ph-file-text"></i> Extractos</a>
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Bienvenido de nuevo, <?php echo htmlspecialchars($_SESSION['socio_nombre']); ?>!</div>
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
                <div class="page-title">
                    <h1 style="font-size: 1.8rem; margin-bottom: 4px;">Resumen Financiero</h1>
                    <p>Visualiza el estado actual de tus finanzas en la cooperativa.</p>
                </div>

                <!-- Tarjetas de Resumen -->
                <div class="summary-grid">
                    <div class="glass-panel summary-card accent-green">
                        <i class="ph-fill ph-wallet card-icon"></i>
                        <div class="card-title">Saldo en Cuentas (Ahorro)</div>
                        <div class="card-amount"><?php echo formatCurrency($saldoTotal); ?></div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 500; color: var(--secondary-color);">
                            <i class="ph ph-check-circle"></i> Saldo Total Disponible
                        </div>
                    </div>
                    
                    <div class="glass-panel summary-card accent-blue">
                        <i class="ph-fill ph-bank card-icon"></i>
                        <div class="card-title">Préstamos Activos (Deuda)</div>
                        <div class="card-amount"><?php echo formatCurrency($montoPrestamos); ?></div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 500; color: var(--primary-color);">
                            <?php echo $cantPrestamos; ?> Préstamo(s) vigente(s)
                        </div>
                    </div>

                    <div class="glass-panel summary-card accent-gold">
                        <i class="ph-fill ph-calendar-check card-icon"></i>
                        <div class="card-title">Próxima Cuota a Vencer</div>
                        <?php if ($proximaCuota): ?>
                            <div class="card-amount" style="font-size: 1.8rem;"><?php echo formatCurrency($proximaCuota['monto']); ?></div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; color: #ef4444; margin-top: 8px;">
                                <i class="ph ph-timer"></i> Vence el <?php echo date('d/m/Y', strtotime($proximaCuota['fecha_vencimiento'])); ?>
                            </div>
                        <?php
else: ?>
                            <div class="card-amount" style="font-size: 1.5rem;">Al día</div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; color: var(--secondary-color); margin-top: 8px;">
                                <i class="ph ph-check-circle"></i> No tienes cuotas pendientes
                            </div>
                        <?php
endif; ?>
                    </div>
                </div>

                <!-- Tablas de Información Detallada -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
                    
                    <!-- Últimas Transacciones -->
                    <div class="glass-panel" style="padding: 24px; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <h3 style="font-size: 1.2rem;">Últimos Movimientos</h3>
                            <a href="#" style="font-size: 0.85rem; font-weight: 600; color: var(--secondary-color);">Ver todos</a>
                        </div>
                        
                        <div class="table-container">
                            <table class="r-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($transacciones) > 0): ?>
                                        <?php foreach ($transacciones as $t): ?>
                                        <tr>
                                            <td><?php echo date('d/M/Y', strtotime($t['fecha'])); ?></td>
                                            <td>
                                                <div style="font-weight: 600; text-transform: capitalize;"><?php echo htmlspecialchars($t['descripcion']); ?></div>
                                                <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase;"><?php echo $t['tipo']; ?></div>
                                            </td>
                                            <?php if ($t['tipo'] === 'retiro'): ?>
                                                <td style="color: var(--text-dark); font-weight: 700;">- <?php echo formatCurrency($t['monto']); ?></td>
                                            <?php
        else: ?>
                                                <td style="color: var(--secondary-color); font-weight: 700;">+ <?php echo formatCurrency($t['monto']); ?></td>
                                            <?php
        endif; ?>
                                        </tr>
                                        <?php
    endforeach; ?>
                                    <?php
else: ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: var(--text-light);">No hay movimientos recientes.</td>
                                        </tr>
                                    <?php
endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Préstamos Activos -->
                    <div class="glass-panel" style="padding: 24px; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <h3 style="font-size: 1.2rem;">Estado de Préstamo</h3>
                        </div>
                        
                        <?php if ($prestamoDetalle): ?>
                            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                                    <div>
                                        <div style="font-weight: 700; color: var(--primary-color);">Préstamo Activo</div>
                                        <div style="font-size: 0.85rem; color: var(--text-light);">Crédito #<?php echo $prestamoDetalle['id']; ?></div>
                                    </div>
                                    <span class="badge badge-warning" style="align-self: flex-start; background: rgba(13, 40, 74, 0.1); color: var(--primary-color);">Activo</span>
                                </div>
                                
                                <div style="margin-bottom: 8px; display: flex; justify-content: space-between; font-size: 0.9rem;">
                                    <span style="font-weight: 600;">Progreso de Pagos</span>
                                    <span style="font-weight: 700; color: var(--secondary-color);">#<?php echo $prestamoDetalle['pagadas']; ?> de #<?php echo $prestamoDetalle['plazo']; ?></span>
                                </div>
                                
                                <!-- Barra de progreso -->
                                <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; margin-bottom: 24px; overflow: hidden;">
                                    <div style="width: <?php echo min(100, $prestamoDetalle['porcentaje']); ?>%; height: 100%; background: var(--secondary-color); border-radius: 4px;"></div>
                                </div>
                                
                                <div style="display: flex; gap: 12px;">
                                    <a href="pagar_cuotas.php" class="btn btn-primary" style="flex: 1; padding: 10px; font-size: 0.9rem;">Pagar Cuota</a>
                                    <button class="btn btn-outline" style="flex: 1; padding: 10px; font-size: 0.9rem;" onclick="document.getElementById('modalCalendario').style.display = 'flex';">Ver Calendario</button>
                                </div>
                            </div>
                        <?php
else: ?>
                            <div style="text-align: center; color: var(--text-light); padding: 40px 0;">
                                <i class="ph ph-bank" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                                <p>No tienes préstamos activos en este momento.</p>
                                <button class="btn btn-primary" style="margin-top: 16px;">Solicitar Préstamo</button>
                            </div>
                        <?php
endif; ?>
                    </div>
                </div>
                
            </div>
        </main>
    </div>

    <!-- Modal Calendario -->
    <?php if ($prestamoDetalle && isset($prestamoDetalle['cuotas'])): ?>
    <div id="modalCalendario" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 90%; max-width: 600px; border-radius: 16px; padding: 32px; max-height: 80vh; overflow-y: auto; position: relative; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <button onclick="document.getElementById('modalCalendario').style.display = 'none';" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-light); transition: color 0.2s;"><i class="ph ph-x"></i></button>
            <h2 style="margin-bottom: 24px; font-size: 1.5rem; display: flex; align-items: center; gap: 8px;">
                <i class="ph-fill ph-calendar" style="color: var(--primary-color);"></i> Calendario de Pagos
            </h2>
            <div class="table-container">
                <table class="r-table">
                    <thead>
                        <tr>
                            <th>Cuota</th>
                            <th>Monto</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prestamoDetalle['cuotas'] as $cuota): ?>
                        <tr>
                            <td style="font-weight: 700; color: var(--text-dark);">#<?php echo $cuota['numero_cuota']; ?></td>
                            <td style="font-weight: 600; color: var(--secondary-color);"><?php echo formatCurrency($cuota['monto']); ?></td>
                            <td><?php echo date('d/M/Y', strtotime($cuota['fecha_vencimiento'])); ?></td>
                            <td>
                                <?php if($cuota['estado'] === 'pagado'): ?>
                                    <span style="background: rgba(16,185,129,0.1); color: #10b981; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Pagado</span>
                                <?php elseif($cuota['estado'] === 'atrasado'): ?>
                                    <span style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Atrasado</span>
                                <?php else: ?>
                                    <span style="background: rgba(245,158,11,0.1); color: #f59e0b; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Pendiente</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 24px; text-align: center;">
                <a href="pagar_cuotas.php" class="btn btn-primary" style="padding: 10px 24px;">Ir al Centro de Pagos</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Logic to toggle sidebar on mobile
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
    <script src="assets/js/notificaciones.js"></script>
</body>
</html>
