<?php
$title = "Mi Perfil";
ob_start();

$usuario = $_SESSION['usuario'] ?? null;
$direccion = $direccion ?? [];
$pedidos = $pedidos ?? [];
?>

<style>
/* ==================== PERFIL LAYOUT ==================== */
.perfil-wrapper {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

/* ==================== SIDEBAR PERFIL ==================== */
.perfil-sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.perfil-avatar-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    text-align: center;
    box-shadow: var(--shadow-md);
    margin-bottom: 1.5rem;
}

.avatar-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 1.5rem;
}

.avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: #000;
    border: 4px solid var(--bg-dark);
    box-shadow: 0 0 30px rgba(0, 234, 255, 0.4);
    animation: pulse-glow 3s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(0, 234, 255, 0.4);
    }
    50% {
        box-shadow: 0 0 40px rgba(0, 234, 255, 0.7);
    }
}

.avatar-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 3px solid var(--bg-card);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.perfil-name {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.3rem;
    text-shadow: 0 0 15px rgba(0, 234, 255, 0.3);
}

.perfil-email {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

.perfil-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
}

.stat-box {
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 1rem;
    text-align: center;
    transition: var(--transition);
}

.stat-box:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.2);
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary-color);
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

.stat-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 0.3rem;
}

.perfil-menu {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: var(--transition);
    border-left: 3px solid transparent;
    cursor: pointer;
}

.menu-item:hover {
    background: var(--bg-dark);
    color: var(--primary-color);
    border-left-color: var(--primary-color);
}

.menu-item.active {
    background: var(--bg-dark);
    color: var(--primary-color);
    border-left-color: var(--primary-color);
    font-weight: 700;
}

.menu-icon {
    font-size: 1.3rem;
}

/* ==================== CONTENIDO PRINCIPAL ==================== */
.perfil-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.perfil-header {
    background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-dark) 100%);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.header-title {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.header-title h1 {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--primary-color);
    margin: 0;
    text-shadow: 0 0 20px rgba(0, 234, 255, 0.3);
}

.header-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
}

.perfil-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    animation: slideInUp 0.5s ease;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.perfil-card:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.4rem;
    color: var(--text-primary);
    font-weight: 700;
}

.card-icon {
    font-size: 1.8rem;
}

.card-badge {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
}

/* ==================== FORMULARIOS ==================== */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.label-icon {
    font-size: 1.1rem;
    color: var(--primary-color);
}

.form-group input,
.form-group textarea,
.form-group select {
    padding: 0.9rem 1.2rem;
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 234, 255, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.input-icon-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    font-size: 1.2rem;
}

.input-icon-wrapper input {
    padding-left: 3rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-primary {
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-secondary {
    padding: 1rem 2rem;
    background: var(--bg-dark);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
}

.btn-secondary:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

/* ==================== SEGURIDAD CARD ==================== */
.security-options {
    display: grid;
    gap: 1rem;
}

.security-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: var(--transition);
}

.security-item:hover {
    border-color: var(--primary-color);
    transform: translateX(5px);
}

.security-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.security-icon {
    font-size: 1.8rem;
}

.security-text h4 {
    color: var(--text-primary);
    margin-bottom: 0.3rem;
}

.security-text p {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.btn-change {
    padding: 0.6rem 1.2rem;
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.btn-change:hover {
    background: var(--primary-color);
    color: #000;
}

/* ==================== ACTIVIDAD RECIENTE ==================== */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-dark);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: var(--transition);
}

.activity-item:hover {
    border-color: var(--primary-color);
    transform: translateX(5px);
}

.activity-icon-wrapper {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.activity-details {
    flex: 1;
}

.activity-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.3rem;
}

.activity-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}

.activity-time {
    color: var(--primary-color);
    font-size: 0.8rem;
    font-weight: 600;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .perfil-wrapper {
        grid-template-columns: 1fr;
    }
    
    .perfil-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .perfil-stats {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
    }
    
    .security-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}
