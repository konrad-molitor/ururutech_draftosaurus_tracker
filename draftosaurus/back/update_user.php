<?php
session_start();
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$db_password = ""; // Contraseña vacía por defecto
$dbname = "DRAFTOSAURUS";

// Crear conexión
$conn = new mysqli($servername, $username, $db_password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos de bd
$email = $_COOKIE['user'];

try {
    $sql = 'SELECT name, birthday, email FROM USERS WHERE email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        header("Location: ../front/rechazo.php"); // Redirigir a página de rechazo
    }

    $user = $result->fetch_assoc();

    $name = $_POST['name'] ?? $user['name']; //Obtener nuevo nombre
    
    $updateSql = 'UPDATE USERS SET name = ? WHERE email = ?';
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('ss', $name, $user['email']);
    $updateStmt->execute();
    // Sincronizar el nombre en la sesión
    if (isset($_SESSION['user'])) {
        $_SESSION['user']['name'] = $name;
    }
    header("Location: ../front/index.php"); // Redirigir a página principal

} catch (Exception $e) {
    $error_msg = print_r($e, true);
    error_log("../back/update_user.php: $error_msg");
};
?>
