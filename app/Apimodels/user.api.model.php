<?php
require_once './database/config.php';

class UserModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un usuario por nombre de usuario (campo 'Usuario')
     * @param string $username
     * @return object|null
     */
    public function getUserByUsername($username) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE Usuario = ?");
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
?>
