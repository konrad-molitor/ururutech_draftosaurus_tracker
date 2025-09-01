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

    $stmt = $conn->prepare('SELECT id, name, birthday, email FROM USERS WHERE role = ? ORDER BY id ASC');
    $playerRole = 'player';
    $stmt->bind_param('s', $playerRole);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode(['success' => true, 'users' => $users]);

} catch (Exception $e) {
    error_log('admin_list_users.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


