<?php
// 🔐 Asegurar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar página actual para marcar activa en el menú
$currentController = $_GET['controller'] ?? 'producto';
$currentAction = $_GET['action'] ?? 'index';
$currentPage = $currentController . '_' . $currentAction;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Tienda Online' ?></title>
    
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/user.css">
    
    <style>
        /* ==================== VARIABLES ==================== */
        :root {
            --primary-color: #00eaff;
            --primary-dark: #00b8cc;
            --bg-dark: #0a0a14;
            --bg-card: #111827;
            --bg-sidebar: #0f1419;
            --border-color: #374151;
            --text-primary: #ffffff;
            --text-secondary: #9ca3af;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
            --transition: all 0.3s ease;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        /* ==================== LAYOUT GRID ==================== */
        .dashboard-layout {
            display: grid;
            grid-template-areas:
                "topbar topbar"
                "sidebar content";
            grid-template-columns: var(--sidebar-width) 1fr;
            grid-template-rows: var(--topbar-height) 1fr;
            min-height: 100vh;
        }

        .dashboard-layout.no-sidebar {
            grid-template-areas:
                "topbar"
                "content";
            grid-template-columns: 1fr;
        }

        /* ==================== TOPBAR ==================== */
        .topbar {
            grid-area: topbar;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
        }

        

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-primary);
        }

        .brand-icon {
            font-size: 2rem;
            filter: drop-shadow(0 0 8px var(--primary-color));
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .brand h2 {
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
       
/* Simple animación bounce */
@keyframes bounceAnim {
    0% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(0.95); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
.bounce {
    animation: bounceAnim 0.5s ease;
}
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4caf50;
    color: #fff;
    padding: 10px 16px;
    border-radius: 6px;
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 9999;
}
.toast.show {
    opacity: 1;
}

        /* Search Bar */
        .topbar-search {
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
        }

        .search-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: var(--text-secondary);
            pointer-events: none;
        }

        .topbar-search input {
            width: 100%;
            padding: 0.75rem 1.25rem 0.75rem 3rem;
            border-radius: 50px;
            border: 2px solid var(--border-color);
            background: var(--bg-dark);
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .topbar-search input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
        }

        .topbar-search input::placeholder {
            color: var(--text-secondary);
        }

        /* Actions */
        .topbar-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-shrink: 0;
        }

        .cart-icon-btn {
            position: relative;
            background: var(--bg-dark);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.6rem;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.3rem;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            flex-shrink: 0;
        }

        .cart-icon-btn:hover {
            border-color: var(--primary-color);
            background: rgba(0, 234, 255, 0.1);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.4rem;
            border-radius: 50%;
            min-width: 20px;
            text-align: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--bg-dark);
            border-radius: 50px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .user-info:hover {
            border-color: var(--primary-color);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #000;
            font-size: 1.1rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .logout-btn {
            padding: 0.6rem 1.25rem;
            background: var(--primary-color);
            color: #000;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            white-space: nowrap;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Botón secundario para registro */
        .btn-register {
            padding: 0.6rem 1.25rem;
            background: transparent;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 50px;
            border: 2px solid var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            white-space: nowrap;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-register:hover {
            background: var(--primary-color);
            color: #000;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            grid-area: sidebar;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem 0;
            overflow-y: auto;
            position: sticky;
            top: var(--topbar-height);
            height: calc(100vh - var(--topbar-height));
        }

        .sidebar-nav {
            padding: 0 1rem;
        }

        .nav-list {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 12px;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            background: var(--bg-card);
            color: var(--text-primary);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(0, 234, 255, 0.15), rgba(0, 234, 255, 0.05));
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .nav-badge {
            background: var(--primary-color);
            color: #000;
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            min-width: 24px;
            text-align: center;
        }

        .nav-divider {
            height: 1px;
            background: var(--border-color);
            margin: 1rem 0;
        }

        .nav-section-title {
            color: var(--text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem 0.5rem;
            font-weight: 600;
        }

        /* ==================== CONTENT ==================== */
        .content {
            grid-area: content;
            padding: 2rem;
            overflow-y: auto;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* ==================== MOBILE MENU TOGGLE ==================== */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 968px) {
            .topbar-search {
                display: none;
            }

            .user-details {
                display: none;
            }

            .topbar-actions {
                gap: 0.5rem;
            }

            .logout-btn, .btn-register {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .dashboard-layout {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "topbar"
                    "content";
            }

            .sidebar {
                position: fixed;
                left: -100%;
                top: var(--topbar-height);
                width: var(--sidebar-width);
                height: calc(100vh - var(--topbar-height));
                z-index: 90;
                transition: left 0.3s ease;
                box-shadow: var(--shadow-md);
            }

            .sidebar.active {
                left: 0;
            }

            .topbar-container {
                padding: 0 1rem;
            }

            .content {
                padding: 1rem;
            }

            .user-info {
                padding: 0.5rem;
            }

            .cart-icon-btn {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }

        /* ==================== OVERLAY PARA MÓVIL ==================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: var(--topbar-height);
            left: 0;
            width: 100%;
            height: calc(100vh - var(--topbar-height));
            background: rgba(0, 0, 0, 0.7);
            z-index: 89;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ==================== FOOTER ==================== */
        .footer {
            grid-column: 1 / -1;
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            padding: 2rem;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
    /* Botón flotante circular */
<style>
/* ==================== CHATBOT ==================== */

/* Botón flotante */
#chat-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    font-size: 28px;
    cursor: pointer;
    z-index: 10000; /* más alto que otros elementos */
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.2s;
}

#chat-toggle:hover {
    transform: scale(1.1);
}

/* Contenedor del chatbot */
#chatbot {
    display: none; /* inicialmente oculto */
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 320px;
    max-height: 420px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    flex-direction: column;
    overflow: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    z-index: 9999;
}

/* Cabecera del chatbot */
#chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chat-header span {
    font-weight: bold;
}

#chat-minimize {
    background: none;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}

/* Área de mensajes */
#chat-body {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f7f7f7;
}

/* Mensajes */
.message {
    margin-bottom: 8px;
    display: flex;
}

.message-content {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 10px;
    max-width: 80%;
}

.message.bot .message-content {
    background: #e2e2e2;
    color: #000;
}

.message.user .message-content {
    background: #667eea;
    color: #fff;
    margin-left: auto;
}

/* Indicador de escritura */
.typing-indicator {
    display: none;
    font-style: italic;
    color: #666;
}

/* Formulario */
#chat-form {
    display: flex;
    border-top: 1px solid #ccc;
}

