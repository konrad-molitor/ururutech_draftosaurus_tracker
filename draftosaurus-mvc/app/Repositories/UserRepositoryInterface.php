<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?array;

    public function verifyPassword(array $user, string $password): bool;

    public function create(array $data): bool;

    public function update(array $data): bool;

    public function deleteByEmail(string $email): bool;

    public function listPlayers(): array;

    public function deleteById(int $id): bool;

    public function roleForEmail(string $email): ?string;

    public function findByIds(array $ids): array;
}
