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

    // Verificar rol admin
    $checkSql = 'SELECT role FROM USERS WHERE email = ?';
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('s', $authEmail);
    $checkStmt->execute();
    $roleRes = $checkStmt->get_result();
    $roleRow = $roleRes->fetch_assoc();
    $role = $roleRow ? ($roleRow['role'] ?? 'player') : 'player';
    if ($role !== 'admin') {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        exit();
    }

    // Listar partidas si existe la tabla PARTIDAS
    $exists = $conn->query("SHOW TABLES LIKE 'PARTIDAS'");
    if ($exists && $exists->num_rows > 0) {
        $games = [];
        $res = $conn->query('SELECT id FROM PARTIDAS ORDER BY id DESC');
        while ($row = $res->fetch_assoc()) {
            $games[] = $row;
        }
        echo json_encode(['success' => true, 'games' => $games]);
    } else {
        echo json_encode(['success' => true, 'games' => []]);
    }

} catch (Exception $e) {
    error_log('admin_list_games.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


