<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager
{
    private string $algorithm;
    private string $secret;

    public function __construct(string $algorithm, string $secret)
    {
        $this->algorithm = $algorithm;
        $this->secret = $secret;
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    public function decode(string $token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, $this->algorithm));
        } catch (Exception $e) {
            http_response_code(401);
            exit;
        }

        return $decoded;
    }
}