</style>

<div class="perfil-wrapper">
    <!-- Sidebar -->
    <aside class="perfil-sidebar">
        <div class="perfil-avatar-card">
            <div class="avatar-container">
                <div class="avatar">
                    👤
                </div>
                <div class="avatar-badge">✓</div>
            </div>
            
            <div class="perfil-name"><?= htmlspecialchars($usuario['nombre'] ?? 'Usuario') ?></div>
            <div class="perfil-email"><?= htmlspecialchars($usuario['correo'] ?? '') ?></div>
            
            <div class="perfil-stats">
                <div class="stat-box">
                    <span class="stat-number"><?= count($pedidos) ?></span>
                    <span class="stat-label">Pedidos</span>
                </div>
                <div class="stat-box">
                    <span class="stat-number">
                        <?php 
                            $diasRegistrado = isset($usuario['fecha_registro']) 
                                ? floor((time() - strtotime($usuario['fecha_registro'])) / 86400)
                                : 0;
                            echo $diasRegistrado;
                        ?>
                    </span>
                    <span class="stat-label">Días</span>
                </div>
            </div>
        </div>
        
        <nav class="perfil-menu">
            <a href="#datos" class="menu-item active" onclick="showSection('datos')">
                <span class="menu-icon">📝</span>
                <span>Datos Personales</span>
            </a>
            <a href="#direccion" class="menu-item" onclick="showSection('direccion')">
                <span class="menu-icon">📍</span>
                <span>Dirección</span>
            </a>
            <a href="#seguridad" class="menu-item" onclick="showSection('seguridad')">
                <span class="menu-icon">🔒</span>
                <span>Seguridad</span>
            </a>
            <a href="#actividad" class="menu-item" onclick="showSection('actividad')">
                <span class="menu-icon">📊</span>
                <span>Actividad</span>
            </a>
        </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main class="perfil-content">
        <!-- Header -->
        <div class="perfil-header">
            <div class="header-title">
                <h1>⚙️ Mi Perfil</h1>
            </div>
            <p class="header-subtitle">Gestiona tu información personal y preferencias</p>
        </div>
        
        <!-- Datos Personales -->
        <div id="section-datos" class="perfil-card">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">📝</span>
                    Datos Personales
                </h2>
                <span class="card-badge">Verificado</span>
            </div>
            
            <form method="POST" action="/?controller=usuario&action=actualizarPerfil">
                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            <span class="label-icon">👤</span>
                            Nombre Completo
                        </label>
                        <input type="text" 
                               name="nombre"
                               value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" 
                               placeholder="Ingresa tu nombre completo"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <span class="label-icon">📧</span>
                            Correo Electrónico
                        </label>
                        <input type="email" 
                               value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>" 
                               placeholder="tu@email.com"
                               disabled
                               style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <span class="label-icon">📱</span>
                            Teléfono
                        </label>
                        <input type="tel" 
                               name="telefono"
                               value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" 
                               placeholder="+593 999 999 999"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <span class="label-icon">📅</span>
                            Miembro desde
                        </label>
                        <input type="text" 
                               value="<?= isset($usuario['fecha_registro']) ? date('d/m/Y', strtotime($usuario['fecha_registro'])) : 'N/A' ?>" 
                               disabled
                               style="opacity: 0.6; cursor: not-allowed;">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        💾 Guardar Cambios
                    </button>
                    <button type="reset" class="btn-secondary">
                        ↺ Restablecer
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Dirección de Envío -->
        <div id="section-direccion" class="perfil-card" style="display: none;">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">📍</span>
                    Dirección de Envío
                </h2>
            </div>
            
            <form method="POST" action="/?controller=direccion&action=guardar">
                <div class="form-group">
                    <label>
                        <span class="label-icon">🏠</span>
                        Dirección Completa
                    </label>
                    <textarea name="direccion" 
                              placeholder="Ej: Calle Principal 123, entre Av. Secundaria y Calle Terciaria"
                              required><?= htmlspecialchars($direccion['direccion'] ?? '') ?></textarea>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            <span class="label-icon">🌆</span>
                            Ciudad
                        </label>
                        <input type="text" 
                               name="ciudad"
                               value="<?= htmlspecialchars($direccion['ciudad'] ?? '') ?>"
                               placeholder="Ej: Ambato">
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <span class="label-icon">🗺️</span>
                            Provincia
                        </label>
                        <input type="text" 
                               name="provincia"
                               value="<?= htmlspecialchars($direccion['provincia'] ?? '') ?>"
                               placeholder="Ej: Tungurahua">
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <span class="label-icon">📮</span>
                            Código Postal
                        </label>
                        <input type="text" 
                               name="codigo_postal"
                               value="<?= htmlspecialchars($direccion['codigo_postal'] ?? '') ?>"
                               placeholder="Ej: 180101">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        💾 Guardar Dirección
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Seguridad -->
        <div id="section-seguridad" class="perfil-card" style="display: none;">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">🔒</span>
                    Seguridad de la Cuenta
                </h2>
            </div>
            
            <div class="security-options">
                <div class="security-item">
                    <div class="security-info">
                        <span class="security-icon">🔑</span>
                        <div class="security-text">
                            <h4>Contraseña</h4>
                            <p>Última actualización: Hace 30 días</p>
                        </div>
                    </div>
                    <button class="btn-change" onclick="alert('Función de cambio de contraseña')">
                        Cambiar
                    </button>
                </div>
                
                <div class="security-item">
                    <div class="security-info">
                        <span class="security-icon">📧</span>
                        <div class="security-text">
                            <h4>Verificación de Email</h4>
                            <p>Tu email está verificado</p>
                        </div>
                    </div>
                    <span style="color: var(--primary-color); font-weight: 700;">✓ Verificado</span>
                </div>
                
                <div class="security-item">
                    <div class="security-info">
                        <span class="security-icon">🛡️</span>
                        <div class="security-text">
                            <h4>Autenticación de Dos Factores</h4>
                            <p>Protección adicional para tu cuenta</p>
                        </div>
                    </div>
                    <button class="btn-change" onclick="alert('Función 2FA')">
                        Activar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Actividad Reciente -->
        <div id="section-actividad" class="perfil-card" style="display: none;">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="card-icon">📊</span>
                    Actividad Reciente
                </h2>
            </div>
            
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon-wrapper">🛒</div>
                    <div class="activity-details">
                        <div class="activity-title">Nuevo pedido realizado</div>
                        <div class="activity-description">Pedido #12345 por $150.00</div>
                        <div class="activity-time">Hace 2 horas</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon-wrapper">✏️</div>
                    <div class="activity-details">
                        <div class="activity-title">Perfil actualizado</div>
                        <div class="activity-description">Actualizaste tu información personal</div>
                        <div class="activity-time">Hace 1 día</div>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon-wrapper">🔐</div>
                    <div class="activity-details">
                        <div class="activity-title">Inicio de sesión</div>
                        <div class="activity-description">Accediste desde Ambato, Ecuador</div>
                        <div class="activity-time">Hace 3 días</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function showSection(section) {
    // Ocultar todas las secciones
    const sections = ['datos', 'direccion', 'seguridad', 'actividad'];
    sections.forEach(s => {
        const el = document.getElementById(`section-${s}`);
        if (el) el.style.display = 'none';
    });
    
    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(`section-${section}`);
    if (selectedSection) {
        selectedSection.style.display = 'block';
        selectedSection.style.animation = 'slideInUp 0.5s ease';
    }
    
    // Actualizar menú activo
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });
    event.target.closest('.menu-item').classList.add('active');
    
    // Prevenir navegación
    event.preventDefault();
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>