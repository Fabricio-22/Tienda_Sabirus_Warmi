<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Tienda de Ropa</title>

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
            --error-color: #fecaca;
            --success-color: #bbf7d0;
            --shadow-glow: 0 0 45px rgba(0, 234, 255, 0.2);
            --shadow-hover: 0 10px 35px rgba(0, 234, 255, 0.45);
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
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Efectos decorativos de fondo */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 234, 255, 0.12), transparent);
            border-radius: 50%;
            top: -300px;
            right: -300px;
            pointer-events: none;
            animation: pulse 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1), transparent);
            border-radius: 50%;
            bottom: -250px;
            left: -250px;
            pointer-events: none;
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        /* ==================== REGISTER BOX ==================== */
        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
        }

        .register-box {
            background: var(--card-bg);
            border: 1px solid rgba(0, 234, 255, 0.15);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-glow), 0 25px 70px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ==================== HEADER ==================== */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-icon {
            font-size: 3.5rem;
            margin-bottom: 0.75rem;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(-5deg); }
        }

        .register-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ==================== FORM ==================== */
        .register-form {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
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
            z-index: 1;
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
            box-shadow: 0 0 0 4px rgba(0, 234, 255, 0.15);
        }

        .form-group input:focus + .input-icon {
            color: var(--primary-color);
        }

        /* Validación visual */
        .form-group input:valid:not(:placeholder-shown) {
            border-color: #10b981;
        }

        .form-group input:invalid:not(:placeholder-shown):not(:focus) {
            border-color: #ef4444;
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
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* ==================== PASSWORD STRENGTH ==================== */
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            overflow: hidden;
            display: none;
        }

        .password-strength.active {
            display: block;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: var(--transition);
            border-radius: 2px;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #ef4444;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #f59e0b;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #10b981;
        }

        .password-hint {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* ==================== CHECKBOX ==================== */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 0.15rem;
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .checkbox-group label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            cursor: pointer;
        }

        .checkbox-group label a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .checkbox-group label a:hover {
            text-decoration: underline;
        }

        /* ==================== BUTTON ==================== */
        .btn-register {
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
            box-shadow: 0 4px 20px rgba(0, 234, 255, 0.35);
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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
        .register-footer {
            text-align: center;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .register-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .register-footer a:hover {
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
        @media (max-width: 640px) {
            .register-box {
                padding: 2rem 1.5rem;
            }

            .register-title {
                font-size: 1.75rem;
            }

            .register-icon {
                font-size: 3rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            body::before,
            body::after {
                display: none;
            }
        }

        /* ==================== LOADING STATE ==================== */
        .btn-register.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-register.loading::after {
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

        /* ==================== ERROR MESSAGE ==================== */
        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.35rem;
            display: none;
        }

        .form-group.error .error-message {
            display: block;
        }
    </style>
</head>

<body>

<div class="register-container">
    <div class="register-box">

        <!-- Header -->
        <div class="register-header">
            <div class="register-icon">👕</div>
            <h1 class="register-title">Crea tu cuenta</h1>
            <p class="register-subtitle">
                Únete a nuestra comunidad y descubre moda exclusiva
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="/?controller=auth&action=guardar">




            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <div class="input-wrapper">
                    <span class="input-icon">👤</span>
                    <input type="text"
       id="nombre"
       name="nombre"
       placeholder="Tu nombre completo"
       required
       minlength="2"
       oninput="this.value = this.value.replace(/[0-9]/g, '')"
       title="El nombre solo debe contener letras"
       autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="email"
                           id="correo"
                           name="correo"
                           placeholder="tu@email.com"
                           required>
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
                           required
                           minlength="6">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        👁️
                    </button>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar"></div>
                </div>
                <div class="password-hint">Mínimo 6 caracteres</div>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono (opcional)</label>
                <div class="input-wrapper">
                    <span class="input-icon">📱</span>
                    <input type="tel" 
       id="telefono" 
       name="telefono" 
       maxlength="10" 
       pattern="\d{10}" 
       title="Debe tener exactamente 10 números">
                </div>
            </div>

            <button type="submit" class="btn-register">
                Crear mi cuenta
            </button>
        </form>
        <!-- Divider -->
        <div class="divider">
            <span>O</span>
        </div>

         <!-- Footer -->
        <div class="register-footer">
            <p>¿Ya tienes una cuenta? 
                <a href="/?controller=usuario&action=login">Inicia sesión</a>
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
// 1. DEFINICIÓN DE VARIABLES GLOBALES (Importante para que no falle el script)
const form = document.querySelector('form');
const inputNombre = document.getElementById('nombre');
const inputTelefono = document.getElementById('telefono');
const passwordInput = document.getElementById('contrasena');

// ==================== PASSWORD TOGGLE ====================
function togglePassword() {
    const toggleBtn = passwordInput.parentElement.querySelector('.password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.textContent = '👁️‍🗨️';
    } else {
        passwordInput.type = 'password';
        toggleBtn.textContent = '👁️';
    }
}

// ==================== PASSWORD STRENGTH ====================
const strengthBar = document.querySelector('.password-strength');
const strengthBarFill = document.querySelector('.password-strength-bar');

passwordInput.addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    
    if (password.length > 0) {
        strengthBar.classList.add('active');
        strengthBarFill.className = 'password-strength-bar';
        
        if (strength < 40) {
            strengthBarFill.classList.add('weak');
        } else if (strength < 70) {
            strengthBarFill.classList.add('medium');
        } else {
            strengthBarFill.classList.add('strong');
        }
    } else {
        strengthBar.classList.remove('active');
    }
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 15;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 20;
    if (/\d/.test(password)) strength += 20;
    if (/[^A-Za-z0-9]/.test(password)) strength += 20;
    return strength;
}

// ==================== VALIDACIONES DE ENTRADA (CORREGIDAS) ====================

// Bloquear números en el campo de NOMBRE
inputNombre.addEventListener('keypress', function(e) {
    // Si la tecla es un número (0-9), bloqueamos
    if (/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});

inputNombre.addEventListener('input', function() {
    // Limpieza automática al pegar o escribir números
    this.value = this.value.replace(/[0-9]/g, '');
});

// Bloquear letras en el campo de TELÉFONO
inputTelefono.addEventListener('keypress', function(e) {
    // Solo permitimos números
    if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});

inputTelefono.addEventListener('input', function() {
    // Limpieza automática: solo números y máximo 10 dígitos
    this.value = this.value.replace(/\D/g, '').substring(0, 10);
});

// ==================== REAL-TIME VALIDATION ====================
if (form) {
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.validity.valid) {
                this.closest('.form-group').classList.remove('error');
            } else {
                this.closest('.form-group').classList.add('error');
            }
        });
    });
}
</script>

</body>
</html>