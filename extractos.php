<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

// 1. Obtener todas las Cuentas del Socio para el filtro
$stmt = $pdo->prepare("SELECT id, numero_cuenta, tipo, saldo, estado FROM cuentas WHERE socio_id = ? ORDER BY id ASC");
$stmt->execute([$socio_id]);
$misCuentas = $stmt->fetchAll();

// Filtros por defecto
$cuenta_id = isset($_GET['cuenta_id']) ? $_GET['cuenta_id'] : 'todas';
$rango_fecha = isset($_GET['rango_fecha']) ? $_GET['rango_fecha'] : 'mes_actual';
$fecha_desde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : '';
$fecha_hasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : '';
$tipo_transaccion = isset($_GET['tipo_transaccion']) ? $_GET['tipo_transaccion'] : 'todos';

// Construcción dinámica de la consulta SQL
$conditions = ["c.socio_id = ?"];
$params = [$socio_id];

if ($cuenta_id !== 'todas') {
    $conditions[] = "c.id = ?";
    $params[] = (int)$cuenta_id;
}

if ($tipo_transaccion !== 'todos') {
    $conditions[] = "t.tipo = ?";
    $params[] = $tipo_transaccion;
}

if ($rango_fecha === 'mes_actual') {
    $conditions[] = "t.fecha >= DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00')";
} elseif ($rango_fecha === 'mes_anterior') {
    $conditions[] = "t.fecha >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01 00:00:00') AND t.fecha < DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00')";
} elseif ($rango_fecha === 'ultimos_3_meses') {
    $conditions[] = "t.fecha >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
} elseif ($rango_fecha === 'personalizado') {
    if (!empty($fecha_desde)) {
        $conditions[] = "t.fecha >= ?";
        $params[] = $fecha_desde . " 00:00:00";
    }
    if (!empty($fecha_hasta)) {
        $conditions[] = "t.fecha <= ?";
        $params[] = $fecha_hasta . " 23:59:59";
    }
}

// 2. Procesar Descarga de CSV (si se solicita)
if (isset($_GET['download']) && $_GET['download'] === 'csv') {
    $sql = "SELECT t.fecha, c.numero_cuenta, c.tipo as tipo_cuenta, t.tipo, t.descripcion, t.monto 
            FROM transacciones t 
            JOIN cuentas c ON t.cuenta_id = c.id 
            WHERE " . implode(" AND ", $conditions) . " 
            ORDER BY t.fecha DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $movimientosCsv = $stmt->fetchAll();
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="extracto_socio_' . $socio_id . '_' . date('Ymd_His') . '.csv"');
    
    // Output UTF-8 BOM for Excel compatibility
    echo "\xEF\xBB\xBF";
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Fecha', 'Número Cuenta', 'Tipo Cuenta', 'Tipo Operación', 'Descripción', 'Monto']);
    
    foreach ($movimientosCsv as $m) {
        $es_ingreso = ($m['tipo'] === 'deposito' || (strpos(strtolower($m['descripcion']), 'recibida') !== false));
        if ($m['tipo'] === 'retiro') $es_ingreso = false;
        if ($m['tipo'] === 'transferencia' && strpos(strtolower($m['descripcion']), 'enviada') !== false) {
            $es_ingreso = false;
        }
        
        $signo = $es_ingreso ? '+' : '-';
        fputcsv($output, [
            date('d/m/Y H:i', strtotime($m['fecha'])),
            $m['numero_cuenta'],
            ucfirst($m['tipo_cuenta']),
            ucfirst($m['tipo']),
            $m['descripcion'],
            $signo . ' ' . number_format($m['monto'], 0, ',', '.') . ' Gs.'
        ]);
    }
    fclose($output);
    exit;
}

// 3. Obtener Movimientos para la Vista HTML
$sql = "SELECT t.fecha, c.numero_cuenta, c.tipo as tipo_cuenta, t.tipo, t.descripcion, t.monto 
        FROM transacciones t 
        JOIN cuentas c ON t.cuenta_id = c.id 
        WHERE " . implode(" AND ", $conditions) . " 
        ORDER BY t.fecha DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$movimientos = $stmt->fetchAll();

