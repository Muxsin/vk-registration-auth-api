<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes;

    /**
     * @param Route[] $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route->getPattern() === $uri && $route->getMethod() === $method) {
                call_user_func($route->getController());

                return;
            }
        }

        http_response_code(404);

        echo json_encode(['error' => 'The requested resource was not found.']);
    }
}