#chat-input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
    font-size: 14px;
}

#chat-form button {
    background: #667eea;
    color: #fff;
    border: none;
    padding: 0 15px;
    cursor: pointer;
    font-weight: bold;
}
</style>

    </style>
</head>

<body class="dashboard-layout <?= !isset($_SESSION['usuario']) ? 'no-sidebar' : '' ?>">

<?php
$cartCount = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
?>


<!-- ==================== TOPBAR ==================== -->
<header class="topbar">
    <div class="topbar-container">

        <?php if (isset($_SESSION['usuario'])): ?>
            <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
        <?php endif; ?>

        <a href="/?controller=producto&action=index" class="brand">
            <span class="brand-icon">👕</span>
            <h2>Tienda Sabirus Warmi </h2>
        </a>

        <!-- ==================== BUSCADOR ==================== -->
<div class="topbar-search">
    <div class="search-wrapper">
        <form action="/index.php" method="GET">
            <span class="search-icon">🔍</span>

            <input type="hidden" name="controller" value="producto">
            <input type="hidden" name="action" value="buscar">

            <input type="text"
                   name="q"
                   placeholder="Buscar productos..."
                   required>
        </form>
    </div>
</div>




        <div class="topbar-actions">
            <?php if (isset($_SESSION['usuario'])): ?>
