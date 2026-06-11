<?php
require_once 'assets/db.php';
// Verificar sesión
checkLogin();

$socio_id = $_SESSION['socio_id'];
$nombre_completo = $_SESSION['socio_nombre'] . ' ' . $_SESSION['socio_apellido'];

$mensaje = '';
$tipo_mensaje = '';

// Procesar Formulario de Actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_guardar'])) {
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    
    if (empty($direccion) || empty($telefono) || empty($email)) {
        $mensaje = "Todos los campos de contacto son obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico ingresado no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {
        try {
            $pdo->beginTransaction();
            
            // Actualizar datos del socio
            $stmtUpdate = $pdo->prepare("UPDATE socios SET direccion = ?, telefono = ?, email = ? WHERE id = ?");
            $stmtUpdate->execute([$direccion, $telefono, $email, $socio_id]);
            
            // Registrar Notificación
            $tituloNotif = "Perfil Actualizado";
            $mensajeNotif = "Tus datos de contacto han sido actualizados con éxito. Correo: " . $email . " | Tel: " . $telefono;
            $stmtNotif = $pdo->prepare("INSERT INTO notificaciones (socio_id, titulo, mensaje) VALUES (?, ?, ?)");
            $stmtNotif->execute([$socio_id, $tituloNotif, $mensajeNotif]);
            
            $pdo->commit();
            
            $mensaje = "¡Tus datos de perfil han sido actualizados de forma correcta!";
            $tipo_mensaje = "exito";
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $mensaje = "Error al actualizar perfil: " . $e->getMessage();
            $tipo_mensaje = "error";
        }
    }
}

// Obtener datos frescos del socio
$stmt = $pdo->prepare("SELECT * FROM socios WHERE id = ?");
$stmt->execute([$socio_id]);
$socio = $stmt->fetch();

