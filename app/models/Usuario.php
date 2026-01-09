<?php
/**
 * Modelo Usuario
 * Compatible 100% con SQLite
 * 
 * @author Tu Nombre
 * @version 2.1 - SQLite Edition
 */

require_once __DIR__ . '/../config/database.php';

class Usuario {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // ASEGÚRATE DE QUE ESTO ESTÉ AQUÍ
   public function registrar($data) {
    try {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, correo, contrasena, telefono, id_rol, activo)
            VALUES (?, ?, ?, ?, ?, 1)
        ");

        return $stmt->execute([
            $data['nombre'],
            $data['correo'],
            $data['contrasena'],
            $data['telefono'] ?? null,
            $data['id_rol'] ?? 2
        ]);
    } catch (PDOException $e) {
        error_log("Error registro usuario: " . $e->getMessage());
        return false;
    }
}


    /* ============================================================
       📋 CONSULTAS GENERALES
    ============================================================ */

    public function getAll() {
        try {
            $query = "SELECT u.*, r.nombre as nombre_rol 
                      FROM usuarios u 
                      LEFT JOIN roles r ON u.id_rol = r.id_rol 
                      ORDER BY u.id_usuario DESC";
            
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id_usuario) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, r.nombre as nombre_rol 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.id_usuario = ?
            ");
            $stmt->execute([$id_usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return false;
        }
    }

    public function getByEmail($correo) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ?");
            $stmt->execute([$correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuario por email: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       🔐 AUTENTICACIÓN
    ============================================================ */

    public function login($correo, $contrasena) {
        try {
            // SQLite: Verificar usuario activo
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ? AND activo = 1");
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                error_log("Login fallido: Usuario no encontrado o inactivo - " . $correo);
                return false;
            }

            if (!password_verify($contrasena, $usuario['contrasena'])) {
                error_log("Login fallido: Contraseña incorrecta - " . $correo);
                return false;
            }

            unset($usuario['contrasena']);
            error_log("Login exitoso: " . $correo);
            return $usuario;

        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       📝 REGISTRO
    ============================================================ */

   

    public function existeCorreo($correo, $excluirId = null) {
        try {
            $query = "SELECT id_usuario FROM usuarios WHERE correo = ?";
            $params = [$correo];

            if ($excluirId !== null) {
                $query .= " AND id_usuario != ?";
                $params[] = $excluirId;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchColumn() ? true : false;

        } catch (PDOException $e) {
            error_log("Error al verificar correo: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       ✏️ ACTUALIZACIÓN
    ============================================================ */

    public function actualizarPerfil($id_usuario, $data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE usuarios 
                SET nombre = ?, telefono = ?
                WHERE id_usuario = ?
            ");
            return $stmt->execute([
                $data['nombre'],
                $data['telefono'] ?? null,
                $id_usuario
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar perfil: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarCorreo($id_usuario, $correo) {
        try {
            if ($this->existeCorreo($correo, $id_usuario)) {
                return false;
            }
            $stmt = $this->db->prepare("UPDATE usuarios SET correo = ? WHERE id_usuario = ?");
            return $stmt->execute([$correo, $id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al actualizar correo: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarContrasena($id_usuario, $contrasenaActual, $contrasenaNueva) {
        try {
            $stmt = $this->db->prepare("SELECT contrasena FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $hashActual = $stmt->fetchColumn();

            if (!$hashActual || !password_verify($contrasenaActual, $hashActual)) {
                return false;
            }

            $stmt = $this->db->prepare("UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?");
            return $stmt->execute([
                password_hash($contrasenaNueva, PASSWORD_DEFAULT),
                $id_usuario
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar contraseña: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar($id_usuario, $data) {
        try {
            $query = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ?, id_rol = ?";
            $params = [
                $data['nombre'],
                $data['correo'],
                $data['telefono'] ?? null,
                $data['id_rol']
            ];

            if (!empty($data['contrasena'])) {
                $query .= ", contrasena = ?";
                $params[] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            }

            $query .= " WHERE id_usuario = ?";
            $params[] = $id_usuario;

            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       🗑️ ELIMINACIÓN
    ============================================================ */

    public function eliminar($id_usuario) {
        try {
            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            return $stmt->execute([$id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function desactivar($id_usuario) {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET activo = 0 WHERE id_usuario = ?");
            return $stmt->execute([$id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al desactivar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function activar($id_usuario) {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET activo = 1 WHERE id_usuario = ?");
            return $stmt->execute([$id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al activar usuario: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       📊 ESTADÍSTICAS Y CONSULTAS
    ============================================================ */

    public function contarUsuarios($soloActivos = false) {
        try {
            $query = "SELECT COUNT(*) FROM usuarios";
            if ($soloActivos) {
                $query .= " WHERE activo = 1";
            }
            return (int) $this->db->query($query)->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar usuarios: " . $e->getMessage());
            return 0;
        }
    }

    public function contarPorRol($id_rol) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE id_rol = ?");
            $stmt->execute([$id_rol]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar usuarios por rol: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerUltimos($limite = 10) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, r.nombre as nombre_rol 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                ORDER BY u.fecha_registro DESC 
                LIMIT ?
            ");
            $stmt->execute([$limite]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener últimos usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function buscar($termino) {
        try {
            $termino = "%{$termino}%";
            $stmt = $this->db->prepare("
                SELECT u.*, r.nombre as nombre_rol 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.nombre LIKE ? OR u.correo LIKE ?
                ORDER BY u.nombre ASC
            ");
            $stmt->execute([$termino, $termino]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al buscar usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerActivos() {
        try {
            $query = "SELECT u.*, r.nombre as nombre_rol 
                      FROM usuarios u 
                      LEFT JOIN roles r ON u.id_rol = r.id_rol 
                      WHERE u.activo = 1
                      ORDER BY u.nombre ASC";
            return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios activos: " . $e->getMessage());
            return [];
        }
    }

    /* ============================================================
       🔒 ROLES Y PERMISOS
    ============================================================ */

    public function esAdmin($id_usuario) {
        try {
            $stmt = $this->db->prepare("SELECT id_rol FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            return $stmt->fetchColumn() == 1;
        } catch (PDOException $e) {
            error_log("Error al verificar admin: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerRol($id_usuario) {
        try {
            $stmt = $this->db->prepare("SELECT id_rol FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al obtener rol: " . $e->getMessage());
            return false;
        }
    }

    public function cambiarRol($id_usuario, $id_rol) {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET id_rol = ? WHERE id_usuario = ?");
            return $stmt->execute([$id_rol, $id_usuario]);
        } catch (PDOException $e) {
            error_log("Error al cambiar rol: " . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       📍 RELACIONES
    ============================================================ */

    public function obtenerDirecciones($id_usuario) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM direcciones 
                WHERE id_usuario = ? 
                ORDER BY id_direccion DESC
            ");
            $stmt->execute([$id_usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener direcciones: " . $e->getMessage());
            return [];
        }
    }

    public function contarPedidos($id_usuario) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM pedidos WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar pedidos: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerTotalGastado($id_usuario) {
        try {
            $stmt = $this->db->prepare("
                SELECT COALESCE(SUM(total), 0) 
                FROM pedidos 
                WHERE id_usuario = ? 
                AND id_estado IN (2, 3, 4)
            ");
            $stmt->execute([$id_usuario]);
            return (float) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al obtener total gastado: " . $e->getMessage());
            return 0.0;
        }
    }

    public function obtenerEstadisticas($id_usuario) {
        return [
            'total_pedidos' => $this->contarPedidos($id_usuario),
            'total_gastado' => $this->obtenerTotalGastado($id_usuario),
            'total_direcciones' => count($this->obtenerDirecciones($id_usuario))
        ];
    }
}
?>