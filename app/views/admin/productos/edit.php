<?php
$title = 'Editar Producto - ' . htmlspecialchars($producto['nombre']);
ob_start();
?>

<style>
/* ==================== VARIABLES ==================== */
:root {
    --primary-color: #00eaff;
    --primary-dark: #00b8cc;
    --bg-dark: #0a0a14;
    --bg-card: #111827;
    --border-color: #374151;
    --text-primary: #ffffff;
    --text-secondary: #9ca3af;
    --success-color: #10b981;
    --error-color: #ef4444;
    --warning-color: #f59e0b;
    --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
    --radius-md: 12px;
    --transition: all 0.3s ease;
}

/* ==================== CONTENEDOR ==================== */
.edit-section {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 2rem;
}

/* ==================== HEADER ==================== */
.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: var(--bg-card);
    border: 2px solid var(--border-color);
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 500;
    transition: var(--transition);
}

.back-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateX(-5px);
}

.section-title {
    font-size: 2rem;
    color: var(--primary-color);
    margin: 0;
}

/* ==================== CONTENEDOR PRINCIPAL ==================== */
.edit-container {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

/* ==================== LAYOUT GRID ==================== */
.edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}

/* ==================== COLUMNA IZQUIERDA (IMAGEN) ==================== */
.image-section {
    background: var(--bg-dark);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    border-right: 1px solid var(--border-color);
}

.current-image-wrapper {
    position: relative;
    aspect-ratio: 1;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid var(--border-color);
    background: #000;
}

.current-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    padding: 1rem;
    color: white;
    font-size: 0.875rem;
}

.upload-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upload-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.file-upload-wrapper {
    position: relative;
    background: var(--bg-card);
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-md);
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
}

.file-upload-wrapper:hover {
    border-color: var(--primary-color);
    background: rgba(0, 234, 255, 0.05);
}

.file-upload-wrapper input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}

.upload-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
}

.upload-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.upload-hint {
    font-size: 0.8rem;
    color: var(--text-secondary);
    opacity: 0.7;
    margin-top: 0.5rem;
}

.new-image-preview {
    display: none;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid var(--primary-color);
    position: relative;
}

.new-image-preview.active {
    display: block;
}

.new-image-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.remove-preview {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: var(--error-color);
    color: white;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: var(--transition);
}

.remove-preview:hover {
    transform: scale(1.1);
}

/* ==================== COLUMNA DERECHA (FORMULARIO) ==================== */
.form-section {
    padding: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.form-group label span {
    color: var(--error-color);
    margin-left: 0.25rem;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 0.875rem 1rem;
    background: var(--bg-dark);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-size: 0.95rem;
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
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.select-wrapper {
    position: relative;
}

.select-wrapper::after {
    content: '▼';
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-secondary);
    font-size: 0.75rem;
}

/* ==================== ESTADO DEL PRODUCTO ==================== */
.product-status {
    grid-column: 1 / -1;
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-dark);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
}

.status-item {
    flex: 1;
    text-align: center;
}

.status-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.status-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

