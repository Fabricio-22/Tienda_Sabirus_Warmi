<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Tienda de Ropa</title>

    <style>
        /* ==================== VARIABLES ==================== */
        :root {
            --primary-color: #00eaff;
            --primary-dark: #00b8cc;
            --bg-dark: #020617;
            --bg-gradient-start: #0a1535;
            --bg-gradient-end: #020617;
            --card-bg: rgba(17, 24, 39, 0.9);
            --border-color: #1e3a8a;
            --text-primary: #ffffff;
            --text-secondary: #cbd5e5;
            --error-bg: rgba(239, 68, 68, 0.15);
            --error-color: #fecaca;
            --error-border: rgba(239, 68, 68, 0.4);
            --success-bg: rgba(34, 197, 94, 0.15);
            --success-color: #bbf7d0;
            --success-border: rgba(34, 197, 94, 0.4);
            --shadow-glow: 0 0 40px rgba(0, 234, 255, 0.2);
            --shadow-hover: 0 8px 30px rgba(0, 234, 255, 0.4);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ==================== BODY & BACKGROUND ==================== */
        body {
            min-height: 100vh;
            background: radial-gradient(ellipse at top, var(--bg-gradient-start), var(--bg-gradient-end));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Efecto de partículas decorativas */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 234, 255, 0.1), transparent);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08), transparent);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            pointer-events: none;
        }

        /* ==================== LOGIN BOX ==================== */
        .login-container {
            position: relative;
            z-index: 10;
        }

        .login-box {
            width: 100%;
            max-width: 450px;
            background: var(--card-bg);
            border: 1px solid rgba(0, 234, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-glow), 0 20px 60px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ==================== HEADER ==================== */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .login-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* ==================== ALERTS ==================== */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            font-size: 1.25rem;
        }

        .alert-danger {
            background: var(--error-bg);
            color: var(--error-color);
            border: 1px solid var(--error-border);
        }

        .alert-danger::before {
            content: '⚠️';
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-color);
            border: 1px solid var(--success-border);
        }

        .alert-success::before {
            content: '✅';
        }

        /* ==================== FORM ==================== */
        .login-form {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
            color: var(--text-secondary);
            pointer-events: none;
            transition: var(--transition);
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--bg-dark);
            color: var(--text-primary);
            outline: none;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-group input::placeholder {
            color: #6b7280;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(0, 234, 255, 0.1);
        }

        .form-group input:focus + .input-icon {
            color: var(--primary-color);
        }

        /* ==================== PASSWORD TOGGLE ==================== */
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.25rem;
            padding: 0.25rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* ==================== FORGOT PASSWORD ==================== */
        .forgot-password {
            text-align: right;
            margin-top: -0.5rem;
            margin-bottom: 1.5rem;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .forgot-password a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        /* ==================== BUTTON ==================== */
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), #2563eb);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            color: #000;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ==================== DIVIDER ==================== */
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            padding: 0 1rem;
        }

        /* ==================== FOOTER ==================== */
        .login-footer {
            text-align: center;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .login-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* ==================== BACK LINK ==================== */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .back-link a:hover {
            color: var(--primary-color);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 480px) {
            .login-box {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.75rem;
            }

            .login-icon {
                font-size: 3rem;
            }

            body::before,
            body::after {
                display: none;
            }
        }

        /* ==================== LOADING STATE ==================== */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #000;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <!-- Header -->
        <div class="login-header">
            <div class="login-icon">👕</div>
            <h1 class="login-title">¡Bienvenido!</h1>
            <p class="login-subtitle">Inicia sesión para continuar tu experiencia de compra</p>
        </div>
        <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        ❌ Correo o contraseña incorrectos.
    </div>
<?php endif; ?>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
    <div class="alert-success">
        ✅ Registro exitoso. Ahora inicia sesión.
    </div>
<?php endif; ?>


<?php if (isset($_GET['sesion']) && $_GET['sesion'] === 'cerrada'): ?>
    <div class="alert alert-info">
        👋 Sesión cerrada correctamente.
    </div>
<?php endif; ?>


        <!-- Alert de ejemplo (puedes cambiarla) -->
        <!-- <div class="alert alert-danger">
            Correo o contraseña incorrectos. Por favor, intenta de nuevo.
        </div> -->

        

        <!-- Form -->
        <form method="POST" action="/?controller=auth&action=autenticar">



            <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="email"
                           id="correo"
                           name="correo"
                           placeholder="tu@email.com"
                           required
                           autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password"
                           id="contrasena"
                           name="contrasena"
                           placeholder="••••••••"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        👁️
                    </button>
                </div>
            </div>

            <div class="forgot-password">
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>

        </form>

        <!-- Divider -->
        <div class="divider">
            <span>O</span>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p>¿No tienes una cuenta? 
                <a href="/?controller=usuario&action=registro">Regístrate gratis</a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="back-link">
            <a href="/?controller=producto&action=index">
                ← Volver a la tienda
            </a>
        </div>

    </div>
</div>

<script>
// ==================== PASSWORD TOGGLE ====================
function togglePassword() {
    const passwordInput = document.getElementById('contrasena');
    const toggleBtn = document.querySelector('.password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.textContent = '👁️‍🗨️';
    } else {
        passwordInput.type = 'password';
        toggleBtn.textContent = '👁️';
    }
}

// ==================== FORM VALIDATION ====================
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevenir envío para la demo
    
    const email = document.getElementById('correo').value;
    const password = document.getElementById('contrasena').value;
    const submitBtn = document.querySelector('.btn-login');
    
    // Validación básica
    if (!email || !password) {
        alert('Por favor, completa todos los campos');
        return;
    }
    
    // Agregar estado de carga
    submitBtn.classList.add('loading');
    submitBtn.textContent = '';
    
    // Simular proceso (en producción, aquí iría el envío real)
    setTimeout(() => {
        submitBtn.classList.remove('loading');
        submitBtn.textContent = 'Iniciar sesión';
        alert('¡Formulario enviado! (Demo)');
    }, 2000);
});

// ==================== AUTO-HIDE ALERTS ====================
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(alert => {
        alert.style.animation = 'slideDown 0.4s ease reverse';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 400);
    });
}, 5000); // Se oculta después de 5 segundos
</script>

</body>
</html>