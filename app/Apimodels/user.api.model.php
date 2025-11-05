<?php
require_once './app/Apiviews/apiview.php';
require_once './app/Apimodels/user.api.model.php';
require_once './auth/jwt.php';

class UserApiController {
    private $model;
    private $view;
    private $data;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function login() {
        $data = $this->getData();

        if (!isset($data->usuario) || !isset($data->contraseña)) {
            return $this->view->response(["error" => "Faltan datos"], 400);
        }

        $user = $this->model->getUserByUsername($data->usuario);

        if ($user && password_verify($data->contraseña, $user->contraseña)) {
            $payload = [
                "id" => $user->id,
                "usuario" => $user->Usuario,
                "exp" => time() + 3600 // Token válido por 1 hora
            ];
            $token = createJWT($payload);
            return $this->view->response(["token" => $token], 200);
        } else {
            return $this->view->response(["error" => "Credenciales inválidas"], 401);
        }
    }
}
?>
