<?php
require_once './app/Apiviews/apiview.php';
require_once './app/Apimodels/chapters.model.php';
require_once './libs/request.php';
require_once './libs/auth.middleware.php';

class ChapterController {
    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new ChaptersModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    // ✅ Público
    public function getAll($orderBy = 'Titulo', $order = 'asc') {
        $allowedFields = ['Titulo', 'Descripcion', 'Personajes', 'ID_temporada_fk'];
        if (!in_array($orderBy, $allowedFields)) {
            $orderBy = 'Titulo';
        }

        $order = strtolower($order);
        if ($order !== 'asc' && $order !== 'desc') {
            $order = 'asc';
        }

        $chapters = $this->model->getAllChapters($orderBy, $order);
        if ($chapters) {
            $this->view->response($chapters, 200);
        } else {
            $this->view->response(["message" => "No se encontraron capítulos"], 404);
        }
    }

    // ✅ Público
    public function getById($req) {
        $chapter = $this->model->getChapterById($req);
        if ($chapter) {
            $this->view->response($chapter, 200);
        } else {
            $this->view->response(["message" => "Capítulo no encontrado"], 404);
        }
    }

    // 🔐 Protegido
    public function add() {
        checkAuth(); // Verifica token antes de crear
        $data = $this->getData();
        if (isset($data->Titulo) && isset($data->Descripcion) && isset($data->ID_temporada_fk)) {
            $newId = $this->model->addChapter($data);
            $this->view->response(["message" => "Capítulo creado con éxito", "id" => $newId], 201);
        } else {
            $this->view->response(["message" => "Datos incompletos"], 400);
        }
    }

    // 🔐 Protegido
    public function update($req) {
        checkAuth(); // Verifica token antes de modificar
        $id = $req->params->id;
        $chapter = $this->model->getChapterById($req);
        if (!$chapter) {
            return $this->view->response("El capítulo con el id=$id no existe", 404);
        }

        $req->body = $this->getData(); // Pasa datos al modelo

        if ($this->model->updateChapter($req)) {
            $this->view->response(["message" => "Capítulo actualizado con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capítulo no encontrado"], 400);
        }
    }

    // 🔐 Protegido
    public function delete($req) {
        checkAuth(); // Verifica token antes de eliminar
        if ($this->model->delete($req)) {
            $this->view->response(["message" => "Capítulo eliminado con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capítulo no encontrado"], 400);
        }
    }
}
?>
