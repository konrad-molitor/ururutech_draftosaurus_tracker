<?php

namespace App\Support;

use RuntimeException;

class View
{
    public static function render(string $view, array $data = []): string
    {
        if ($view === '') {
            throw new RuntimeException('View name is required.');
        }

        if (str_contains($view, '..')) {
            throw new RuntimeException('Invalid view path.');
        }

        $basePath = realpath(__DIR__ . '/../../public');
        if ($basePath === false) {
            throw new RuntimeException('Public directory not found.');
        }

        $view = ltrim($view, '/');
        $fullPath = $basePath . DIRECTORY_SEPARATOR . $view;
        if (!is_file($fullPath)) {
            throw new RuntimeException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $fullPath;
        return (string) ob_get_clean();
    }
}
