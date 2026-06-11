<?php
require_once 'assets/db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        $action = $_POST['action'];

        if ($action === 'aprobar') {
            $stmt = $pdo->prepare("UPDATE socios SET estado = 'activo' WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "<div class='alert-success'>Socio aprobado exitosamente. Ya puede iniciar sesión.</div>";
            }
        } elseif ($action === 'rechazar') {
            $stmt = $pdo->prepare("DELETE FROM socios WHERE id = ?");
            if ($stmt->execute([$id])) {
                $message = "<div class='alert-success'>Solicitud rechazada y eliminada del sistema.</div>";
            }
        }
    }
}

$stmt = $pdo->query("SELECT * FROM socios WHERE estado = 'pendiente' ORDER BY fecha_ingreso DESC, id DESC");
$pendientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobaciones Pendientes | Administración</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .table th, .table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }
        .table th {
            background: var(--bg-color);
            color: var(--text-color);
            font-weight: 600;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-success {
            background: #10b981;
            color: white;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-success:hover {
            opacity: 0.9;
        }
        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-danger:hover {
            opacity: 0.9;
        }
        .action-forms {
            display: flex;
            gap: 8px;
        }
        .alert-success {
            padding: 16px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body style="background: var(--bg-color);">
    <nav class="navbar" style="background: white; border-bottom: 1px solid #e2e8f0; padding: 15px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" class="logo" style="color: var(--primary-color);">
                <i class="ph-fill ph-leaf"></i>
                Coop<span>Futuro</span> 
                <span style="font-size: 1rem; color: var(--text-light); margin-left: 8px; border-left: 1px solid #cbd5e1; padding-left: 8px;">Panel Admin</span>
            </a>
            <div>
                <a href="index.php" class="btn btn-outline">Volver al Sitio Web</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <h2 style="margin-bottom: 24px; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
            <i class="ph-fill ph-users-three"></i> Solicitudes de Asociación Pendientes
        </h2>

        <?php if(!empty($message)): ?>
            <?= $message ?>
        <?php endif; ?>

        <?php if (count($pendientes) > 0): ?>
            <div style="overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha de Solicitud</th>
                            <th>Documento (C.I.)</th>
                            <th>Nombre Completo</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendientes as $socio): ?>
                            <tr>
                                <td style="color: var(--text-light);"><?= htmlspecialchars($socio['fecha_ingreso'] ? date('d/m/Y', strtotime($socio['fecha_ingreso'])) : 'N/D') ?></td>
                                <td style="font-weight: 600; color: var(--primary-color);"><?= htmlspecialchars($socio['cedula']) ?></td>
                                <td>
                                    <div style="font-weight: 500;"><?= htmlspecialchars($socio['nombre'] . ' ' . $socio['apellido']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-light);"><?= htmlspecialchars($socio['direccion'] ?? '') ?></div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;"><i class="ph-fill ph-phone" style="color: var(--text-light);"></i> <?= htmlspecialchars($socio['telefono'] ?? '-') ?></div>
                                    <div style="font-size: 0.85rem;"><i class="ph-fill ph-envelope-simple" style="color: var(--text-light);"></i> <?= htmlspecialchars($socio['email'] ?? '-') ?></div>
                                </td>
                                <td>
                                    <span class="badge"><i class="ph-fill ph-clock"></i> Pendiente</span>
                                </td>
                                <td>
                                    <div class="action-forms">
                                        <form method="POST" style="margin: 0;">
                                            <input type="hidden" name="id" value="<?= $socio['id'] ?>">
                                            <input type="hidden" name="action" value="aprobar">
                                            <button type="submit" class="btn-sm btn-success" title="Aprobar Socio">
                                                <i class="ph-bold ph-check"></i> Aprobar
                                            </button>
                                        </form>
                                        <form method="POST" style="margin: 0;" onsubmit="return confirm('¿Está seguro de rechazar y eliminar esta solicitud de asociación?');">
                                            <input type="hidden" name="id" value="<?= $socio['id'] ?>">
                                            <input type="hidden" name="action" value="rechazar">
                                            <button type="submit" class="btn-sm btn-danger" title="Rechazar Solicitud">
                                                <i class="ph-bold ph-x"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="glass-panel" style="text-align: center; padding: 60px 20px; background: white; border: 1px dashed #cbd5e1;">
                <i class="ph-fill ph-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 16px;"></i>
                <h3 style="color: var(--primary-color);">Todo al día</h3>
                <p style="color: var(--text-light);">No hay solicitudes pendientes de aprobación en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
