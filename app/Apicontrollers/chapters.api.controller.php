
<?php
require_once './app/Apiviews/apiview.php';
require_once './app/Apimodels/chapters.model.php';
require_once './libs/request.php';
class PerroController {
    private $model;
    private $view;
    private $data;
    
    public function __construct() {
        $this->model = new ChaptersModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    function getData(){
        return json_decode($this->data);
    }

    public function getAll($orderBy = 'Titulo', $order = 'asc') {
    // Validar el campo de ordenación
    $allowedFields = ['Titulo', 'Descripcion', 'Personajes', 'ID_temporada_fk '];
    if (!in_array($orderBy, $allowedFields)) {
        $orderBy = 'Titulo'; // Campo por defecto
    }

    // Validar la dirección de orden
    if (!is_string($order)) {
        $order = 'asc';
    } else {
        $order = strtolower($order);
        if ($order !== 'asc' && $order !== 'desc') {
            $order = 'asc';
        }
    }

    // Obtener los capitulos ordenados
    $chapters = $this->model->getAllChapters($orderBy, $order);
    if ($chapters) {
        $this->view->response($chapters, 200);
    } else {
        $this->view->response(["message" => "No se encontraron capitulos"], 404);
    }
}

    
    /**
     * GET /capitulos/{id} - Obtiene un capitulo específico por ID.
     * @param int $id ID del capitulo.
     */
    public function getById($req) {
        $chapter = $this->model->getChapterById($req);
        if ($chapter) {
            $this->view->response($chapter, 200);
        } else {
            $this->view->response(["message" => "Capitulo no encontrado"], 404);
        }
    }

    /**
     * POST /capitulos - Agrega un nuevo capitulo.
     */
    public function add() {
        $data = $this->getData();
       if (isset($data->Titulo) && isset($data->Descripcion)) {
            $newId = $this->model->addChapter($data);
            $this->view->response(["message" => "Capitulo creado con éxito", "id" => $newId], 201);
        } else {
            $this->view->response(["message" => "Datos incompletos"], 400);
        }
    }

    /**
     * PUT /capitulos/{id} - Actualiza un capitulo específico por ID.
     * @param int $id ID del capitulo.
     */
    public function update($req) {
        $id = $req->params->id;
        // verifico que exista el perro
        $chapter = $this->model->getChapterById($req);
        if (!$chapter) {
            return $this->view->response("El capitulo con el id=$id no existe", 404);
        }

        if ($this->model->updateChapter($req)) {
            $this->view->response(["message" => "Capitulo actualizado con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capitulo no encontrado"], 400);
        }
    }

    function delete($req){
        
        if ($this->model->delete($req)) {
            $this->view->response(["message" => "Capitulo eliminado con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capitulo no encontrado"], 400);
        }
    }
}
?>