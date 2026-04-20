<?php
require_once 'assets/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooperativa Futuro | Tu Socio Financiero</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- Phosphor Icons para íconos modernos -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <!-- Navegación -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <i class="ph-fill ph-leaf"></i>
                Coop<span>Futuro</span>
            </a>
            <div class="nav-links">
                <a href="#servicios">Servicios</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#contacto">Contacto</a>
            </div>
            <div>
                <?php if(isLoggedIn()): ?>
                    <a href="portal_socios.php" class="btn btn-primary" style="margin-right: 12px;">Mi Portal</a>
                    <a href="logout.php" class="btn btn-outline">Salir</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline" style="margin-right: 12px;">Acceso Socios</a>
                    <a href="#" class="btn btn-primary">Asociarse</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Tu Futuro Financiero Empieza Aquí</h1>
                <p>Únete a la cooperativa que piensa en ti. Tasas preferenciales en préstamos, ahorros programados y beneficios exclusivos para todos nuestros socios.</p>
                <div class="hero-buttons">
                    <?php if(isLoggedIn()): ?>
                        <a href="portal_socios.php" class="btn btn-primary">Ir a mi Portal</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Panel de Socios</a>
                    <?php endif; ?>
                    <a href="menu.php" class="btn btn-outline-white">Administración</a>
                </div>
            </div>
            <div class="hero-image glass-panel" style="padding: 30px; display: flex; flex-direction: column; gap: 20px;">
                <!-- Decoración visual tipo Tarjeta de Crédito -->
                <div style="background: linear-gradient(135deg, #0ab07e, #088c64); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 10px 20px rgba(10, 176, 126, 0.3); position: relative; overflow: hidden;">
                    <i class="ph ph-waves" style="position: absolute; right: -20px; top: -20px; font-size: 8rem; opacity: 0.1;"></i>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <i class="ph-fill ph-sim-card" style="font-size: 2.5rem; color: #f7a916;"></i>
                        <span style="font-weight: 600; font-size: 1.2rem;">Socio Premium</span>
                    </div>
                    <div style="font-size: 1.5rem; letter-spacing: 2px; margin-bottom: 20px; font-family: monospace;">**** **** **** 4092</div>
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <div style="font-size: 0.7rem; text-transform: uppercase;">Ahorros Disponibles</div>
                            <div style="font-weight: 700; font-size: 1.2rem;">Gs. 12.450.000</div>
                        </div>
                        <i class="ph-fill ph-contactless-payment" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <div style="display: flex; gap: 16px;">
                    <div style="flex: 1; background: white; padding: 16px; border-radius: 12px; text-align: center; color: var(--primary-color);">
                        <i class="ph-fill ph-piggy-bank" style="font-size: 2rem; color: var(--secondary-color); margin-bottom: 8px;"></i>
                        <div style="font-weight: 600;">Tasas de Ahorro</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">Hasta 12% Anual</div>
                    </div>
                    <div style="flex: 1; background: white; padding: 16px; border-radius: 12px; text-align: center; color: var(--primary-color);">
                        <i class="ph-fill ph-hand-coins" style="font-size: 2rem; color: var(--accent-color); margin-bottom: 8px;"></i>
                        <div style="font-weight: 600;">Préstamos Ágiles</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">Aprobación en 24h</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="servicios" style="padding: 100px 0; background-color: var(--white);">
        <div class="container text-center">
            <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Nuestros Servicios</h2>
            <p style="max-width: 600px; margin: 0 auto 60px;">Descubrí las ventajas de ser parte de nuestra familia cooperativa.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; text-align: left;">
                <div class="glass-panel" style="padding: 40px; background: var(--bg-color); border: none; transition: transform 0.3s;">
                    <div style="width: 60px; height: 60px; border-radius: 16px; background: rgba(10, 176, 126, 0.1); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 24px;">
                        <i class="ph ph-bank"></i>
                    </div>
                    <h3 style="margin-bottom: 16px; font-size: 1.4rem;">Cuentas de Ahorro</h3>
                    <p style="margin-bottom: 24px;">Mantenga su dinero seguro mientras genera excelentes intereses para un futuro estable.</p>
                    <a href="#" style="color: var(--secondary-color); font-weight: 600; display: flex; align-items: center; gap: 8px;">Conocer más <i class="ph ph-arrow-right"></i></a>
                </div>
                
                <div class="glass-panel" style="padding: 40px; background: var(--bg-color); border: none; transition: transform 0.3s;">
                    <div style="width: 60px; height: 60px; border-radius: 16px; background: rgba(13, 40, 74, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 24px;">
                        <i class="ph ph-wallet"></i>
                    </div>
                    <h3 style="margin-bottom: 16px; font-size: 1.4rem;">Préstamos Personales</h3>
                    <p style="margin-bottom: 24px;">Financie sus proyectos y sueños con las tasas más competitivas del mercado.</p>
                    <a href="#" style="color: var(--primary-color); font-weight: 600; display: flex; align-items: center; gap: 8px;">Simular Préstamo <i class="ph ph-arrow-right"></i></a>
                </div>

                <div class="glass-panel" style="padding: 40px; background: var(--bg-color); border: none; transition: transform 0.3s;">
                    <div style="width: 60px; height: 60px; border-radius: 16px; background: rgba(247, 169, 22, 0.1); color: var(--accent-color); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 24px;">
                        <i class="ph ph-calendar-check"></i>
                    </div>
                    <h3 style="margin-bottom: 16px; font-size: 1.4rem;">Ahorros Programados</h3>
                    <p style="margin-bottom: 24px;">Planifique sus metas a largo plazo aportando un monto fijo mes a mes.</p>
                    <a href="#" style="color: var(--accent-color); font-weight: 600; display: flex; align-items: center; gap: 8px;">Organizar Plan <i class="ph ph-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background-color: #05162b; color: #94a3b8; padding: 60px 0 30px;">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 40px; margin-bottom: 30px;">
            <div>
                <a href="index.php" class="logo" style="color: white; margin-bottom: 20px;">
                    <i class="ph-fill ph-leaf"></i> Coop<span>Futuro</span>
                </a>
                <p>Construimos futuros juntos a través de la solidaridad y el apoyo mutuo financiero.</p>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 20px;">Navegación</h4>
                <ul style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="#" style="transition: color 0.2s;">Servicios</a></li>
                    <li><a href="#" style="transition: color 0.2s;">Nosotros</a></li>
                    <li><a href="#" style="transition: color 0.2s;">Simulador</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 20px;">Legal</h4>
                <ul style="display: flex; flex-direction: column; gap: 12px;">
                    <li><a href="#" style="transition: color 0.2s;">Términos y Condiciones</a></li>
                    <li><a href="#" style="transition: color 0.2s;">Política de Privacidad</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: white; margin-bottom: 20px;">Contacto</h4>
                <p><i class="ph ph-phone" style="margin-right: 8px;"></i> (021) 123 4567</p>
                <p style="margin-top: 12px;"><i class="ph ph-envelope-simple" style="margin-right: 8px;"></i> info@coopfuturo.com</p>
            </div>
        </div>
        <div class="container text-center">
            <p>&copy; 2026 Cooperativa Futuro. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Efecto sticky navbar
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '15px 0';
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.05)';
            } else {
                navbar.style.padding = '20px 0';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
