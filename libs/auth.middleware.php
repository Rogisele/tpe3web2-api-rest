<?php
require_once './auth/jwt.php';

function checkAuth() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "Token faltante"]);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);
    $payload = validateJWT($token);

    if (!$payload) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit;
    }

    return $payload; // opcional: podés usarlo para saber quién está logueado
}
