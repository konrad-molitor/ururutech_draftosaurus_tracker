<?php

namespace App\Repositories;

interface GameRepositoryInterface
{
    public function saveResults(string $mode, array $players): array;

    public function listGames(): array;

    public function deleteGame(int $id): bool;

    public function resultsForUser(string $email): array;
}
