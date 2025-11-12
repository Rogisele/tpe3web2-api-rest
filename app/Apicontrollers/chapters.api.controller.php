<?php

require_once './app/views/Apiview.php';
require_once './app/Apimodels/chapters.model.php';
require_once './app/Apimodels/seasons.model.php';

class ChapterController {
   private $view;
    private $model;
    private $seasonsModel;
    private $data;

    public function __construct() {
        $this->model = new ChaptersModel();
        $this->view = new ApiView();
        $this->seasonsModel = new SeasonModel();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    // ✅ Público
     public function getAll($req) {
        
        $orderBy = false;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $chapters = $this->model->getAllChapters($orderBy);
        
        // mando las tareas a la vista
        return $this->view->response($chapters);
    }

    
    public function getById($req) {
        $chapter = $this->model->getChapterById($req);
        if ($chapter) {
            $this->view->response($chapter, 200);
        } else {
            $this->view->response(["message" => "Capítulo no encontrado"], 404);
        }
    }

    
    public function add() {
        $data = $this->getData();
        if (isset($data->Titulo) && isset($data->Descripcion) && isset($data->Personajes) && isset($data->ID_temporada_fk)) {
            $newId = $this->model->addChapter($data);
            $this->view->response(["message" => "Capítulo creado con éxito", "id" => $newId], 201);
        } else {
            $this->view->response(["message" => "Datos incompletos"], 400);
        }
    }

    
    public function update($req) {
        
        $id = $req->params->id;
        $chapter = $this->model->getChapterById($req);
        if (!$chapter) {
            return $this->view->response("El capítulo con el id=$id no existe", 404);
        }

        $data = $this->getData();
         if (!$data) {
        return $this->view->response(["message" => "No se recibió cuerpo JSON válido"], 400);

        if (!isset($data->Titulo) || !isset($data->Descripcion) || !isset($data->Personajes)) {
        return $this->view->response(["message" => "Faltan campos obligatorios"], 400);
        }
        }
        $req->body = $data;
        if ($this->model->updateChapter($req)) {
            $this->view->response(["message" => "Capítulo actualizado con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capítulo no encontrado"], 400);
        }
    }

}