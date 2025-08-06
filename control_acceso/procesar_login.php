<?php
// Configuración para mostrar errores (para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2";
$password = "AdminSrc_1234";
$dbname = "y3w7x7j8_src_control_accesodb";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario de inicio de sesión
$user = $_POST['username'] ?? ''; // Obtener el valor del campo 'username' del formulario
$pass = $_POST['password'] ?? ''; // Obtener el valor del campo 'password' del formulario

// Validar campos vacíos
if (empty($user) || empty($pass)) {
    header("Location: login.html?error=Por favor, completa todos los campos.");
    exit;
}

// Consulta para verificar el usuario en la tabla 'usuarios'
$sql = "SELECT * FROM usuarios WHERE username = ?"; // Asegúrate de que el campo sea 'username'
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user); // 's' para indicar que es un string
$stmt->execute();
$result = $stmt->get_result();

// Validar usuario y contraseña
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verificar contraseña utilizando password_verify()
    if (password_verify($pass, $row['password'])) { // Asegúrate de que el campo de la contraseña sea 'password'
        // Iniciar sesión y redirigir
        session_start();
        $_SESSION['user_id'] = $row['id']; // Almacenar el ID del usuario en la sesión
        header("Location: index.html"); // Redirigir al usuario a la página principal después del login
        exit;
    } else {
        // Contraseña incorrecta
        header("Location: login.html?error=Contraseña incorrecta.");
        exit;
    }
} else {
    // El usuario no existe
    header("Location: login.html?error=El usuario no existe.");
    exit;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>