<?php
require_once './database/config.php';

// hacer crud
class SeasonModel{
    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->_deploy();
}

    private function _deploy(){
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
            Descripción TEXT,
            ID_temporada_fk INT,
            FOREIGN KEY (ID_temporada_fk) REFERENCES temporadas(ID_temporada) ON DELETE CASCADE
        );
        END;

        $this->db->query($sql);
    }
}

    function listCategories($req){
    $order_by = isset($req->query->order_by) ? $req->query->order_by : NULL;
    $order = isset($req->query->order) ? $req->query->order : NULL;
    $Nombre = isset($req->query->Nombre) ? $req->query->Nombre : NULL;
    $Productora = isset($req->query->Productora) ? $req->query->Productora : NULL;

    // Campos válidos para ordenamiento
    $valid_fields = ['ID_temporada', 'Nombre', 'Fecha_estreno', 'Productora', 'imagen'];

    // Construcción base de la query
    $querySQL = 'SELECT * FROM `temporadas`';
    $execute = array();

    // Filtros opcionales
    if (isset($Nombre) && isset($Productora)) {
        $querySQL .= ' WHERE `Nombre` = ? AND `Productora` = ?';
        array_push($execute, $Nombre, $Productora);
    } else {
        if (isset($Nombre)) {
            $querySQL .= ' WHERE `Nombre` = ?';
            array_push($execute, $Nombre);
        }
        if (isset($Productora)) {
            // Si ya hay un WHERE, usamos AND
            $querySQL .= isset($Nombre) ? ' AND `Productora` = ?' : ' WHERE `Productora` = ?';
            array_push($execute, $Productora);
        }
    }

    // Ordenamiento opcional por cualquier campo válido
    if (isset($order_by) && in_array($order_by, $valid_fields)) {
        $querySQL .= " ORDER BY `$order_by`";
        $querySQL .= (isset($order) && strtoupper($order) === 'DESC') ? ' DESC' : ' ASC';
    }

    $querySQL .= ';';

    // Ejecutamos la consulta
    $query = $this->db->prepare($querySQL);
    $query->execute($execute);

    // Retornamos los resultados
    $seasons = $query->fetchAll(PDO::FETCH_OBJ);
    return $seasons;
}


    function listCategoriesById($req) {
        $id = $req->params->id;        

        //Enviamos la consulta y obtenemos el resultado
        $query = $this->db->prepare( 'SELECT * FROM temporadas WHERE ID_temporada=?'); 
        $query->execute([$id]);

        //Obtengo todos los datos de la consulta
        $seasons = $query->fetch(PDO::FETCH_OBJ);

        return $seasons;

}

    function addSeason($data){
        
        $query = $this->db->prepare('INSERT INTO temporadas (Nombre, Fecha_estreno, Productora, imagen) VALUES (?,?,?,?)');
        
        $query->execute([
            $data->Nombre,
            $data->Fecha_estreno,
            $data->Productora,
            $data->imagen
        ]);    

        return $this->db->lastInsertId();
}
    function updateSeason($req){        

        $query = $this->db->prepare('UPDATE temporadas 
            SET Nombre = ?, Fecha_estreno = ?, Productora = ?, imagen = ? WHERE ID_temporada = ?');
        
        $result = $query->execute([
            $req->body->Nombre,
            $req->body->Fecha_estreno,
            $req->body->Productora,
            $req->body->imagen,
            $req->params->id
        ]);
        return $result;

}

    function deleteSeason($req) {
        $id = $req->params->id;

        $query=$this->db->prepare('DELETE FROM temporadas WHERE ID_temporada = ? ');
        $query->execute([$id]);
            
}

    function deleteChaperSeason($req) {
        $id = $req->params->id;
        
        $query=$this->db->prepare('DELETE FROM capitulos WHERE ID_temporada_fk = ? ');
        $query->execute([$id]);

    }
}
?>