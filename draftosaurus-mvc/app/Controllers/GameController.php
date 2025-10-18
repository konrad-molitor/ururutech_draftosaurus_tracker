<?php

namespace App\Controllers;

use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\Response;
use App\Repositories\GameRepositoryInterface;
use Throwable;

class GameController
{
    public function __construct(private GameRepositoryInterface $games)
    {
    }

    public function store(Request $request): Response
    {
        if (strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $payload = $request->json();
        if (empty($payload)) {
            $payload = $request->input();
        }
        $players = $payload['players'] ?? [];
        if (!is_array($players) || empty($players)) {
            return new JsonResponse(['success' => false, 'message' => 'Formato inválido'], 422);
        }

        $mode = isset($payload['modo']) ? (string) $payload['modo'] : 'verano';

        try {
            $result = $this->games->saveResults($mode, $players);
            return new JsonResponse($result);
        } catch (Throwable $e) {
            error_log('GameController@store: ' . $e->getMessage());
            return new JsonResponse(['success' => false, 'message' => 'Error del servidor'], 500);
        }
    }
}
