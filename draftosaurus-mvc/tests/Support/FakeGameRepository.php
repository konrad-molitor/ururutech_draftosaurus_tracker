<?php

namespace Tests\Support;

use App\Repositories\GameRepositoryInterface;

class FakeGameRepository implements GameRepositoryInterface
{
    public array $saved = [];
    public array $games = [];
    public array $results = [];

    public function saveResults(string $mode, array $players): array
    {
        $id = count($this->saved) + 1;
        $this->saved[] = compact('mode', 'players');
        return ['success' => true, 'game_id' => $id];
    }

    public function listGames(): array
    {
        return $this->games;
    }

    public function deleteGame(int $id): bool
    {
        return true;
    }

    public function resultsForUser(string $email): array
    {
        return $this->results[$email] ?? [];
    }
}
