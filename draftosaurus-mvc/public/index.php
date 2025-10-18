<?php

use App\Http\Request;

$kernel = require __DIR__ . '/../bootstrap.php';

$request = Request::fromGlobals();
$response = $kernel->handle($request);
$response->send();
