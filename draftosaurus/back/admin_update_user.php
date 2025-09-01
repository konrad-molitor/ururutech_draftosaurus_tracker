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
    $name = trim($_POST['name'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($id <= 0 || $name === '' || $email === '') {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit();
    }

    if ($password !== '') {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE USERS SET name = ?, birthday = ?, email = ?, password = ? WHERE id = ?');
        $stmt->bind_param('ssssi', $name, $birthday, $email, $hashed, $id);
    } else {
        $stmt = $conn->prepare('UPDATE USERS SET name = ?, birthday = ?, email = ? WHERE id = ?');
        $stmt->bind_param('sssi', $name, $birthday, $email, $id);
    }

    $ok = $stmt->execute();
    echo json_encode(['success' => $ok]);

} catch (Exception $e) {
    error_log('admin_update_user.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


