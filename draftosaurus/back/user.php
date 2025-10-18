<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$db_password = ""; // Contraseña vacía por defecto
$dbname = "DRAFTOSAURUS";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Hashear el password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO USERS (name, birthday, email, password)
    VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $birthday, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../front/confirmacion.php"); // Redirigir a página de confirmación
        exit();
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

} catch (Exception $e) {
    // Registrar error y redirigir
    error_log("Error en registro: " . $e->getMessage());
    header("Location: ../front/rechazo.php");
    exit();
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>
