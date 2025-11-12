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
            Descripcion TEXT,
            ID_temporada_fk INT,
            FOREIGN KEY (ID_temporada_fk) REFERENCES temporadas(ID_temporada) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS temporadas (
                ID_temporada INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(255) NOT NULL,
                Fecha_estreno DATE NOT NULL,
                Productora TEXT,
                imagen TEXT
            );
        END;

        $this->db->query($sql);
    }
}


    // Obtiene todos los capitulos, con opción de ordenar por cualquier campo

        public function getAllChapters($orderBy = false) {
        $sql = 'SELECT * FROM capitulos';

        if($orderBy) {
            switch($orderBy) {
                case 'titulo':
                    $sql .= ' ORDER BY Titulo DESC';
                    break;
                case 'descripcion':
                    $sql .= ' ORDER BY Descripcion DESC';
                    break;
                case 'personajes':
                    $sql .= ' ORDER BY Personajes DESC';
                    break;
            }
        }

        //  Ejecuto la consulta
        $query = $this->db->prepare($sql);
        $query->execute();
    
        //  Obtengo los datos en un arreglo de objetos
        $chapters = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $chapters;
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
        $query = $this->db->prepare("INSERT INTO capitulos(Titulo, Descripcion, Personajes, ID_temporada_fk) VALUES(?,?,?,?)");
        $query->execute([
            $data->Titulo,
            $data->Descripcion,
            $data->Personajes,
            $data->ID_temporada_fk,            
        ]);
        return $this->db->lastInsertId();
    }

    // Actualiza un capitulo específico por ID
    public function updateChapter($req) {
        
        $query = $this->db->prepare('UPDATE capitulos SET Titulo = ?, Descripcion = ?,Personajes = ?, ID_temporada_fk = ? WHERE ID_capitulos = ?');
        $result = $query->execute([
            $req->body->Titulo,
            $req->body->Descripcion,
            $req->body->Descripcion,
            $req->body->ID_temporada_fk,
            $req->params->id
        ]);
        return $result;
    }

    
}
?>