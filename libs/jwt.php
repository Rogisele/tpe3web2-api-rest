<?php
// Clave secreta para firmar el token (ideal: usar variable de entorno)
define('JWT_SECRET', 'mi1secreto');

// Codifica en Base64URL
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// Decodifica Base64URL
function base64url_decode($data) {
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $data .= str_repeat('=', 4 - $remainder);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}

// Crea un JWT válido
function createJWT($payload) {
    $header = base64url_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payload = base64url_encode(json_encode($payload));
    $signature = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    return "$header.$payload.$signature";
}

// Valida un JWT y devuelve el payload si es válido
function validateJWT($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) return null;

    [$header, $payload, $signature] = $parts;

    $valid_signature = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    if (!hash_equals($valid_signature, $signature)) return null;

    $decoded_payload = json_decode(base64url_decode($payload));
    if (!isset($decoded_payload->exp) || !is_numeric($decoded_payload->exp) || $decoded_payload->exp < time()) {
        return null;
    }

    return $decoded_payload;
}
?>
