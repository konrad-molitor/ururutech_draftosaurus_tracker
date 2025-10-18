<?php

use App\Http\Request;

$kernel = require __DIR__ . '/../draftosaurus-mvc/bootstrap.php';

$request = Request::fromGlobals()->withPath('/back/check_user.php');
$response = $kernel->handle($request);
$response->send();
