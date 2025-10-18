<?php

namespace App\Repositories;

use App\Support\DatabaseConnection;
use mysqli;
use RuntimeException;

class MysqlGameRepository implements GameRepositoryInterface
{
    private function connection(): mysqli
    {
        return DatabaseConnection::make();
    }

    public function saveResults(string $mode, array $players): array
    {
        $conn = $this->connection();
        $playersSnapshot = [];
        foreach ($players as $player) {
            $playersSnapshot[] = [
                'id' => isset($player['id']) ? (int) $player['id'] : null,
                'name' => $player['name'] ?? '',
                'email' => $player['email'] ?? '',
                'total' => isset($player['total']) ? (int) $player['total'] : 0,
                'winner' => !empty($player['winner']) ? 1 : 0,
            ];
        }

        $playersJson = json_encode($playersSnapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $stmtGame = $conn->prepare('INSERT INTO GAMES (modo, players_json) VALUES (?, ?)');
        $stmtGame->bind_param('ss', $mode, $playersJson);
        if (!$stmtGame->execute()) {
            $error = $stmtGame->error;
            $stmtGame->close();
            $conn->close();
            throw new RuntimeException('Failed to create game: ' . $error);
        }
        $gameId = $stmtGame->insert_id;
        $stmtGame->close();

        $stmtFindUser = $conn->prepare('SELECT id FROM USERS WHERE email = ? LIMIT 1');
        $stmtInsertRes = $conn->prepare('INSERT INTO GAME_RESULTS (game_id, user_id, player_name, player_email, total_points, is_winner) VALUES (?, ?, ?, ?, ?, ?)');

        foreach ($players as $player) {
            $pname = $player['name'] ?? '';
            $pemail = $player['email'] ?? '';
            $ptotal = isset($player['total']) ? (int) $player['total'] : 0;
            $pwinner = !empty($player['winner']) ? 1 : 0;

            $userId = null;
            if (!empty($pemail)) {
                $stmtFindUser->bind_param('s', $pemail);
                $stmtFindUser->execute();
                $result = $stmtFindUser->get_result();
                if ($row = $result->fetch_assoc()) {
                    $userId = (int) $row['id'];
                }
            }

            if ($userId === null) {
                $null = null;
                $stmtInsertRes->bind_param('iissii', $gameId, $null, $pname, $pemail, $ptotal, $pwinner);
            } else {
                $stmtInsertRes->bind_param('iissii', $gameId, $userId, $pname, $pemail, $ptotal, $pwinner);
            }

            if (!$stmtInsertRes->execute()) {
                $error = $stmtInsertRes->error;
                $stmtFindUser->close();
                $stmtInsertRes->close();
                $conn->close();
                throw new RuntimeException('Failed to save result: ' . $error);
            }
        }

        $stmtFindUser->close();
        $stmtInsertRes->close();
        $conn->close();

        return ['success' => true, 'game_id' => $gameId];
    }

    public function listGames(): array
    {
        $conn = $this->connection();
        $exists = $conn->query("SHOW TABLES LIKE 'PARTIDAS'");
        $games = [];
        if ($exists && $exists->num_rows > 0) {
            $res = $conn->query('SELECT id FROM PARTIDAS ORDER BY id DESC');
            while ($row = $res->fetch_assoc()) {
                $games[] = $row;
            }
        }
        $conn->close();
        return $games;
    }

    public function deleteGame(int $id): bool
    {
        $conn = $this->connection();
        $exists = $conn->query("SHOW TABLES LIKE 'PARTIDAS'");
        if (!$exists || $exists->num_rows === 0) {
            $conn->close();
            return false;
        }
        $stmt = $conn->prepare('DELETE FROM PARTIDAS WHERE id = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $ok;
    }

    public function resultsForUser(string $email): array
    {
        $conn = $this->connection();
        $exists = $conn->query("SHOW TABLES LIKE 'GAME_RESULTS'");
        if (!$exists || $exists->num_rows === 0) {
            $conn->close();
            return [];
        }

        $sql = "SELECT GR.id, GR.game_id, GR.total_points, GR.is_winner, G.created_at, G.modo, G.players_json
                FROM GAME_RESULTS GR
                JOIN GAMES G ON G.id = GR.game_id
                WHERE GR.player_email = ? OR GR.user_id = (SELECT id FROM USERS WHERE email = ? LIMIT 1)
                ORDER BY G.created_at DESC, GR.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $playersJson = $row['players_json'] ?? null;
            $opponents = [];
            if (!empty($playersJson)) {
                $playersArr = json_decode($playersJson, true);
                if (is_array($playersArr)) {
                    foreach ($playersArr as $player) {
                        $opponents[] = [
                            'opponent_user_id' => isset($player['id']) ? (int) $player['id'] : null,
                            'opponent_name' => $player['name'] ?? '',
                            'opponent_email' => $player['email'] ?? '',
                            'opponent_points' => isset($player['total']) ? (int) $player['total'] : 0,
                        ];
                    }
                    $opponents = array_values(array_filter($opponents, function ($opponent) use ($email) {
                        return ($opponent['opponent_email'] ?? '') !== $email;
                    }));
                }
            }
            unset($row['players_json']);
            $row['opponents'] = $opponents;
            $rows[] = $row;
        }
        $stmt->close();
        $conn->close();
        return $rows;
    }
}
