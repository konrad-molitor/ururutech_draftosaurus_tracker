<?php

namespace App\Support;

interface SessionInterface
{
    public function start(): void;

    public function put(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

    public function all(): array;

    public function forget(string $key): void;

    public function invalidate(): void;
}
