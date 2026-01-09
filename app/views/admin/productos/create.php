<?php
$title = 'Nuevo Producto';
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
    --shadow-md: 0 4px 16px rgba(0, 234, 255, 0.2);
    --radius-md: 12px;
    --transition: all 0.3s ease;
}

/* ==================== CONTENEDOR ==================== */
.table-section {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.section-header h2 {
    font-size: 2rem;
    color: var(--primary-color);
    margin: 0;
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

/* ==================== FORMULARIO ==================== */
.product-form {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
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

/* ==================== FILE UPLOAD ==================== */
.file-upload-wrapper {
    position: relative;
    background: var(--bg-dark);
    border: 2px dashed var(--border-color);
    border-radius: var(--radius-md);
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
}

.file-upload-wrapper:hover {
    border-color: var(--primary-color);
    background: rgba(0, 234, 255, 0.05);
}

.file-upload-wrapper.drag-over {
    border-color: var(--primary-color);
    background: rgba(0, 234, 255, 0.1);
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
    font-size: 3rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.upload-text {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.upload-hint {
    font-size: 0.875rem;
    color: var(--text-secondary);
    opacity: 0.7;
}

.image-preview {
    margin-top: 1rem;
    display: none;
}

.image-preview.active {
    display: block;
}

.preview-container {
    position: relative;
    max-width: 300px;
    margin: 0 auto;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.preview-container img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.remove-image {
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

.remove-image:hover {
    transform: scale(1.1);
}

/* ==================== SELECT CATEGORÍA ==================== */
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

/* ==================== BOTONES ==================== */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-primary,
.btn-secondary {
    padding: 1rem 2rem;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    flex: 1;
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

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .table-section {
        padding: 1rem;
    }

    .product-form {
        padding: 1.5rem;
    }
}

/* ==================== ALERTS ==================== */
.alert {
    padding: 1rem 1.25rem;
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid var(--success-color);
    color: var(--success-color);
}

.alert-error {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid var(--error-color);
    color: var(--error-color);
}
</style>

<div class="table-section">
    <!-- Header -->
    <div class="section-header">
        <a href="/?controller=producto&action=adminIndex" class="back-btn">
            ← Volver
        </a>
        <h2>➕ Agregar Producto</h2>
    </div>

    <!-- Alertas -->
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            ⚠️ Error al crear el producto. Intenta de nuevo.
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form method="POST" 
          action="/?controller=producto&action=guardar" 
          enctype="multipart/form-data" 
          class="product-form"
          id="productForm">

        <div class="form-grid">
            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre">Nombre<span>*</span></label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       placeholder="Ej: Camiseta Deportiva"
                       required
                       maxlength="100">
            </div>

            <!-- Categoría -->
            <div class="form-group">
                <label for="id_categoria">Categoría<span>*</span></label>
                <div class="select-wrapper">
                    <select id="id_categoria" name="id_categoria" required>
                        <option value="">Selecciona una categoría</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id_categoria'] ?>">
                                    <?= htmlspecialchars($categoria['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Precio -->
            <div class="form-group">
                <label for="precio">Precio ($)<span>*</span></label>
                <input type="number" 
                       id="precio" 
                       name="precio" 
                       placeholder="0.00"
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
                       placeholder="0"
                       min="0"
                       required>
            </div>

            <!-- Descripción -->
            <div class="form-group full-width">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          placeholder="Describe el producto..."
                          maxlength="500"></textarea>
            </div>

            <!-- Imagen -->
            <div class="form-group full-width">
                <label for="imagen">Imagen del Producto</label>
                <div class="file-upload-wrapper" id="fileUploadWrapper">
                    <input type="file" 
                           id="imagen" 
                           name="imagen" 
                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                           onchange="previewImage(event)">
                    
                    <div class="upload-icon">📸</div>
                    <div class="upload-text">
                        <strong>Click para subir</strong> o arrastra una imagen aquí
                    </div>
                    <div class="upload-hint">
                        JPG, PNG, GIF, WEBP - Máx 5MB
                    </div>
                </div>

                <!-- Preview de la imagen -->
                <div class="image-preview" id="imagePreview">
                    <div class="preview-container">
                        <img id="previewImg" src="" alt="Preview">
                        <button type="button" class="remove-image" onclick="removeImage()">
                            ×
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <button type="button" class="btn-secondary" onclick="window.location.href='/?controller=producto&action=adminIndex'">
                Cancelar
            </button>
            <button type="submit" class="btn-primary">
                💾 Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
// ==================== PREVIEW DE IMAGEN ====================
function previewImage(event) {
    const file = event.target.files[0];
    
    if (!file) return;

    // Validar tamaño (5MB máximo)
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
        document.getElementById('imagePreview').classList.add('active');
        document.getElementById('fileUploadWrapper').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

// ==================== REMOVER IMAGEN ====================
function removeImage() {
    document.getElementById('imagen').value = '';
    document.getElementById('imagePreview').classList.remove('active');
    document.getElementById('fileUploadWrapper').style.display = 'block';
}

// ==================== DRAG & DROP ====================
const wrapper = document.getElementById('fileUploadWrapper');

wrapper.addEventListener('dragover', (e) => {
    e.preventDefault();
    wrapper.classList.add('drag-over');
});

wrapper.addEventListener('dragleave', () => {
    wrapper.classList.remove('drag-over');
});

wrapper.addEventListener('drop', (e) => {
    e.preventDefault();
    wrapper.classList.remove('drag-over');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('imagen').files = files;
        previewImage({ target: { files: files } });
    }
});

// ==================== VALIDACIÓN ANTES DE ENVIAR ====================
document.getElementById('productForm').addEventListener('submit', function(e) {
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