// Obtener detalles de la cuenta seleccionada (si aplica)
$selectedAccount = null;
if ($cuenta_id !== 'todas') {
    foreach ($misCuentas as $c) {
        if ($c['id'] == $cuenta_id) {
            $selectedAccount = $c;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extractos Financieros | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .filters-container {
            padding: 24px;
            margin-bottom: 32px;
        }
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: flex-end;
        }
        .form-group-filter {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-select, .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-md);
            background-color: #f8fafc;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-dark);
            height: 48px;
            transition: var(--transition-fast);
        }
        .form-select:focus, .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(10, 176, 126, 0.1);
            background-color: white;
        }
        .btn-filter-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn-filter {
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 24px;
            border-radius: var(--radius-full);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-normal);
            border: none;
            font-size: 0.95rem;
        }
        .btn-filter-primary {
            background-color: var(--secondary-color);
            color: white;
            box-shadow: 0 4px 14px rgba(10, 176, 126, 0.3);
        }
        .btn-filter-primary:hover {
            background-color: var(--secondary-hover);
            transform: translateY(-2px);
        }
        .btn-filter-outline {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        .btn-filter-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .transaction-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
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
            flex-shrink: 0;
        }
        .t-ingreso .t-icon { background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); }
        .t-salida .t-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .t-ingreso .t-monto { color: var(--secondary-color); font-weight: 700; font-size: 1.15rem; }
        .t-salida .t-monto { color: var(--text-dark); font-weight: 700; font-size: 1.15rem; }
        
        .date-picker-group {
            display: none;
        }
        
        @media (max-width: 768px) {
            .btn-filter-group {
                width: 100%;
            }
            .btn-filter {
                width: 100%;
            }
        }
        
        /* Estilos específicos para Impresión */
        .print-header {
            display: none;
        }
        
        @media print {
            .sidebar, .top-header, .filters-container, .no-print, #menuToggle, header, .page-info {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0;
                margin: 0;
            }
            .dashboard-main {
                margin-left: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            .dashboard-content {
                padding: 0 !important;
            }
            .glass-panel {
                background: none !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                backdrop-filter: none !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 30px;
                border-bottom: 2px solid #0d284a;
                padding-bottom: 20px;
            }
            .print-header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .print-logo {
                font-size: 1.8rem;
                font-weight: 800;
                color: #0d284a;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .print-logo span {
                color: #0ab07e;
            }
            .print-title {
                text-align: right;
            }
            .print-details {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                background: #f8fafc !important;
                padding: 15px;
                border-radius: 8px;
                border: 1px solid #cbd5e1;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-details h4 {
                margin-bottom: 5px;
                color: #0d284a;
            }
            .transactions-list-wrapper {
                border: 1px solid #cbd5e1 !important;
                border-radius: 12px !important;
                overflow: hidden !important;
            }
            .transaction-item {
                border-bottom: 1px solid #cbd5e1 !important;
                page-break-inside: avoid;
            }
            .t-ingreso .t-monto {
                color: #088c64 !important;
            }
            .t-salida .t-monto {
                color: black !important;
            }
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
                <li>
                    <a href="pagar_cuotas.php"><i class="ph ph-receipt"></i> Pagar Cuotas</a>
                </li>
                <li class="active">
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Extractos Bancarios</div>
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
                
                <!-- Encabezado Oficial de Impresión -->
                <div class="print-header">
                    <div class="print-header-top">
                        <div class="print-logo">
                            <i class="ph-fill ph-leaf"></i> Coop<span>Futuro</span>
                        </div>
                        <div class="print-title">
                            <h2 style="font-size: 1.6rem; color: #0d284a; margin: 0;">Extracto Oficial de Movimientos</h2>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 2px 0 0 0;">Generado el <?php echo date('d/m/Y H:i'); ?></p>
                        </div>
                    </div>
                    <div class="print-details">
                        <div>
                            <h4>Información del Socio</h4>
                            <p><strong>Nombre completo:</strong> <?php echo htmlspecialchars($nombre_completo); ?></p>
                            <p><strong>Número de socio:</strong> Socio #<?php echo $socio_id; ?></p>
                        </div>
                        <div>
                            <h4>Detalles de la Consulta</h4>
                            <p><strong>Caja de Ahorro:</strong> <?php echo $cuenta_id === 'todas' ? 'Todas las Cuentas (Consolidado)' : htmlspecialchars($selectedAccount['numero_cuenta'] . ' (' . ucfirst($selectedAccount['tipo']) . ')'); ?></p>
                            <p><strong>Periodo:</strong> 
                                <?php 
                                if ($rango_fecha === 'mes_actual') echo 'Mes Actual';
                                elseif ($rango_fecha === 'mes_anterior') echo 'Mes Anterior';
                                elseif ($rango_fecha === 'ultimos_3_meses') echo 'Últimos 3 Meses';
                                elseif ($rango_fecha === 'personalizado') echo 'Personalizado (' . date('d/m/Y', strtotime($fecha_desde)) . ' al ' . date('d/m/Y', strtotime($fecha_hasta)) . ')';
                                ?>
                            </p>
                            <?php if ($selectedAccount): ?>
                                <p><strong>Saldo Actual de la Cuenta:</strong> <?php echo formatCurrency($selectedAccount['saldo']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="page-info" style="margin-bottom: 32px;">
                    <h1 style="font-size: 2.2rem; margin-bottom: 4px;">Extractos de Cuenta</h1>
                    <p style="color: var(--text-light);">Genera extractos personalizados de tus movimientos para descargar en PDF/imprimir o exportar a Excel.</p>
                </div>

                <!-- Panel de Filtros -->
                <div class="glass-panel filters-container no-print">
                    <form action="extractos.php" method="GET" id="filterForm">
                        <div class="filters-grid">
                            
                            <!-- Cuenta -->
                            <div class="form-group-filter">
                                <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">Cuenta de Ahorro</label>
                                <select name="cuenta_id" class="form-select">
                                    <option value="todas" <?php echo $cuenta_id === 'todas' ? 'selected' : ''; ?>>Todas las Cuentas (Consolidado)</option>
                                    <?php foreach ($misCuentas as $c): ?>
                                        <option value="<?php echo $c['id']; ?>" <?php echo $cuenta_id == $c['id'] ? 'selected' : ''; ?>>
                                            Cta: <?php echo htmlspecialchars($c['numero_cuenta']); ?> (<?php echo ucfirst(htmlspecialchars($c['tipo'])); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Rango de Fecha -->
                            <div class="form-group-filter">
                                <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">Rango de Fechas</label>
                                <select name="rango_fecha" id="rango_fecha" class="form-select">
                                    <option value="mes_actual" <?php echo $rango_fecha === 'mes_actual' ? 'selected' : ''; ?>>Mes Actual</option>
                                    <option value="mes_anterior" <?php echo $rango_fecha === 'mes_anterior' ? 'selected' : ''; ?>>Mes Anterior</option>
                                    <option value="ultimos_3_meses" <?php echo $rango_fecha === 'ultimos_3_meses' ? 'selected' : ''; ?>>Últimos 3 Meses</option>
                                    <option value="personalizado" <?php echo $rango_fecha === 'personalizado' ? 'selected' : ''; ?>>Rango Personalizado</option>
                                </select>
                            </div>
                            
                            <!-- Fecha Desde -->
                            <div class="form-group-filter date-picker-group">
                                <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">Fecha Desde</label>
                                <input type="date" name="fecha_desde" class="form-control" value="<?php echo htmlspecialchars($fecha_desde); ?>">
                            </div>
                            
                            <!-- Fecha Hasta -->
                            <div class="form-group-filter date-picker-group">
                                <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">Fecha Hasta</label>
                                <input type="date" name="fecha_hasta" class="form-control" value="<?php echo htmlspecialchars($fecha_hasta); ?>">
                            </div>
                            
                            <!-- Tipo Transacción -->
                            <div class="form-group-filter">
                                <label style="font-weight: 600; font-size: 0.85rem; color: var(--text-light);">Tipo de Movimiento</label>
                                <select name="tipo_transaccion" class="form-select">
                                    <option value="todos" <?php echo $tipo_transaccion === 'todos' ? 'selected' : ''; ?>>Todos</option>
                                    <option value="deposito" <?php echo $tipo_transaccion === 'deposito' ? 'selected' : ''; ?>>Depósitos</option>
                                    <option value="retiro" <?php echo $tipo_transaccion === 'retiro' ? 'selected' : ''; ?>>Retiros</option>
                                    <option value="transferencia" <?php echo $tipo_transaccion === 'transferencia' ? 'selected' : ''; ?>>Transferencias</option>
                                </select>
                            </div>
                            
                        </div>

                        <!-- Botones de Acción -->
                        <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                            <div class="btn-filter-group">
                                <button type="submit" class="btn-filter btn-filter-primary">
                                    <i class="ph ph-funnel"></i> Filtrar Movimientos
                                </button>
                                <button type="button" class="btn-filter btn-filter-outline" onclick="window.print();">
                                    <i class="ph ph-printer"></i> Imprimir / PDF
                                </button>
                            </div>
                            <div>
                                <a href="extractos.php?<?php echo http_build_query(array_merge($_GET, ['download' => 'csv'])); ?>" class="btn-filter btn-filter-outline" style="border-color: var(--secondary-color); color: var(--secondary-color);">
                                    <i class="ph ph-download-simple"></i> Exportar Excel (CSV)
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Listado de Movimientos -->
                <div class="glass-panel" style="padding: 32px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;" class="no-print">
                        <div>
                            <h2 style="font-size: 1.3rem; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                                <i class="ph-fill ph-list-magnifying-glass" style="color: var(--primary-color);"></i> Historial del Extracto
                            </h2>
                            <p style="font-size: 0.85rem; color: var(--text-light);">Resultados según los filtros aplicados arriba.</p>
                        </div>
                        <?php if (count($movimientos) > 0): ?>
                            <span class="badge badge-success" style="background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); font-weight: 700;">
                                <?php echo count($movimientos); ?> Transacciones
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="transactions-list-wrapper" style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <?php if(count($movimientos) > 0): ?>
                            <?php foreach($movimientos as $m): 
                                $es_ingreso = ($m['tipo'] === 'deposito' || (strpos(strtolower($m['descripcion']), 'recibida') !== false));
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
                                                    <i class="ph-fill ph-wallet"></i> Cta: <?php echo htmlspecialchars($m['numero_cuenta']); ?> (<?php echo htmlspecialchars($m['tipo_cuenta']); ?>)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="t-monto">
                                            <?php echo ($es_ingreso ? '+ ' : '- ') . formatCurrency($m['monto']); ?>
                                        </div>
                                        <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-light); margin-top: 4px;" class="no-print">
                                            COMPLETADO
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 60px 40px; text-align: center; color: var(--text-light);">
                                <i class="ph-fill ph-wind" style="font-size: 4rem; margin-bottom: 16px; opacity: 0.5; color: var(--text-light);"></i>
                                <h3 style="color: var(--text-dark); margin-bottom: 8px;">No se encontraron movimientos</h3>
                                <p>Intente cambiando los filtros de cuentas, rango de fechas o tipo de transacción.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        // Lógica de Sidebar Móvil
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

        // Mostrar / Ocultar filtros de fecha personalizado
        document.addEventListener('DOMContentLoaded', function() {
            const rangoSelect = document.getElementById('rango_fecha');
            const customDateGroups = document.querySelectorAll('.date-picker-group');
            
            function toggleCustomDates() {
                if (rangoSelect.value === 'personalizado') {
                    customDateGroups.forEach(el => el.style.display = 'block');
                } else {
                    customDateGroups.forEach(el => el.style.display = 'none');
                }
            }
            
            rangoSelect.addEventListener('change', toggleCustomDates);
            toggleCustomDates(); // Ejecutar al inicio
        });
    </script>
    <script src="assets/js/notificaciones.js?v=1.1"></script>
</body>
</html>
