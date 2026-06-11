<?php
require_once 'assets/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($cedula) || empty($nombre) || empty($apellido)) {
        $error = "Por favor, complete todos los campos obligatorios.";
    } else {
        // Validar si la cédula ya existe
        $stmt = $pdo->prepare("SELECT id FROM socios WHERE cedula = ?");
        $stmt->execute([$cedula]);
        if ($stmt->fetch()) {
            $error = "El número de documento ya está registrado en nuestro sistema.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO socios (cedula, nombre, apellido, direccion, telefono, email, fecha_ingreso, estado) VALUES (?, ?, ?, ?, ?, ?, CURDATE(), 'pendiente')");
            if ($stmt->execute([$cedula, $nombre, $apellido, $direccion, $telefono, $email])) {
                $success = "Su solicitud de asociación ha sido enviada con éxito. Un administrador revisará su perfil para su aprobación.";
            } else {
                $error = "Ocurrió un error al procesar su solicitud. Intente nuevamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asociarse | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .register-body {
            background: var(--bg-color);
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 40px;
            position: relative;
            z-index: 10;
        }
        
        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            opacity: 0.8;
            transition: opacity 0.3s;
            text-decoration: none;
        }
        
        .back-link:hover {
            opacity: 1;
        }

        .alert-error, .alert-success {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="register-body">

    <a href="index.php" class="back-link">
        <i class="ph ph-arrow-left"></i> Volver al inicio
    </a>

    <div class="register-wrapper">
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="index.php" class="logo" style="justify-content: center; margin-bottom: 16px; font-size: 1.8rem; color: var(--primary-color);">
                <i class="ph-fill ph-leaf"></i>
                Coop<span>Futuro</span>
            </a>
            <h2 style="color: var(--primary-color);">Solicitud de Asociación</h2>
            <p style="color: var(--text-light); font-size: 0.95rem; margin-top: 8px;">Complete el formulario para unirse a nuestra cooperativa.</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="alert-error">
                <i class="ph-fill ph-warning-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)): ?>
            <div class="alert-success">
                <i class="ph-fill ph-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
            <div style="text-align: center; margin-top: 24px;">
                <a href="login.php" class="btn btn-primary">Ir al Portal de Socios</a>
            </div>
        <?php else: ?>
            <form action="solicitud_socio.php" method="POST">
                <div class="form-group">
                    <label>Documento de Identidad (C.I.) *</label>
                    <div style="position: relative;">
                        <i class="ph ph-identification-card" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                        <input type="text" name="cedula" class="form-control" style="padding-left: 48px;" placeholder="Ej. 1234567" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombres *</label>
                        <div style="position: relative;">
                            <i class="ph ph-user" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                            <input type="text" name="nombre" class="form-control" style="padding-left: 48px;" placeholder="Nombres completos" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Apellidos *</label>
                        <div style="position: relative;">
                            <i class="ph ph-user" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                            <input type="text" name="apellido" class="form-control" style="padding-left: 48px;" placeholder="Apellidos completos" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Teléfono Celular</label>
                        <div style="position: relative;">
                            <i class="ph ph-device-mobile" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                            <input type="text" name="telefono" class="form-control" style="padding-left: 48px;" placeholder="Ej. 0981123456">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <div style="position: relative;">
                            <i class="ph ph-envelope" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                            <input type="email" name="email" class="form-control" style="padding-left: 48px;" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <div style="position: relative;">
                        <i class="ph ph-map-pin" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                        <input type="text" name="direccion" class="form-control" style="padding-left: 48px;" placeholder="Ciudad, Barrio, Calle">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 32px;">
                    Enviar Solicitud <i class="ph ph-paper-plane-right" style="margin-left: 8px;"></i>
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; font-size: 0.9rem; color: var(--text-light);">
                ¿Ya eres socio? <a href="login.php" style="color: var(--primary-color); font-weight: 600;">Ingresa a tu portal</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
