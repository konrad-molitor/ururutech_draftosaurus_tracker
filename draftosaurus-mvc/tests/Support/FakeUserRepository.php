<?php

namespace Tests\Support;

use App\Repositories\UserRepositoryInterface;

class FakeUserRepository implements UserRepositoryInterface
{
    public array $users = [];

    public function findByEmail(string $email): ?array
    {
        return $this->users[strtolower($email)] ?? null;
    }

    public function verifyPassword(array $user, string $password): bool
    {
        return isset($user['password']) && password_verify($password, $user['password']);
    }

    public function create(array $data): bool
    {
        $email = strtolower($data['email']);
        if (isset($this->users[$email])) {
            return false;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->users[$email] = $data;
        return true;
    }

    public function update(array $data): bool
    {
        if (isset($data['id'])) {
            foreach ($this->users as $email => $user) {
                if (($user['id'] ?? null) === $data['id']) {
                    $this->users[$email] = array_merge($user, $data);
                    return true;
                }
            }
            return false;
        }

        if (isset($data['email'])) {
            $email = strtolower($data['email']);
            if (!isset($this->users[$email])) {
                return false;
            }
            $this->users[$email] = array_merge($this->users[$email], $data);
            return true;
        }

        return false;
    }

    public function deleteByEmail(string $email): bool
    {
        $email = strtolower($email);
        if (!isset($this->users[$email])) {
            return false;
        }
        unset($this->users[$email]);
        return true;
    }

    public function listPlayers(): array
    {
        return array_values(array_filter($this->users, fn ($user) => ($user['role'] ?? 'player') === 'player'));
    }

    public function deleteById(int $id): bool
    {
        foreach ($this->users as $email => $user) {
            if (($user['id'] ?? null) === $id) {
                unset($this->users[$email]);
                return true;
            }
        }
        return false;
    }

    public function roleForEmail(string $email): ?string
    {
        $user = $this->findByEmail($email);
        return $user['role'] ?? null;
    }
}
