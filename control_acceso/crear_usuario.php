<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2"; // Tu usuario de DB
$password = "AdminSrc_1234";           // Tu contraseña de DB
$dbname = "y3w7x7j8_src_control_accesodb"; // Tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Validar campos vacíos
    if (empty($user) || empty($pass)) {
        header("Location: admin_dashboard.php?error=Por favor, complete todos los campos.");
        exit;
    }

    // Generar el hash de la contraseña
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $sql = "INSERT INTO administradores (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $hashed_password);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=Usuario%20creado%20con%20éxito.");
    } else {
        header("Location: admin_dashboard.php?error=Error%20al%20crear%20el%20usuario.");
    }

    $stmt->close();
}

$conn->close();
?>
