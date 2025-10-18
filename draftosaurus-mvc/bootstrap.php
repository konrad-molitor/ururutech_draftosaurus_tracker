<?php

use App\Kernel;

$composerAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require $composerAutoload;
} else {
    require __DIR__ . '/autoload.php';
}

return new Kernel();