<div class="cart-icon-btn nav-cart" onclick="toggleMiniCart(event)" role="button" aria-label="Carrito de compras" tabindex="0">
    <span class="cart-icon" aria-hidden="true">🛒</span>
    <?php if ($cartCount > 0): ?>
        <span class="cart-badge" aria-label="<?= $cartCount ?> productos en el carrito">
            <?= $cartCount ?>
        </span>
    <?php endif; ?>
    
    <!-- MINI CARRITO -->
    <div class="mini-cart" id="miniCart" role="dialog" aria-label="Mini carrito de compras">
        <?php if (empty($_SESSION['carrito'])): ?>
            <p class="mini-empty">Tu carrito está vacío</p>
        <?php else: ?>
            <div class="mini-items-container">
                <?php 
                $total = 0;
                foreach ($_SESSION['carrito'] as $item): 
                    $subtotal = $item['cantidad'] * $item['precio'];
                    $total += $subtotal;
                ?>
                    <div class="mini-item">
                        <img 
                            src="<?= htmlspecialchars($item['imagen'] ?? '/img/no-image.png') ?>" 
                            alt="<?= htmlspecialchars($item['nombre']) ?>"
                            loading="lazy"
                            width="56"
                            height="56"
                        >
                        <div class="mini-info">
                            <strong><?= htmlspecialchars($item['nombre']) ?></strong>
                            <span><?= $item['cantidad'] ?> × $<?= number_format($item['precio'], 2) ?></span>
                            <span class="mini-subtotal">Subtotal: $<?= number_format($subtotal, 2) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mini-cart-footer">
                <div class="mini-total">
                    <span>Total:</span>
                    <span class="mini-total-amount">$<?= number_format($total, 2) ?></span>
                </div>
                <a href="/?controller=pedido&action=carrito" class="mini-btn">
                    Ver carrito completo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>


                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr($_SESSION['usuario']['nombre'], 0, 1)) ?>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
                        <span class="user-role">Cliente</span>
                    </div>
                </div>

                <a href="/?controller=auth&action=logout" class="logout-btn">Salir</a>

            <?php else: ?>
                <a href="/?controller=auth&action=login" class="logout-btn">Iniciar sesión</a>
                <a href="/?controller=auth&action=registro" class="btn-register">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- ==================== SIDEBAR ==================== -->
<?php if (isset($_SESSION['usuario'])): ?>
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav-list">
    <li>
        <a href="/?controller=usuario&action=home" class="nav-link">
            🏠 Inicio
        </a>
    </li>

    <li>
        <a href="/?controller=producto&action=index" class="nav-link">
            🛒 Productos
        </a>
    </li>

    <li>
        <a href="/?controller=pedido&action=carrito" class="nav-link">
            🛍️ Carrito
            <?php if ($cartCount > 0): ?>
                <span class="nav-badge"><?= $cartCount ?></span>
            <?php endif; ?>
        </a>
    </li>

    <li>
        <a href="/?controller=pedido&action=historial" class="nav-link">
            📦 Mis Pedidos
        </a>
    </li>
    

</ul>


        <div class="nav-divider"></div>

        <ul class="nav-list">
             <li><a href="/?controller=usuario&action=perfil" class="nav-link">👤 Mi Perfil</a></li>
        </ul>

    </nav>
</aside>
<?php endif; ?>

<!-- ==================== CONTENIDO ==================== -->
<main class="content">
    <?= $content ?>
</main>

<!-- ==================== CHATBOT ==================== -->
<!-- BOTÓN CHAT -->
<!-- ==================== CHATBOT ==================== -->
<!-- ==================== CHATBOT ==================== -->
<!-- Botón flotante -->
<button id="chat-toggle">💬</button>

