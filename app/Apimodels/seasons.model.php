<?php
require_once './database/config.php';

class SeasonModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->_deploy();
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
            CREATE TABLE IF NOT EXISTS temporadas (
                ID_temporada INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(255) NOT NULL,
                Fecha_estreno DATE NOT NULL,
                Productora TEXT,
                imagen TEXT
            );

            CREATE TABLE IF NOT EXISTS capitulos (
                ID_capitulos INT AUTO_INCREMENT PRIMARY KEY,
                Titulo VARCHAR(255) NOT NULL,
                Descripcion TEXT,
                ID_temporada_fk INT,
                FOREIGN KEY (ID_temporada_fk) REFERENCES temporadas(ID_temporada) ON DELETE CASCADE
            );
            END;

            $this->db->query($sql);
        }
    }

    // ✅ Nuevo método para getAll
    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM temporadas');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function listCategories($req) {
        $order_by = $req->query->order_by ?? null;
        $order = $req->query->order ?? null;
        $Nombre = $req->query->Nombre ?? null;
        $Productora = $req->query->Productora ?? null;

        $valid_fields = ['ID_temporada', 'Nombre', 'Fecha_estreno', 'Productora', 'imagen'];
        $querySQL = 'SELECT * FROM temporadas';
        $execute = [];

        if ($Nombre && $Productora) {
            $querySQL .= ' WHERE Nombre = ? AND Productora = ?';
            $execute = [$Nombre, $Productora];
        } elseif ($Nombre) {
            $querySQL .= ' WHERE Nombre = ?';
            $execute[] = $Nombre;
        } elseif ($Productora) {
            $querySQL .= ' WHERE Productora = ?';
            $execute[] = $Productora;
        }

        if ($order_by && in_array($order_by, $valid_fields)) {
            $querySQL .= " ORDER BY `$order_by`";
            $querySQL .= (strtoupper($order) === 'DESC') ? ' DESC' : ' ASC';
        }

        $query = $this->db->prepare($querySQL);
        $query->execute($execute);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function listCategoriesById($req) {
        $id = $req->params->id;
        $query = $this->db->prepare('SELECT * FROM temporadas WHERE ID_temporada = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addSeason($data) {
        $query = $this->db->prepare('INSERT INTO temporadas (Nombre, Fecha_estreno, Productora, imagen) VALUES (?, ?, ?, ?)');
        $query->execute([
            $data->Nombre,
            $data->Fecha_estreno,
            $data->Productora,
            $data->imagen
        ]);
        return $this->db->lastInsertId();
    }

    public function updateSeason($req) {
        $query = $this->db->prepare('UPDATE temporadas SET Nombre = ?, Fecha_estreno = ?, Productora = ?, imagen = ? WHERE ID_temporada = ?');
        return $query->execute([
            $req->body->Nombre,
            $req->body->Fecha_estreno,
            $req->body->Productora,
            $req->body->imagen,
            $req->params->id
        ]);
    }

    public function deleteSeason($req) {
        $id = $req->params->id;
        if ($id) {
            $query = $this->db->prepare('DELETE FROM temporadas WHERE ID_temporada = ?');
            return $query->execute([$id]);
        }
        return false;
    }

    public function deleteChaperSeason($req) {
        $id = $req->params->id;
        if ($id) {
            $query = $this->db->prepare('DELETE FROM capitulos WHERE ID_temporada_fk = ?');
            return $query->execute([$id]);
        }
        return false;
    }
}
?>