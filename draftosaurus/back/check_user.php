<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "DRAFTOSAURUS";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener email desde POST
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Email requerido']);
        exit();
    }

    // Verificar existencia de usuario
    $sql = "SELECT name, email, id FROM USERS WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            'success' => true, 
            'user' => [
                'name' => $user['name'],
                'email' => $user['email'],
                'id' => $user['id']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    error_log("Error en check_user.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error del servidor']);
}
?> 