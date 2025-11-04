<?php
require_once './database/config.php';

class ChaptersModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->_deploy();
    }

    private function _deploy() {
        // Verifica si existen tablas, y si no, las crea
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
            CREATE TABLE IF NOT EXISTS capitulos (
            ID_capitulos INT AUTO_INCREMENT PRIMARY KEY,
            Titulo VARCHAR(255) NOT NULL,
            Descripción TEXT,
            ID_temporada_fk INT,
            FOREIGN KEY (ID_temporada_fk) REFERENCES temporadas(ID_temporada) ON DELETE CASCADE
        );
        END;

        $this->db->query($sql);
    }
}


    // Obtiene todos los capitulos, con opción de ordenar por cualquier campo

        public function getAllChapters($orderBy, $order) {
            $query = $this->db->prepare("SELECT * FROM capitulos ORDER BY $orderBy $order");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
    
    // Obtiene un capitulos específico por ID
    public function getChapterById($req) {
        $id = $req->params->id;
        $query = $this->db->prepare('SELECT * FROM capitulos WHERE ID_capitulos = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Agrega un nuevo capitulo
    public function addChapter($data) {
        $query = $this->db->prepare("INSERT INTO capitulos(Titulo, Descripcion,ID_temporada_fk) VALUES(?,?,?)");
        $query->execute([
            $data->Titulo,
            $data->Descripcion,
            $data->ID_temporada_fk,            
        ]);
        return $this->db->lastInsertId();
    }

    // Actualiza un capitulo específico por ID
    public function updateChapter($req) {
        
        $query = $this->db->prepare('UPDATE capitulos SET Titulo = ?, Descripcion = ?, ID_temporada_fk = ? WHERE ID_capitulos = ?');
        $result = $query->execute([
            $req->body->Titulo,
            $req->body->Descripcion,
            $req->body->ID_temporada_fk,
            $req->params->id
        ]);
        return $result;
    }

    // Elimina un capitulo por ID
    public function delete($req) {
        $id = $req->params->id;
        $query = $this->db->prepare('DELETE FROM capitulos WHERE ID_capitulos = ?');
        return $query->execute([$id]);
    }
}
?>