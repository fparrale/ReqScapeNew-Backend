<?php
require_once 'services/JWTService.php';

class AuthMiddleware
{
    public static function validateToken()
    {
        $headers = getallheaders();

        $authHeader = $headers['Authorization'] ?? $_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'];

        if (!isset($authHeader)) {
            http_response_code(401);
            echo json_encode(['message' => 'Token no proporcionado']);
            exit();
        }

        list(, $token) = explode(' ', $authHeader);

        $payload = JWTService::verifyJWT($token);

        if (!$payload) {
            http_response_code(401);
            echo json_encode(['message' => 'Token inválido o expirado']);
            exit();
        }

        return $payload;
    }
}
