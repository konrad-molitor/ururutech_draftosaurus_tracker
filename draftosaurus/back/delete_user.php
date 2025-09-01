<?php
// Eliminar cuenta de usuario autenticado por cookie "user"
try {
    $servername = "localhost";
    $username = "root"; // Usuario por defecto de XAMPP
    $db_password = ""; // Contraseña vacía por defecto
    $dbname = "DRAFTOSAURUS";

    // Verificar autenticación por cookie
    $email = $_COOKIE['user'] ?? '';
    if (empty($email)) {
        header("Location: ../front/rechazo.php");
        exit();
    }

    // Confirmación mínima mediante método POST para evitar CSRF básico por GET
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../front/rechazo.php");
        exit();
    }

    // Crear conexión
    $conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // Eliminar usuario por email
    $sql = 'DELETE FROM USERS WHERE email = ?';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();

    // Cerrar sesión/cookie
    setcookie("user", "", time() - 3600, "/");
    setcookie("role", "", time() - 3600, "/");
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();

    // Redirigir a inicio
    header("Location: ../front/index.php");
    exit();

} catch (Exception $e) {
    error_log("../back/delete_user.php: " . $e->getMessage());
    header("Location: ../front/rechazo.php");
    exit();
}
