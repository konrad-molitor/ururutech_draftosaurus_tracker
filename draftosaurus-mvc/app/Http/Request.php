<?php

namespace App\Http;

class Request
{
    public function __construct(
        private string $method,
        private string $path,
        private array $query = [],
        private array $input = [],
        private array $cookies = [],
        private array $headers = [],
        private ?string $rawBody = null
    ) {
        $this->method = strtoupper($method);
    }

    public static function fromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $query = $_GET ?? [];
        $input = $_POST ?? [];
        $cookies = $_COOKIE ?? [];
        $headers = function_exists('getallheaders') ? (getallheaders() ?: []) : [];
        $rawBody = file_get_contents('php://input');

        return new self($method, $path, $query, $input, $cookies, $headers, $rawBody ?: null);
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function withPath(string $path): self
    {
        $clone = clone $this;
        $clone->path = $path;
        return $clone;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function input(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->input;
        }

        return $this->input[$key] ?? $default;
    }

    public function json(): array
    {
        if ($this->rawBody === null || $this->rawBody === '') {
            return [];
        }

        $decoded = json_decode($this->rawBody, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function cookie(string $key, mixed $default = null): mixed
    {
        return $this->cookies[$key] ?? $default;
    }

    public function header(string $key, mixed $default = null): mixed
    {
        $normalized = array_change_key_case($this->headers, CASE_LOWER);
        $key = strtolower($key);
        return $normalized[$key] ?? $default;
    }

    public function expectsJson(): bool
    {
        $accept = $this->header('Accept');
        if (is_string($accept) && str_contains($accept, 'application/json')) {
            return true;
        }

        $requestedWith = $this->header('X-Requested-With');
        return is_string($requestedWith) && strtolower($requestedWith) === 'xmlhttprequest';
    }
}