<!-- Contenedor del chatbot -->
<div id="chatbot">
    <div id="chat-header">
        <span>🤖 Soporte en Línea</span>
        <button id="chat-minimize">✕</button>
    </div>

    <div id="chat-body">
        <!-- Mensaje inicial -->
        <div class="message bot">
            <div class="message-content">
                Hola 👋 Soy el asistente virtual de la tienda. ¿En qué puedo ayudarte?
            </div>
        </div>

        <div class="typing-indicator">Escribiendo...</div>
    </div>

    <form id="chat-form">
        <input type="text" id="chat-input" placeholder="Escribe tu mensaje..." autocomplete="off">
        <button type="submit">Enviar</button>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const chatToggle = document.getElementById('chat-toggle');
    const chatbot = document.getElementById('chatbot');
    const chatMinimize = document.getElementById('chat-minimize');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatBody = document.getElementById('chat-body');
    const typingIndicator = document.querySelector('.typing-indicator');

    // Abrir chatbot
    chatToggle.addEventListener('click', function() {
        chatbot.style.display = 'flex';
        chatInput.focus();
    });

    // Cerrar chatbot
    chatMinimize.addEventListener('click', function() {
        chatbot.style.display = 'none';
    });

    // Función para agregar mensaje
    function agregarMensaje(texto, usuario = false) {
        const div = document.createElement('div');
        div.className = usuario ? 'message user' : 'message bot';
        div.innerHTML = `<div class="message-content">${texto}</div>`;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Enviar mensaje
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const mensaje = chatInput.value.trim();
        if (!mensaje) return;

        agregarMensaje(mensaje, true);
        chatInput.value = '';

        typingIndicator.style.display = 'block';

        fetch('/?controller=chatbot&action=responder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ mensaje })
        })
        .then(res => res.json())
        .then(data => {
            typingIndicator.style.display = 'none';
            agregarMensaje(data.respuesta || 'No entendí tu mensaje');
        })
        .catch(() => {
            typingIndicator.style.display = 'none';
            agregarMensaje('Error del sistema');
        });
    });

});
</script>


<script>
// ------------ MINI CARRITO ------------

// Función para actualizar el badge del carrito
function updateCartBadge(total) {
    const badge = document.querySelector('.cart-badge');
    
    if (!badge) return;

    if (total > 0) {
        badge.textContent = total;
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }
}

// Animación del carrito
function animateCartIcon() {
    const cartBtn = document.querySelector('.cart-icon-btn');
    if (!cartBtn) return;

    cartBtn.classList.add('bounce');
    setTimeout(() => cartBtn.classList.remove('bounce'), 500);
}

// Agregar producto al carrito vía AJAX
function addToCart(productId) {
    fetch('/?controller=pedido&action=agregarAjax', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + productId
    })
    .then(res => res.json())
    .then(data => {
        if (data.login) {
            window.location.href = '/?controller=usuario&action=login';
            return;
        }

        if (data.success) {
            // Actualiza badge y anima
            updateCartBadge(data.totalItems);
            animateCartIcon();
            showToast('Producto agregado al carrito 🛒');
        }
    });
}

// Mostrar toast
function showToast(text) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = text;
    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}

// Toggle mini carrito
function toggleMiniCart(event) {
    event.stopPropagation();
    const miniCart = document.getElementById('miniCart');
    if (!miniCart) return;

    miniCart.classList.toggle('active');
}

// Cerrar mini carrito al hacer clic fuera
document.addEventListener('click', function(event) {
    const miniCart = document.getElementById('miniCart');
    const cartBtn = document.querySelector('.cart-icon-btn');
    
    if (miniCart && cartBtn && !cartBtn.contains(event.target)) {
        miniCart.classList.remove('active');
    }
});

// Soporte teclado (Enter o Espacio)
const cartBtn = document.querySelector('.cart-icon-btn');
cartBtn?.addEventListener('keydown', function(event) {
    if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggleMiniCart(event);
    }
});
</script>



</body>

</html>   