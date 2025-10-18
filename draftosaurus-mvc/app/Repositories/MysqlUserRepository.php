<?php

namespace App\Repositories;

use App\Support\DatabaseConnection;
use mysqli;
use RuntimeException;

class MysqlUserRepository implements UserRepositoryInterface
{
    private function connection(): mysqli
    {
        return DatabaseConnection::make();
    }

    public function findByEmail(string $email): ?array
    {
        $conn = $this->connection();
        $stmt = $conn->prepare('SELECT id, name, birthday, email, password, role FROM USERS WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc() ?: null;
        $stmt->close();
        $conn->close();
        return $user;
    }

    public function verifyPassword(array $user, string $password): bool
    {
        $hash = $user['password'] ?? '';
        return is_string($hash) && password_verify($password, $hash);
    }

    public function create(array $data): bool
    {
        $conn = $this->connection();
        $role = $data['role'] ?? 'player';
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO USERS (name, birthday, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $name = $data['name'] ?? '';
        $birthday = $data['birthday'] ?? '';
        $email = $data['email'] ?? '';
        $stmt->bind_param('sssss', $name, $birthday, $email, $hashed, $role);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }

    public function update(array $data): bool
    {
        $conn = $this->connection();
        if (isset($data['id'])) {
            $id = (int) $data['id'];
            $name = $data['name'] ?? '';
            $birthday = $data['birthday'] ?? '';
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if ($password !== '') {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('UPDATE USERS SET name = ?, birthday = ?, email = ?, password = ? WHERE id = ?');
                $stmt->bind_param('ssssi', $name, $birthday, $email, $hashed, $id);
            } else {
                $stmt = $conn->prepare('UPDATE USERS SET name = ?, birthday = ?, email = ? WHERE id = ?');
                $stmt->bind_param('sssi', $name, $birthday, $email, $id);
            }
        } elseif (isset($data['email'])) {
            $email = $data['email'];
            $name = $data['name'] ?? '';
            $stmt = $conn->prepare('UPDATE USERS SET name = ? WHERE email = ?');
            $stmt->bind_param('ss', $name, $email);
        } else {
            throw new RuntimeException('Missing identifier for update');
        }

        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }

    public function deleteByEmail(string $email): bool
    {
        $conn = $this->connection();
        $stmt = $conn->prepare('DELETE FROM USERS WHERE email = ?');
        $stmt->bind_param('s', $email);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }

    public function listPlayers(): array
    {
        $conn = $this->connection();
        $role = 'player';
        $stmt = $conn->prepare('SELECT id, name, birthday, email FROM USERS WHERE role = ? ORDER BY id ASC');
        $stmt->bind_param('s', $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        $conn->close();
        return $users;
    }

    public function deleteById(int $id): bool
    {
        $conn = $this->connection();
        $stmt = $conn->prepare('DELETE FROM USERS WHERE id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }

    public function roleForEmail(string $email): ?string
    {
        $conn = $this->connection();
        $stmt = $conn->prepare('SELECT role FROM USERS WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $row ? ($row['role'] ?? null) : null;
    }
}