if (!$socio) {
    die("Error: Socio no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        .form-control, .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius-md);
            font-size: 1rem;
            color: var(--text-dark);
            background-color: #f8fafc;
            transition: var(--transition-fast);
            margin-bottom: 24px;
        }
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-control:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--secondary-color);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(10, 176, 126, 0.1);
        }
        .form-control:disabled {
            background-color: #e2e8f0;
            color: var(--text-light);
            cursor: not-allowed;
            opacity: 0.8;
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
        
        /* Profile Layout */
        .profile-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 32px;
            align-items: start;
        }
        
        .profile-sidebar-card {
            text-align: center;
            padding: 40px 24px;
        }
        .profile-avatar-large {
            width: 110px;
            height: 110px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(13,40,74,0.15);
            border: 4px solid white;
        }
        
        .profile-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }
        .profile-detail-item:last-child {
            border-bottom: none;
        }
        .profile-detail-label {
            color: var(--text-light);
            font-weight: 500;
        }
        .profile-detail-val {
            color: var(--text-dark);
            font-weight: 700;
        }
        
        .badge-estado {
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-activo { background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); }
        .badge-pendiente { background: rgba(247, 169, 22, 0.1); color: var(--accent-color); }
        
        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
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
                <li>
                    <a href="extractos.php"><i class="ph ph-file-text"></i> Extractos</a>
                </li>
                
                <li style="padding: 24px 24px 12px; font-size: 0.8rem; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px;">Configuración</li>
                <li class="active">
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
                    <div style="font-weight: 600; font-size: 1.1rem; color: var(--primary-color);">Configuración de Perfil</div>
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
                    <h1 style="font-size: 2.2rem; margin-bottom: 4px;">Mi Perfil</h1>
                    <p style="color: var(--text-light);">Verifique su información oficial de socio y actualice sus datos de contacto en la cooperativa.</p>
                </div>

                <?php if(!empty($mensaje)): ?>
                    <div class="alert-box <?php echo $tipo_mensaje === 'exito' ? 'alert-success' : 'alert-error'; ?>" style="max-width: 1000px; margin-bottom: 24px;">
                        <i class="<?php echo $tipo_mensaje === 'exito' ? 'ph-fill ph-check-circle' : 'ph-fill ph-warning-circle'; ?>" style="font-size: 1.5rem;"></i>
                        <div><?php echo htmlspecialchars($mensaje); ?></div>
                    </div>
                <?php endif; ?>

                <div class="profile-grid" style="max-width: 1000px;">
                    
                    <!-- Tarjeta de Información Estática -->
                    <div class="glass-panel profile-sidebar-card">
                        <div class="profile-avatar-large">
                            <?php echo substr($socio['nombre'], 0, 1) . substr($socio['apellido'], 0, 1); ?>
                        </div>
                        <h2 style="font-size: 1.5rem; color: var(--primary-color); margin-bottom: 6px;"><?php echo htmlspecialchars($nombre_completo); ?></h2>
                        <span class="badge-estado badge-<?php echo strtolower($socio['estado']); ?>">
                            Socio <?php echo htmlspecialchars($socio['estado']); ?>
                        </span>
                        
                        <div style="margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 16px; text-align: left;">
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Nro. de Socio</span>
                                <span class="profile-detail-val">#<?php echo $socio['id']; ?></span>
                            </div>
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Cédula Identidad</span>
                                <span class="profile-detail-val"><?php echo htmlspecialchars($socio['cedula']); ?></span>
                            </div>
                            <div class="profile-detail-item">
                                <span class="profile-detail-label">Fecha Ingreso</span>
                                <span class="profile-detail-val"><?php echo date('d/m/Y', strtotime($socio['fecha_ingreso'])); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulario de Edición de Perfil -->
                    <div class="glass-panel" style="padding: 40px;">
                        <h3 style="font-size: 1.3rem; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-note-pencil" style="color: var(--secondary-color);"></i> Datos de Contacto
                        </h3>
                        
                        <form action="perfil.php" method="POST" id="profileForm">
                            
                            <!-- Cédula (Deshabilitada) -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label" for="cedula">Cédula de Identidad (No modificable)</label>
                                <input type="text" id="cedula" class="form-control" value="<?php echo htmlspecialchars($socio['cedula']); ?>" disabled>
                            </div>
                            
                            <!-- Correo Electrónico -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label" for="email">Correo Electrónico</label>
                                <div style="position: relative;">
                                    <i class="ph ph-envelope-simple" style="position: absolute; left: 16px; top: 15px; color: #94a3b8; font-size: 1.2rem;"></i>
                                    <input type="email" name="email" id="email" class="form-control" style="padding-left: 48px;" value="<?php echo htmlspecialchars($socio['email'] ?? ''); ?>" required placeholder="correo@ejemplo.com">
                                </div>
                            </div>
                            
                            <!-- Teléfono -->
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="form-label" for="telefono">Teléfono / Celular</label>
                                <div style="position: relative;">
                                    <i class="ph ph-phone" style="position: absolute; left: 16px; top: 15px; color: #94a3b8; font-size: 1.2rem;"></i>
                                    <input type="text" name="telefono" id="telefono" class="form-control" style="padding-left: 48px;" value="<?php echo htmlspecialchars($socio['telefono'] ?? ''); ?>" required placeholder="Ej. 0981 123 456">
                                </div>
                            </div>
                            
                            <!-- Dirección -->
                            <div class="form-group" style="margin-bottom: 28px;">
                                <label class="form-label" for="direccion">Dirección Domiciliaria</label>
                                <div style="position: relative;">
                                    <i class="ph ph-map-pin" style="position: absolute; left: 16px; top: 15px; color: #94a3b8; font-size: 1.2rem;"></i>
                                    <textarea name="direccion" id="direccion" class="form-textarea" style="padding-left: 48px;" required placeholder="Dirección completa..."><?php echo htmlspecialchars($socio['direccion'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <button type="submit" name="btn_guardar" class="btn btn-primary btn-block" style="padding: 16px; font-size: 1.1rem; display: flex; justify-content: center; align-items: center; gap: 8px;">
                                <i class="ph ph-floppy-disk"></i> Guardar Cambios
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

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Guardando...';
            btn.style.opacity = '0.8';
        });
    </script>
    <script src="assets/js/notificaciones.js?v=1.1"></script>
</body>
</html>
