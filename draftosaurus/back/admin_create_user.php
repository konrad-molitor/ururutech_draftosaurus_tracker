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

    $name = trim($_POST['name'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        echo json_encode(['success' => false, 'message' => 'Campos obligatorios faltan']);
        exit();
    }

    // Comprobar duplicado por email
    $dup = $conn->prepare('SELECT id FROM USERS WHERE email = ?');
    $dup->bind_param('s', $email);
    $dup->execute();
    $dupRes = $dup->get_result();
    if ($dupRes->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email ya registrado']);
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $rolePlayer = 'player';
    $stmt = $conn->prepare('INSERT INTO USERS (name, birthday, email, password, role) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $name, $birthday, $email, $hashed, $rolePlayer);
    $ok = $stmt->execute();

    echo json_encode(['success' => $ok]);

} catch (Exception $e) {
    error_log('admin_create_user.php: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?>


