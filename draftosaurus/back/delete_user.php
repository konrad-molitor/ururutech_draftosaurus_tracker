<?php

use App\Http\Request;

$kernel = require __DIR__ . '/../draftosaurus-mvc/bootstrap.php';

$request = Request::fromGlobals()->withPath('/back/delete_user.php');
$response = $kernel->handle($request);
$response->send();
