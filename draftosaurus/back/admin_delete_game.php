<?php

use App\Http\Request;

$kernel = require __DIR__ . '/../draftosaurus-mvc/bootstrap.php';

$request = Request::fromGlobals()->withPath('/back/admin_delete_game.php');
$response = $kernel->handle($request);
$response->send();
