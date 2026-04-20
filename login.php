<?php
require_once 'assets/db.php';

$error = '';

if(isLoggedIn()) {
    header("Location: portal_socios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'] ?? '';
    $password = $_POST['password'] ?? '';

    // Según opción 1: la contraseña es la misma cédula
    if ($documento === $password) {
        $stmt = $pdo->prepare("SELECT * FROM socios WHERE cedula = ? AND estado = 'activo'");
        $stmt->execute([$documento]);
        $socio = $stmt->fetch();

        if ($socio) {
            $_SESSION['socio_id'] = $socio['id'];
            $_SESSION['socio_nombre'] = $socio['nombre'];
            $_SESSION['socio_apellido'] = $socio['apellido'];
            $_SESSION['socio_cedula'] = $socio['cedula'];
            header("Location: portal_socios.php");
            exit;
        } else {
            $error = "Credenciales incorrectas o socio inactivo.";
        }
    } else {
        $error = "La contraseña debe ser su mismo documento de identidad.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Socios | Cooperativa Futuro</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .login-body {
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }
        
        /* Decorative Background */
        .login-body::before {
            content: '';
            position: fixed;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(10,176,126,0.15) 0%, rgba(255,255,255,0) 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
        }
        
        .back-link {
            position: absolute;
            top: 40px;
            left: 40px;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .back-link:hover {
            opacity: 1;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            margin-bottom: 24px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body class="login-body">
    
    <a href="index.php" class="back-link">
        <i class="ph ph-arrow-left"></i> Volver al sitio web
    </a>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <a href="index.php" class="logo" style="justify-content: center;">
                    <i class="ph-fill ph-leaf"></i>
                    Coop<span>Futuro</span>
                </a>
                <h2 style="color: var(--primary-color);">Bienvenido Socio</h2>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 8px;">Ingrese sus credenciales para acceder a su portal. La contraseña es su misma cédula.</p>
            </div>
            
            <?php if(!empty($error)): ?>
                <div class="alert-error">
                    <i class="ph-fill ph-warning-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <label for="documento">Documento de Identidad (C.I.)</label>
                    <div style="position: relative;">
                        <i class="ph ph-identification-card" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                        <input type="text" name="documento" id="documento" class="form-control" style="padding-left: 48px;" placeholder="Ej. 1234567" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label for="password" style="margin-bottom: 0;">Contraseña (Su misma C.I.)</label>
                    </div>
                    <div style="position: relative;">
                        <i class="ph ph-lock-key" style="position: absolute; left: 16px; top: 16px; color: #94a3b8; font-size: 1.2rem;"></i>
                        <input type="password" name="password" id="password" class="form-control" style="padding-left: 48px;" placeholder="Ingrese su contraseña" required>
                        <button type="button" id="togglePassword" style="position: absolute; right: 16px; top: 16px; background: none; border: none; color: #94a3b8; cursor: pointer; display: flex;">
                            <i class="ph ph-eye" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group" style="display: flex; align-items: center; gap: 8px; margin-bottom: 32px;">
                    <input type="checkbox" id="remember" style="width: 16px; height: 16px; accent-color: var(--secondary-color);">
                    <label for="remember" style="margin-bottom: 0; font-weight: 400; font-size: 0.9rem; color: var(--text-light); cursor: pointer;">Recordarme en este dispositivo</label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    Ingresar a mi Portal <i class="ph ph-sign-in" style="margin-left: 8px;"></i>
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 32px; font-size: 0.9rem; color: var(--text-light);">
                ¿Aún no es socio? <a href="#" style="color: var(--primary-color); font-weight: 600;">Asóciese en línea</a>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function (e) {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                icon.classList.remove('ph-eye');
                icon.classList.add('ph-eye-slash');
            } else {
                icon.classList.remove('ph-eye-slash');
                icon.classList.add('ph-eye');
            }
        });
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="ph ph-spinner ph-spin" style="margin-right: 8px;"></i> Procesando...';
            btn.style.opacity = '0.8';
        });
    </script>
</body>
</html>
