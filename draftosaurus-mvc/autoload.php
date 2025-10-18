<?php

spl_autoload_register(function (string $class): void {
    $prefixes = [
        'App\\' => __DIR__ . '/app/',
        'Tests\\' => __DIR__ . '/tests/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $path = $baseDir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($path)) {
                require $path;
            }
        }
    }
});
