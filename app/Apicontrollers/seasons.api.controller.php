<?php
require_once './app/Apimodels/seasons.model.php';
require_once './app/Apiviews/apiview.php';
require_once './app/Apimodels/chapters.model.php';
require_once './libs/auth.middleware.php';

class SeasonController {

    private $view;
    private $model;
    private $chaptersModel;
    private $data;

    function __construct() {
        $this->model = new SeasonModel();
        $this->view = new ApiView();
        $this->chaptersModel = new ChaptersModel();
        $this->data = file_get_contents("php://input");
    }

    function getData() {
        return json_decode($this->data);
    }

    // ✅ Público
    function listCategories($req) {
        $seasons = $this->model->listCategories($req);
        if ($seasons) {
            $this->view->response($seasons, 200);
        } else {
            $this->view->response(["message" => "No se encontraron las temporadas"], 404);
        }
    }

    // ✅ Público
    function listCategoriesById($req) {
        $season = $this->model->listCategoriesById($req);
        if ($season) {
            $this->view->response($season, 200);
        } else {
            $this->view->response(["message" => "Temporada no encontrada"], 404);
        }
    }

    // 🔐 Protegido
    function addSeason() {
        checkAuth(); // Verifica token antes de crear
        $data = $this->getData();
        if (isset($data->Nombre) && isset($data->Fecha_estreno) && isset($data->Productora) && isset($data->imagen)) {
            $newId = $this->model->addSeason($data);
            $this->view->response(["message" => "Temporada creada con éxito", "id" => $newId], 201);
        } else {
            $this->view->response(["message" => "Datos incompletos"], 400);
        }
    }

    // 🔐 Protegido
    function updateSeason($req) {
        checkAuth(); // Verifica token antes de modificar
        $id = $req->params->id;
        $season = $this->model->listCategoriesById($req);
        if (!$season) {
            return $this->view->response("La temporada con el id=$id no existe", 404);
        }

        $req->body = $this->getData(); // Pasa datos al modelo

        if ($this->model->updateSeason($req)) {
            $this->view->response(["message" => "Temporada actualizada con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o temporada no encontrada"], 400);
        }
    }

    // 🔐 Protegido
    function deleteSeason($req) {
        checkAuth(); // Verifica token antes de eliminar
        $this->deleteChaperSeason($req);
        if ($this->model->deleteSeason($req)) {
            $this->view->response(["message" => "Temporada eliminada con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o temporada no encontrada"], 400);
        }
    }

    // 🔐 Protegido
    function deleteChaperSeason($req) {
        checkAuth(); // Verifica token antes de eliminar capítulos
        if ($this->model->deleteChaperSeason($req)) {
            $this->view->response(["message" => "Capítulos eliminados con éxito"], 200);
        } else {
            $this->view->response(["message" => "Datos inválidos o capítulos no encontrados"], 400);
        }
    }
}
?>
