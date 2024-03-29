<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

class Route
{

    private string $pattern;
    private string $method;
    /**
     * @var callable
     */
    private $controller;

    public function __construct(string $pattern, string $method, callable $controller)
    {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->controller = $controller;
    }

    public static function get(string $pattern, callable $controller): self
    {
        return new self($pattern, 'GET', $controller);
    }

    public static function post(string $pattern, callable $controller): self
    {
        return new self($pattern, 'POST', $controller);
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getController(): callable
    {
        return $this->controller;
    }
}