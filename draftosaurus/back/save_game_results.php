<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "DRAFTOSAURUS";

try {
    // Leer JSON del body
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    if (!$data || !isset($data['players']) || !is_array($data['players'])) {
        echo json_encode(['success' => false, 'message' => 'Formato inválido']);
        exit();
    }

    $modo = isset($data['modo']) ? trim($data['modo']) : 'verano';
    $players = $data['players'];

    $conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Conexión fallida: ' . $conn->connect_error);
    }

    // Insertar juego con snapshot de jugadores/puntos в JSON
    $playersSnapshot = [];
    foreach ($players as $pp) {
        $playersSnapshot[] = [
            'id' => isset($pp['id']) ? intval($pp['id']) : null,
            'name' => isset($pp['name']) ? $pp['name'] : '',
            'email' => isset($pp['email']) ? $pp['email'] : '',
            'total' => isset($pp['total']) ? intval($pp['total']) : 0,
            'winner' => !empty($pp['winner']) ? 1 : 0,
        ];
    }
    $playersJson = json_encode($playersSnapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $stmtGame = $conn->prepare('INSERT INTO GAMES (modo, players_json) VALUES (?, ?)');
    $stmtGame->bind_param('ss', $modo, $playersJson);
    if (!$stmtGame->execute()) {
        throw new Exception('No se pudo crear el juego: ' . $stmtGame->error);
    }
    $gameId = $stmtGame->insert_id;
    $stmtGame->close();

    // Preparar consultas
    $stmtFindUser = $conn->prepare('SELECT id FROM USERS WHERE email = ? LIMIT 1');
    $stmtInsertRes = $conn->prepare('INSERT INTO GAME_RESULTS (game_id, user_id, player_name, player_email, total_points, is_winner) VALUES (?, ?, ?, ?, ?, ?)');

    foreach ($players as $idx => $p) {
        $pname = isset($p['name']) ? $p['name'] : '';
        $pemail = isset($p['email']) ? $p['email'] : '';
        $ptotal = isset($p['total']) ? intval($p['total']) : 0;
        $pwinner = (!empty($p['winner'])) ? 1 : 0;

        $userId = null;
        if (!empty($pemail)) {
            $stmtFindUser->bind_param('s', $pemail);
            $stmtFindUser->execute();
            $res = $stmtFindUser->get_result();
            if ($row = $res->fetch_assoc()) {
                $userId = intval($row['id']);
            }
        }

        // Para null en bind_param usar tipo "i" pero pasando null como variable
        if ($userId === null) {
            $nullUser = null;
            $stmtInsertRes->bind_param('iissii', $gameId, $nullUser, $pname, $pemail, $ptotal, $pwinner);
        } else {
            $stmtInsertRes->bind_param('iissii', $gameId, $userId, $pname, $pemail, $ptotal, $pwinner);
        }
        if (!$stmtInsertRes->execute()) {
            throw new Exception('No se pudo guardar el resultado: ' . $stmtInsertRes->error);
        }
    }

    $stmtFindUser->close();
    $stmtInsertRes->close();
    // No stmtInsertOpp
    $conn->close();

    echo json_encode(['success' => true, 'game_id' => $gameId]);
} catch (Exception $e) {
    error_log('save_game_results.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


