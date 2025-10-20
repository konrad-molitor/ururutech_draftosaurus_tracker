<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Http\ViewResponse;
use App\Repositories\UserRepositoryInterface;
use App\Support\SessionInterface;

class PageController
{
    public function __construct(
        private UserRepositoryInterface $users,
        private SessionInterface $session
    ) {
        $this->session->start();
    }

    public function home(Request $request): Response
    {
        return $this->renderHome('home');
    }

    public function rules(Request $request): Response
    {
        return $this->renderHome('rules');
    }

    public function account(Request $request): Response
    {
        return $this->renderHome('account');
    }

    public function tracking(Request $request): Response
    {
        return $this->renderHome('tracking');
    }

    public function play(Request $request): Response
    {
        return $this->renderHome('play');
    }

    public function confirmation(Request $request): Response
    {
        return ViewResponse::make('front/confirmacion.php');
    }

    public function rejection(Request $request): Response
    {
        return ViewResponse::make('front/rechazo.php', [], 400);
    }

    public function game(Request $request): Response
    {
        $idsParam = (string) $request->query('jugadores', '');
        $uniqueIds = [];
        foreach (explode(',', $idsParam) as $rawId) {
            $rawId = trim($rawId);
            if ($rawId === '' || !ctype_digit($rawId)) {
                continue;
            }
            $id = (int) $rawId;
            if ($id > 0) {
                $uniqueIds[$id] = $id;
            }
        }
        $ids = array_values($uniqueIds);

        $players = [];
        if ($ids !== []) {
            $players = $this->users->findByIds($ids);
            $index = array_flip($ids);
            usort($players, function (array $a, array $b) use ($index): int {
                $aIndex = $index[$a['id'] ?? 0] ?? PHP_INT_MAX;
                $bIndex = $index[$b['id'] ?? 0] ?? PHP_INT_MAX;
                return $aIndex <=> $bIndex;
            });
        }

        $mode = strtolower((string) $request->query('modo', 'verano')) === 'invierno'
            ? 'invierno'
            : 'verano';

        return ViewResponse::make('front/game.php', [
            'players' => $players,
            'mode' => $mode,
        ]);
    }

    private function renderHome(string $initialScreen): Response
    {
        $sessionUser = $this->session->get('user');

        return ViewResponse::make('front/index.php', [
            'sessionUser' => $sessionUser,
            'initialScreen' => $initialScreen,
        ]);
    }
}
