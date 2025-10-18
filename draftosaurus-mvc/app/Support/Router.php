<?php

namespace App\Support;

use App\Http\Request;
use App\Http\Response;
use RuntimeException;

class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    public function map(string $method, string $path, callable $handler): void
    {
        $method = strtoupper($method);
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->method();
        $path = $request->path();

        $handler = $this->routes[$method][$path] ?? null;
        if ($handler === null) {
            return new Response('Not Found', 404);
        }

        $response = $handler($request);
        if (!$response instanceof Response) {
            throw new RuntimeException('Route handler must return a Response instance.');
        }

        return $response;
    }
}
