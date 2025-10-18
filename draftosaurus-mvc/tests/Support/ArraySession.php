<?php

namespace Tests\Support;

use App\Support\SessionInterface;

class ArraySession implements SessionInterface
{
    private array $store = [];

    public function start(): void
    {
        // No-op for array backed session.
    }

    public function put(string $key, mixed $value): void
    {
        $this->store[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->store[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->store;
    }

    public function forget(string $key): void
    {
        unset($this->store[$key]);
    }

    public function invalidate(): void
    {
        $this->store = [];
    }
}
