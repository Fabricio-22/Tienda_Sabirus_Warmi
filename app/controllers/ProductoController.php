<?php
/**
 * ProductoController
 * Maneja todas las operaciones de productos
 * - Vista de usuario (catálogo)
 * - Administración de productos (CRUD)
 * - Subida de imágenes
 */

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';

class ProductoController {

    private $productoModel;
    private $categoriaModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->productoModel = new Producto();
        $this->categoriaModel = new Categoria();
    }
     
  public function buscar()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $q = trim($_GET['q'] ?? '');
    $categoria = $_GET['categoria'] ?? null;

    // Obtener categorías para el filtro (NO romper la vista)
    $categorias = $this->categoriaModel->getAll();

    // 🔍 BUSCAR POR TEXTO Y/O CATEGORÍA
    if ($q !== '' || $categoria) {
        $productos = $this->productoModel->buscarAvanzado($q, $categoria);
    } else {
        $productos = $this->productoModel->getAll();
    }

    require __DIR__ . '/../views/productos/index.php';
}



    /* ============================================================
       🔒 SEGURIDAD
    ============================================================ */

    /**
     * Verifica que el usuario sea administrador
     */
    private function verificarAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_rol'] != 1) {
            header("Location: /?controller=auth&action=login");
            exit;
        }
    }

    /* ============================================================
       👥 VISTAS DE USUARIO
    ============================================================ */

    /**
     * Muestra el catálogo de productos para usuarios
     */
    public function index() {
        $productos = $this->productoModel->getAll();
        $categorias = $this->categoriaModel->getAll();
        require __DIR__ . '/../views/productos/index.php';
    }

    /**
     * Muestra el detalle de un producto
     */
    public function detalle() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /?controller=producto&action=index");
            exit;
        }

        $producto = $this->productoModel->getById($id);

        if (!$producto) {
            header("Location: /?controller=producto&action=index&error=producto_no_encontrado");
            exit;
        }

        require __DIR__ . '/../views/productos/detalle.php';
    }

    /**
     * Filtra productos por categoría
     */
    public function filtrar() {
        $id_categoria = $_GET['categoria'] ?? null;

        if (!$id_categoria) {
            header("Location: /?controller=producto&action=index");
            exit;
        }

        $productos = $this->productoModel->getByCategoria($id_categoria);
        $categorias = $this->categoriaModel->getAll();

        require __DIR__ . '/../views/productos/index.php';
    }

    /* ============================================================
       🔴 ADMINISTRACIÓN - LISTAR
    ============================================================ */

    /**
     * Lista todos los productos (vista admin)
     */
    public function adminIndex() {
        $this->verificarAdmin();
        $productos = $this->productoModel->getAll();
        require __DIR__ . '/../views/admin/productos/index.php';
    }

    /* ============================================================
       🟢 ADMINISTRACIÓN - CREAR
    ============================================================ */

    /**
     * Muestra el formulario para crear producto
     */
    public function crear() {
        $this->verificarAdmin();
        $categorias = $this->categoriaModel->getAll();
        require __DIR__ . '/../views/admin/productos/create.php';
    }

    /**
     * Guarda un nuevo producto
     */
    public function guardar() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /?controller=producto&action=crear");
            exit;
        }

        try {
            // Obtener y validar datos
            $nombre = trim($_POST['nombre'] ?? '');
            $precio = floatval($_POST['precio'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $id_categoria = intval($_POST['id_categoria'] ?? 0);
            $descripcion = trim($_POST['descripcion'] ?? '');

            // Validaciones
            if (empty($nombre)) {
                header("Location: /?controller=producto&action=crear&error=nombre_vacio");
                exit;
            }

            if ($precio <= 0) {
                header("Location: /?controller=producto&action=crear&error=precio_invalido");
                exit;
            }

            if ($stock < 0) {
                header("Location: /?controller=producto&action=crear&error=stock_invalido");
                exit;
            }

            if ($id_categoria <= 0) {
                header("Location: /?controller=producto&action=crear&error=categoria_invalida");
                exit;
            }

            // Procesar imagen
            $rutaImagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $rutaImagen = $this->procesarImagen($_FILES['imagen']);
                
                if (!$rutaImagen) {
                    header("Location: /?controller=producto&action=crear&error=imagen_invalida");
                    exit;
                }
            }

            // Preparar datos
            $data = [
                'nombre' => $nombre,
                'precio' => $precio,
                'stock' => $stock,
                'id_categoria' => $id_categoria,
                'descripcion' => $descripcion,
                'imagen' => $rutaImagen
            ];

            // Guardar en BD
            $resultado = $this->productoModel->crear($data);

            if ($resultado) {
                header("Location: /?controller=producto&action=adminIndex&success=producto_creado");
            } else {
                header("Location: /?controller=producto&action=crear&error=error_guardar");
            }

        } catch (Exception $e) {
            error_log("Error al guardar producto: " . $e->getMessage());
            header("Location: /?controller=producto&action=crear&error=error_servidor");
        }

        exit;
    }

    /* ============================================================
       🟡 ADMINISTRACIÓN - EDITAR
    ============================================================ */

    /**
     * Muestra el formulario para editar producto
     */
    public function edit() {
        $this->verificarAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /?controller=producto&action=adminIndex");
            exit;
        }

        $producto = $this->productoModel->getById($id);
        
        if (!$producto) {
            header("Location: /?controller=producto&action=adminIndex&error=producto_no_encontrado");
            exit;
        }

        $categorias = $this->categoriaModel->getAll();

        require __DIR__ . '/../views/admin/productos/edit.php';
    }

    /**
     * Actualiza un producto existente
     */
    public function update() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /?controller=producto&action=adminIndex");
            exit;
        }

        try {
            $id = intval($_POST['id_producto'] ?? 0);

            if ($id <= 0) {
                header("Location: /?controller=producto&action=adminIndex&error=id_invalido");
                exit;
            }

            // Obtener datos
            $nombre = trim($_POST['nombre'] ?? '');
            $precio = floatval($_POST['precio'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);
            $id_categoria = intval($_POST['id_categoria'] ?? 0);
            $descripcion = trim($_POST['descripcion'] ?? '');

            // Validaciones
            if (empty($nombre) || $precio <= 0 || $stock < 0 || $id_categoria <= 0) {
                header("Location: /?controller=producto&action=edit&id={$id}&error=datos_invalidos");
                exit;
            }

            // Imagen: mantener la actual si no se sube una nueva
            $rutaImagen = $_POST['imagen_actual'] ?? null;

            // Si se subió nueva imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nuevaRuta = $this->procesarImagen($_FILES['imagen']);
                
                if ($nuevaRuta) {
                    // Eliminar imagen anterior si existe
                    if ($rutaImagen && file_exists(__DIR__ . '/../../public' . $rutaImagen)) {
                        unlink(__DIR__ . '/../../public' . $rutaImagen);
                    }
                    $rutaImagen = $nuevaRuta;
                }
            }

            // Preparar datos
            $data = [
                'nombre' => $nombre,
                'precio' => $precio,
                'stock' => $stock,
                'id_categoria' => $id_categoria,
                'descripcion' => $descripcion,
                'imagen' => $rutaImagen
            ];

            // Actualizar en BD
            $resultado = $this->productoModel->actualizar($id, $data);

            if ($resultado) {
                header("Location: /?controller=producto&action=adminIndex&success=producto_actualizado");
            } else {
                header("Location: /?controller=producto&action=edit&id={$id}&error=error_actualizar");
            }

        } catch (Exception $e) {
            error_log("Error al actualizar producto: " . $e->getMessage());
            header("Location: /?controller=producto&action=adminIndex&error=error_servidor");
        }

        exit;
    }

    /* ============================================================
       🔴 ADMINISTRACIÓN - ELIMINAR
    ============================================================ */

    /**
     * Elimina un producto
     */
    public function delete() {
        $this->verificarAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /?controller=producto&action=adminIndex&error=id_invalido");
            exit;
        }

        try {
            // Obtener producto para eliminar imagen
            $producto = $this->productoModel->getById($id);

            // Eliminar de BD
            $resultado = $this->productoModel->eliminar($id);

            if ($resultado) {
                // Eliminar imagen física si existe
                if ($producto && $producto['imagen']) {
                    $rutaImagen = __DIR__ . '/../../public' . $producto['imagen'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }

                header("Location: /?controller=producto&action=adminIndex&success=producto_eliminado");
            } else {
                header("Location: /?controller=producto&action=adminIndex&error=error_eliminar");
            }

        } catch (Exception $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            header("Location: /?controller=producto&action=adminIndex&error=error_servidor");
        }

        exit;
    }

    /* ============================================================
       📸 MANEJO DE IMÁGENES
    ============================================================ */

    /**
     * Procesa y guarda una imagen subida
     * 
     * @param array $file Archivo de $_FILES
     * @return string|false Ruta relativa de la imagen o false si falla
     */
    private function procesarImagen($file) {
        try {
            // Validar errores de subida
            if ($file['error'] !== UPLOAD_ERR_OK) {
                error_log("Error en upload: " . $file['error']);
                return false;
            }

            // Tipos permitidos
            $tiposPermitidos = [
                'image/jpeg' => 'jpg',
                'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];

            $tipoArchivo = $file['type'];

            if (!isset($tiposPermitidos[$tipoArchivo])) {
                error_log("Tipo no permitido: " . $tipoArchivo);
                return false;
            }

            // Validar tamaño (5MB máximo)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxSize) {
                error_log("Archivo muy grande: " . $file['size'] . " bytes");
                return false;
            }

            // Obtener extensión real
            $extension = $tiposPermitidos[$tipoArchivo];

            // Crear directorio si no existe
            $directorioDestino = __DIR__ . '/../../public/uploads/productos/';
            
            if (!is_dir($directorioDestino)) {
                if (!mkdir($directorioDestino, 0755, true)) {
                    error_log("No se pudo crear directorio: " . $directorioDestino);
                    return false;
                }
            }

            // Generar nombre único
            $nombreArchivo = 'producto_' . uniqid() . '_' . time() . '.' . $extension;
            $rutaCompleta = $directorioDestino . $nombreArchivo;

            // Mover archivo
            if (move_uploaded_file($file['tmp_name'], $rutaCompleta)) {
                error_log("Imagen guardada: " . $nombreArchivo);
                return '/uploads/productos/' . $nombreArchivo;
            } else {
                error_log("Error al mover archivo");
                return false;
            }

        } catch (Exception $e) {
            error_log("Error al procesar imagen: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Valida que un archivo sea una imagen válida
     * 
     * @param string $rutaArchivo Ruta completa del archivo
     * @return bool
     */
    private function esImagenValida($rutaArchivo) {
        if (!file_exists($rutaArchivo)) {
            return false;
        }

        $infoImagen = @getimagesize($rutaArchivo);
        
        if ($infoImagen === false) {
            return false;
        }

        $tiposValidos = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
        
        return in_array($infoImagen[2], $tiposValidos);
    }
}
?>