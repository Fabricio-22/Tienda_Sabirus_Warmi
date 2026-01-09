<?php
/**
 * Modelo Producto
 * Compatible con SQLite
 * 
 * Maneja todas las operaciones CRUD de productos
 */

require_once __DIR__ . '/../config/database.php';

class Producto {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
    public function buscarPorNombre(string $texto): array
{
    $stmt = $this->db->prepare("
        SELECT * 
        FROM productos 
        WHERE nombre LIKE ?
    ");
    $stmt->execute(['%' . $texto . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function buscarAvanzado($q = '', $categoria = null)
{
    $sql = "SELECT * FROM productos WHERE 1=1";
    $params = [];

    if ($q !== '') {
        $sql .= " AND nombre LIKE ?";
        $params[] = "%$q%";
    }

    if ($categoria) {
        $sql .= " AND id_categoria = ?";
        $params[] = $categoria;
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /* ============================================================
       📋 CONSULTAS
    ============================================================ */

    /**
     * Obtiene todos los productos
     * 
     * @return array
     */
    public function getAll() {
        try {
            $query = "SELECT p.*, c.nombre as categoria_nombre 
                      FROM productos p 
                      LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                      ORDER BY p.id_producto DESC";
            
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene un producto por su ID
     * 
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                WHERE p.id_producto = ?
            ");
            $stmt->execute([$id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene productos por categoría
     * 
     * @param int $id_categoria
     * @return array
     */
    public function getByCategoria($id_categoria) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                WHERE p.id_categoria = ?
                ORDER BY p.id_producto DESC
            ");
            $stmt->execute([$id_categoria]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos por categoría: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca productos por término
     * 
     * @param string $termino
     * @return array
     */
    


    /**
     * Obtiene productos disponibles (con stock)
     * 
     * @return array
     */
    public function getDisponibles() {
        try {
            $query = "SELECT p.*, c.nombre as categoria_nombre 
                      FROM productos p 
                      LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                      WHERE p.stock > 0 AND p.estado = 'Disponible'
                      ORDER BY p.id_producto DESC";
            
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos disponibles: " . $e->getMessage());
            return [];
        }
    }

    /* ============================================================
       ✅ CREAR
    ============================================================ */

    /**
     * Crea un nuevo producto
     * 
     * @param array $data Datos del producto
     * @return int|false ID del producto creado o false si falla
     */
    public function crear($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO productos (nombre, descripcion, precio, stock, imagen, id_categoria, estado)
                VALUES (?, ?, ?, ?, ?, ?, 'Disponible')
            ");

            $resultado = $stmt->execute([
                $data['nombre'],
                $data['descripcion'] ?? null,
                $data['precio'],
                $data['stock'],
                $data['imagen'] ?? null,
                $data['id_categoria']
            ]);

            if ($resultado) {
                $idProducto = $this->db->lastInsertId();
                error_log("Producto creado exitosamente - ID: " . $idProducto);
                return $idProducto;
            }

            return false;

        } catch (PDOException $e) {
            error_log("Error al crear producto: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       ✏️ ACTUALIZAR
    ============================================================ */

    /**
     * Actualiza un producto existente
     * 
     * @param int $id ID del producto
     * @param array $data Datos a actualizar
     * @return bool
     */
    public function actualizar($id, $data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE productos 
                SET nombre = ?, 
                    descripcion = ?, 
                    precio = ?, 
                    stock = ?, 
                    imagen = ?, 
                    id_categoria = ?
                WHERE id_producto = ?
            ");

            $resultado = $stmt->execute([
                $data['nombre'],
                $data['descripcion'] ?? null,
                $data['precio'],
                $data['stock'],
                $data['imagen'] ?? null,
                $data['id_categoria'],
                $id
            ]);

            if ($resultado) {
                error_log("Producto actualizado - ID: " . $id);
            }

            return $resultado;

        } catch (PDOException $e) {
            error_log("Error al actualizar producto: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza solo el stock de un producto
     * 
     * @param int $id
     * @param int $nuevoStock
     * @return bool
     */
    public function actualizarStock($id, $nuevoStock) {
        try {
            $stmt = $this->db->prepare("
                UPDATE productos 
                SET stock = ? 
                WHERE id_producto = ?
            ");
            
            return $stmt->execute([$nuevoStock, $id]);
        } catch (PDOException $e) {
            error_log("Error al actualizar stock: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reduce el stock de un producto (para ventas)
     * 
     * @param int $id
     * @param int $cantidad
     * @return bool
     */
    public function reducirStock($id, $cantidad) {
        try {
            // Verificar stock disponible
            $producto = $this->getById($id);
            
            if (!$producto || $producto['stock'] < $cantidad) {
                error_log("Stock insuficiente para producto ID: " . $id);
                return false;
            }

            $nuevoStock = $producto['stock'] - $cantidad;
            
            $stmt = $this->db->prepare("
                UPDATE productos 
                SET stock = ? 
                WHERE id_producto = ?
            ");
            
            return $stmt->execute([$nuevoStock, $id]);
        } catch (PDOException $e) {
            error_log("Error al reducir stock: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cambia el estado de un producto
     * 
     * @param int $id
     * @param string $estado
     * @return bool
     */
    public function cambiarEstado($id, $estado) {
        try {
            $estadosValidos = ['Disponible', 'Agotado', 'Descontinuado'];
            
            if (!in_array($estado, $estadosValidos)) {
                error_log("Estado inválido: " . $estado);
                return false;
            }

            $stmt = $this->db->prepare("
                UPDATE productos 
                SET estado = ? 
                WHERE id_producto = ?
            ");
            
            return $stmt->execute([$estado, $id]);
        } catch (PDOException $e) {
            error_log("Error al cambiar estado: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       🗑️ ELIMINAR
    ============================================================ */

    /**
     * Elimina un producto
     * 
     * @param int $id
     * @return bool
     */
    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
            $resultado = $stmt->execute([$id]);

            if ($resultado) {
                error_log("Producto eliminado - ID: " . $id);
            }

            return $resultado;

        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       📊 ESTADÍSTICAS
    ============================================================ */

    /**
     * Cuenta el total de productos
     * 
     * @return int
     */
    public function contarProductos() {
        try {
            $query = "SELECT COUNT(*) FROM productos";
            return (int) $this->db->query($query)->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar productos: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Cuenta productos por categoría
     * 
     * @param int $id_categoria
     * @return int
     */
    public function contarPorCategoria($id_categoria) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE id_categoria = ?");
            $stmt->execute([$id_categoria]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar productos por categoría: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Obtiene productos con stock bajo
     * 
     * @param int $limite Stock mínimo
     * @return array
     */
    public function getStockBajo($limite = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                WHERE p.stock <= ?
                ORDER BY p.stock ASC
            ");
            $stmt->execute([$limite]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos con stock bajo: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene los productos más vendidos
     * 
     * @param int $limite
     * @return array
     */
    public function getMasVendidos($limite = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, c.nombre as categoria_nombre, 
                       SUM(dp.cantidad) as total_vendido
                FROM productos p 
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                LEFT JOIN detalle_pedido dp ON p.id_producto = dp.id_producto
                GROUP BY p.id_producto
                ORDER BY total_vendido DESC
                LIMIT ?
            ");
            $stmt->execute([$limite]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener productos más vendidos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Verifica si hay stock disponible
     * 
     * @param int $id
     * @param int $cantidad
     * @return bool
     */
    public function hayStock($id, $cantidad) {
        try {
            $producto = $this->getById($id);
            return $producto && $producto['stock'] >= $cantidad;
        } catch (Exception $e) {
            error_log("Error al verificar stock: " . $e->getMessage());
            return false;
        }
    }
}
?>