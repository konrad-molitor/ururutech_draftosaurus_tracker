<?php

namespace App\Support;

class PHPSession implements SessionInterface
{
    private bool $started = false;

    public function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->started = true;
    }

    public function put(string $key, mixed $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    public function all(): array
    {
        $this->ensureStarted();
        return $_SESSION;
    }

    public function forget(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    public function invalidate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_unset();
            session_destroy();
        }
        $this->started = false;
    }

    private function ensureStarted(): void
    {
        if (!$this->started) {
            $this->start();
        }
    }
}
