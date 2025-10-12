<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "DRAFTOSAURUS";

try {
	$authEmail = $_COOKIE['user'] ?? '';
	if (empty($authEmail)) {
		echo json_encode(['success' => false, 'message' => 'No autenticado']);
		exit();
	}

	$conn = new mysqli($servername, $username, $db_password, $dbname);
	if ($conn->connect_error) {
		throw new Exception('Conexión fallida: ' . $conn->connect_error);
	}

	// Asegurar que existan tablas
	$exists = $conn->query("SHOW TABLES LIKE 'GAME_RESULTS'");
	if (!$exists || $exists->num_rows === 0) {
		echo json_encode(['success' => true, 'results' => []]);
		exit();
	}

	$sql = "SELECT GR.id, GR.game_id, GR.total_points, GR.is_winner, G.created_at, G.modo, G.players_json
	        FROM GAME_RESULTS GR
	        JOIN GAMES G ON G.id = GR.game_id
	        WHERE GR.player_email = ? OR GR.user_id = (SELECT id FROM USERS WHERE email = ? LIMIT 1)
	        ORDER BY G.created_at DESC, GR.id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('ss', $authEmail, $authEmail);
	$stmt->execute();
	$res = $stmt->get_result();
	$rows = [];
	while ($row = $res->fetch_assoc()) {
		$rows[] = $row;
	}
	$stmt->close();

	// Construir opponents из GAMES.players_json
	foreach ($rows as &$r) {
		$opponents = [];
		$playersJson = $r['players_json'] ?? null;
		if (!empty($playersJson)) {
			$playersArr = json_decode($playersJson, true);
			if (is_array($playersArr)) {
				// Determinar текущего игрока по email или user_id
				$currentEmail = $authEmail;
				foreach ($playersArr as $p) {
					// соберём всех как соперников, отфильтруем себя ниже
					$opponents[] = [
						'opponent_user_id' => isset($p['id']) ? (int)$p['id'] : null,
						'opponent_name' => isset($p['name']) ? $p['name'] : '',
						'opponent_email' => isset($p['email']) ? $p['email'] : '',
						'opponent_points' => isset($p['total']) ? (int)$p['total'] : 0,
					];
				}
				// Удалить самого себя из соперников, если email совпадает
				$opponents = array_values(array_filter($opponents, function($o) use ($currentEmail) {
					return !isset($o['opponent_email']) || $o['opponent_email'] !== $currentEmail;
				}));
			}
		}
		$r['opponents'] = $opponents;
		unset($r['players_json']);
	}
	unset($r);

	$conn->close();

	echo json_encode(['success' => true, 'results' => $rows]);
} catch (Exception $e) {
	error_log('user_results.php: ' . $e->getMessage());
	echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


