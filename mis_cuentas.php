<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

// Obtener todas las Cuentas del Socio
$stmt = $pdo->prepare("SELECT id, numero_cuenta, tipo, saldo, estado FROM cuentas WHERE socio_id = ? ORDER BY id ASC");
$stmt->execute([$socio_id]);
$misCuentas = $stmt->fetchAll();

// Sumar Patrimonio Total
$patrimonio_total = 0;
foreach ($misCuentas as $c) {
    if ($c['estado'] === 'activa') {
        $patrimonio_total += $c['saldo'];
    }
}

// Obtener Movimientos Acumulados de TODAS las cuentas de este socio
// Estilo Banca Moderna (Timeline consolidado)
$stmtM = $pdo->prepare("
    SELECT t.fecha, t.tipo, t.monto, t.descripcion, c.numero_cuenta, c.tipo as tipo_cuenta 
    FROM transacciones t 
    JOIN cuentas c ON t.cuenta_id = c.id 
    WHERE c.socio_id = ? 
    ORDER BY t.fecha DESC 
    LIMIT 30
");
$stmtM->execute([$socio_id]);
$movimientos = $stmtM->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cuentas | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .card-cuenta {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-radius: 16px;
            padding: 24px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.1);
            transition: transform 0.3s ease;
        }
        .card-cuenta:hover {
            transform: translateY(-5px);
        }
        .card-cuenta::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
            border-radius: 50%;
        }
        .card-cuenta.tipo-corriente {
            background: linear-gradient(135deg, #0f4a7c, #0d3259);
        }
        .card-cuenta.estado-bloqueada {
            background: linear-gradient(135deg, #7f1d1d, #450a0a);
            opacity: 0.8;
        }
        /* Chips */
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .chip-activa { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .chip-bloqueada { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }
        .chip-cerrada { background: rgba(100, 116, 139, 0.3); color: #94a3b8; }
        
        .transaction-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
        }
        .transaction-item:hover {
            background-color: #f8fafc;
        }
        .t-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 16px;
        }
        .t-ingreso .t-icon { background: rgba(16, 185, 129, 0.1); color: var(--secondary-color); }
        .t-salida .t-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .t-ingreso .t-monto { color: var(--secondary-color); font-weight: 700; }
        .t-salida .t-monto { color: var(--text-dark); font-weight: 700; }
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
                <li class="active">
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Cuentas y Depósitos</div>
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
                
                <!-- Resumen Total de Patrimonio -->
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <h1 style="font-size: 2.2rem; margin-bottom: 4px;">Mis Cuentas</h1>
                        <p style="color: var(--text-light);">Administra tus fondos, tarjetas digitales y rastrea tu historial.</p>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.9rem; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Patrimonio Líquido Total</div>
                        <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color);"><?php echo formatCurrency($patrimonio_total); ?></div>
                    </div>
                </div>

                <!-- Tarjetas de Mis Cuentas -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; margin-bottom: 40px;">
                    <?php if(count($misCuentas) > 0): ?>
                        <?php foreach($misCuentas as $c): ?>
                            <div class="card-cuenta <?php echo 'tipo-' . strtolower($c['tipo']); ?> <?php echo 'estado-' . strtolower($c['estado']); ?>">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                                    <div style="display: flex; align-items: center; gap: 8px; font-weight: 500; opacity: 0.9;">
                                        <i class="ph-fill ph-sim-card" style="font-size: 2rem; color: #cbd5e1;"></i>
                                        Cuenta de <?php echo ucfirst(htmlspecialchars($c['tipo'])); ?>
                                    </div>
                                    <span class="chip chip-<?php echo strtolower($c['estado']); ?>">
                                        <i class="ph-fill ph-circle" style="font-size: 0.4rem; margin-right: 4px;"></i> <?php echo htmlspecialchars($c['estado']); ?>
                                    </span>
                                </div>
                                <div style="font-size: 1.4rem; letter-spacing: 2px; margin-bottom: 24px; font-family: monospace; font-weight: 600;">
                                    <?php echo htmlspecialchars($c['numero_cuenta']); ?>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                    <div>
                                        <div style="font-size: 0.75rem; text-transform: uppercase; opacity: 0.8; margin-bottom: 4px;">Balance Disponible</div>
                                        <div style="font-weight: 800; font-size: 1.5rem;">
                                            <?php echo formatCurrency($c['saldo']); ?>
                                        </div>
                                    </div>
                                    <i class="ph-fill ph-contactless-payment" style="font-size: 2rem; opacity: 0.7;"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="glass-panel" style="padding: 40px; text-align: center; grid-column: 1 / -1;">
                            <i class="ph ph-wallet" style="font-size: 4rem; color: var(--text-light); margin-bottom: 16px;"></i>
                            <h3 style="margin-bottom: 8px;">No posee cuentas comerciales</h3>
                            <p style="color: var(--text-light);">Usted no es titular de ninguna Caja de Ahorro activa. Solicite habilitar una en ventanilla.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Historial Global Intercalado -->
                <div class="glass-panel" style="padding: 32px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <div>
                            <h2 style="font-size: 1.5rem; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                                <i class="ph-fill ph-list-magnifying-glass" style="color: var(--primary-color);"></i> Extracto Combinado de Movimientos
                            </h2>
                            <p style="font-size: 0.9rem; color: var(--text-light);">Historial en tiempo real de entradas y salidas de todas sus cuentas.</p>
                        </div>
                        <button class="btn btn-outline" style="border-radius: var(--radius-full); padding: 8px 16px; font-size: 0.85rem;"><i class="ph ph-download-simple"></i> Descargar PDF</button>
                    </div>

                    <div style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <?php if(count($movimientos) > 0): ?>
                            <?php foreach($movimientos as $m): 
                                $es_ingreso = ($m['tipo'] === 'deposito' || (strpos(strtolower($m['descripcion']), 'recibida') !== false));
                                // Un poco de lógica por si las transferencias restadas tienen tipo 'transferencia' u otro.
                                // Idealmente un depósito suma, retiro resta, y transferencia depende. (Mi lógica de transferencias ya define bien las keywords).
                                if ($m['tipo'] === 'retiro') $es_ingreso = false;
                                if ($m['tipo'] === 'transferencia' && strpos(strtolower($m['descripcion']), 'enviada') !== false) {
                                    $es_ingreso = false;
                                }

                                $claseFila = $es_ingreso ? 't-ingreso' : 't-salida';
                                $icono = $es_ingreso ? 'ph-arrow-down-left' : 'ph-arrow-up-right';
                            ?>
                                <div class="transaction-item <?php echo $claseFila; ?>">
                                    <div style="display: flex; align-items: center;">
                                        <div class="t-icon">
                                            <i class="ph-bold <?php echo $icono; ?>"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-dark); margin-bottom: 2px;">
                                                <?php echo htmlspecialchars($m['descripcion']); ?>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 12px; font-size: 0.8rem; color: var(--text-light);">
                                                <span><i class="ph ph-calendar-blank"></i> <?php echo date('d/M/Y H:i', strtotime($m['fecha'])); ?></span>
                                                <span style="display: flex; align-items: center; gap: 4px;">
                                                    <i class="ph-fill ph-wallet"></i> Desde Cta: <?php echo htmlspecialchars($m['numero_cuenta']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="t-monto">
                                            <?php echo ($es_ingreso ? '+ ' : '- ') . formatCurrency($m['monto']); ?>
                                        </div>
                                        <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); margin-top: 4px;">
                                            COMPLETADO
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 40px; text-align: center; color: var(--text-light);">
                                <i class="ph-fill ph-wind" style="font-size: 3rem; margin-bottom: 12px; opacity: 0.5;"></i>
                                <p>Aún no posees transacciones en tu historial financiero.</p>
                            </div>
                        <?php endif; ?>
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
