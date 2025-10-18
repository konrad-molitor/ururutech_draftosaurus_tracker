<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "DRAFTOSAURUS";

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit();
    }

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

    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit();
    }

    // Eliminar partida si existe la tabla PARTIDAS
    $exists = $conn->query("SHOW TABLES LIKE 'PARTIDAS'");
    if (!$exists || $exists->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Tabla PARTIDAS no existe']);
        exit();
    }

    $stmt = $conn->prepare('DELETE FROM PARTIDAS WHERE id = ?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();

    echo json_encode(['success' => $ok]);

} catch (Exception $e) {
    error_log('admin_delete_game.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