/* ==================== BOTONES ==================== */
.form-actions {
    grid-column: 1 / -1;
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-primary,
.btn-secondary,
.btn-danger {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    flex: 1;
    text-decoration: none;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: #000;
    box-shadow: 0 4px 15px rgba(0, 234, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 234, 255, 0.4);
}

.btn-secondary {
    background: transparent;
    border: 2px solid var(--border-color);
    color: var(--text-secondary);
}

.btn-secondary:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-danger {
    background: transparent;
    border: 2px solid var(--error-color);
    color: var(--error-color);
}

.btn-danger:hover {
    background: var(--error-color);
    color: white;
}

/* ==================== ALERTAS ==================== */
.alert {
    padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-error {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid var(--error-color);
    color: var(--error-color);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 968px) {
    .edit-grid {
        grid-template-columns: 1fr;
    }

    .image-section {
        border-right: none;
        border-bottom: 1px solid var(--border-color);
    }

    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .edit-section {
        padding: 1rem;
    }

    .image-section,
    .form-section {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="edit-section">
    <!-- Header -->
    <div class="section-header">
        <a href="/?controller=producto&action=adminIndex" class="back-btn">
            ← Volver
        </a>
        <h1 class="section-title">✏️ Editar Producto</h1>
    </div>

    <!-- Alertas -->
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ⚠️ <?php
            switch($_GET['error']) {
                case 'datos_invalidos':
                    echo 'Por favor completa todos los campos correctamente';
                    break;
                case 'imagen_invalida':
                    echo 'La imagen no es válida. Solo JPG, PNG, GIF o WEBP';
                    break;
                default:
                    echo 'Error al actualizar el producto';
            }
            ?>
        </div>
    <?php endif; ?>

    <!-- Contenedor Principal -->
    <div class="edit-container">
        <form method="POST" 
              action="/?controller=producto&action=update" 
              enctype="multipart/form-data"
              id="editForm"
              class="edit-grid">

            <!-- Campo oculto para el ID -->
            <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">
            <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($producto['imagen'] ?? '') ?>">

            <!-- ========== COLUMNA IZQUIERDA: IMAGEN ========== -->
            <div class="image-section">
                <!-- Imagen Actual -->
                <div>
                    <div class="upload-label">📸 Imagen Actual</div>
                    <div class="current-image-wrapper">
                        <img src="<?= htmlspecialchars($producto['imagen'] ?: '/img/no-image.png') ?>" 
                             alt="<?= htmlspecialchars($producto['nombre']) ?>"
                             id="currentImage">
                        <div class="image-overlay">
                            Imagen actual del producto
                        </div>
                    </div>
                </div>

                <!-- Subir Nueva Imagen -->
                <div class="upload-section">
                    <div class="upload-label">🔄 Cambiar Imagen</div>
                    
                    <div class="file-upload-wrapper" id="fileUploadWrapper">
                        <input type="file" 
                               id="imagen" 
                               name="imagen" 
                               accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                               onchange="previewNewImage(event)">
                        
                        <div class="upload-icon">📤</div>
                        <div class="upload-text">
                            Click para cambiar imagen
                        </div>
                        <div class="upload-hint">
                            JPG, PNG, GIF, WEBP - Máx 5MB
                        </div>
                    </div>

                    <!-- Preview de Nueva Imagen -->
                    <div class="new-image-preview" id="newImagePreview">
                        <img id="previewImg" src="" alt="Preview">
                        <button type="button" class="remove-preview" onclick="removeNewImage()">
                            ×
                        </button>
                    </div>
                </div>
            </div>

            <!-- ========== COLUMNA DERECHA: FORMULARIO ========== -->
            <div class="form-section">
                <div class="form-grid">
                    
                    <!-- Estado del Producto -->
                    <div class="product-status">
                        <div class="status-item">
                            <div class="status-label">ID</div>
                            <div class="status-value">#<?= $producto['id_producto'] ?></div>
                        </div>
                        <div class="status-item">
                            <div class="status-label">Estado</div>
                            <div class="status-value"><?= htmlspecialchars($producto['estado'] ?? 'Disponible') ?></div>
                        </div>
                        <div class="status-item">
                            <div class="status-label">Creado</div>
                            <div class="status-value">
                                <?= date('d/m/Y', strtotime($producto['fecha_creacion'] ?? 'now')) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group full-width">
                        <label for="nombre">Nombre del Producto<span>*</span></label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               value="<?= htmlspecialchars($producto['nombre']) ?>"
                               placeholder="Ej: Camiseta Deportiva"
                               required
                               maxlength="100">
                    </div>

                    <!-- Categoría -->
                    <div class="form-group">
                        <label for="id_categoria">Categoría<span>*</span></label>
                        <div class="select-wrapper">
                            <select id="id_categoria" name="id_categoria" required>
                                <option value="">Selecciona...</option>
                                <?php if (!empty($categorias)): ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id_categoria'] ?>"
                                                <?= $producto['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <div class="select-wrapper">
                            <select id="estado" name="estado">
                                <option value="Disponible" <?= ($producto['estado'] ?? 'Disponible') == 'Disponible' ? 'selected' : '' ?>>
                                    Disponible
                                </option>
                                <option value="Agotado" <?= ($producto['estado'] ?? '') == 'Agotado' ? 'selected' : '' ?>>
                                    Agotado
                                </option>
                                <option value="Descontinuado" <?= ($producto['estado'] ?? '') == 'Descontinuado' ? 'selected' : '' ?>>
                                    Descontinuado
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Precio -->
                    <div class="form-group">
                        <label for="precio">Precio ($)<span>*</span></label>
                        <input type="number" 
                               id="precio" 
                               name="precio" 
                               value="<?= $producto['precio'] ?>"
                               step="0.01"
                               min="0"
                               required>
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label for="stock">Stock<span>*</span></label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="<?= $producto['stock'] ?>"
                               min="0"
                               required>
                    </div>

                    <!-- Descripción -->
                    <div class="form-group full-width">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" 
                                  name="descripcion" 
                                  placeholder="Describe el producto..."
                                  maxlength="500"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="form-actions">
                        <a href="/?controller=producto&action=adminIndex" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            💾 Guardar Cambios
                        </button>
                        <button type="button" 
                                class="btn-danger" 
                                onclick="confirmarEliminar()">
                            🗑️ Eliminar
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
// ==================== PREVIEW NUEVA IMAGEN ====================
function previewNewImage(event) {
    const file = event.target.files[0];
    
    if (!file) return;

    // Validar tamaño
    if (file.size > 5 * 1024 * 1024) {
        alert('La imagen es muy grande. Máximo 5MB');
        event.target.value = '';
        return;
    }

    // Validar tipo
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Formato no válido. Solo JPG, PNG, GIF o WEBP');
        event.target.value = '';
        return;
    }

    // Mostrar preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('newImagePreview').classList.add('active');
    };
    reader.readAsDataURL(file);
}

// ==================== REMOVER NUEVA IMAGEN ====================
function removeNewImage() {
    document.getElementById('imagen').value = '';
    document.getElementById('newImagePreview').classList.remove('active');
}

// ==================== CONFIRMAR ELIMINACIÓN ====================
function confirmarEliminar() {
    const nombre = "<?= htmlspecialchars($producto['nombre']) ?>";
    const id = <?= $producto['id_producto'] ?>;
    
    const confirmacion = confirm(
        `¿Estás seguro de eliminar este producto?\n\n"${nombre}"\n\nEsta acción no se puede deshacer.`
    );
    
    if (confirmacion) {
        window.location.href = `/?controller=producto&action=delete&id=${id}`;
    }
}

// ==================== VALIDACIÓN ANTES DE ENVIAR ====================
document.getElementById('editForm').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    const precio = parseFloat(document.getElementById('precio').value);
    const stock = parseInt(document.getElementById('stock').value);
    const categoria = document.getElementById('id_categoria').value;

    if (!nombre || nombre.length < 3) {
        e.preventDefault();
        alert('El nombre debe tener al menos 3 caracteres');
        return;
    }

    if (precio <= 0) {
        e.preventDefault();
        alert('El precio debe ser mayor a 0');
        return;
    }

    if (stock < 0) {
        e.preventDefault();
        alert('El stock no puede ser negativo');
        return;
    }

    if (!categoria) {
        e.preventDefault();
        alert('Selecciona una categoría');
        return;
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin_layout.php';
?>