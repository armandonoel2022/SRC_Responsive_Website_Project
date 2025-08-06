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

// Iniciar sesión
session_start();

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario de inicio de sesión
$user = $_POST['username'] ?? ''; 
$pass = $_POST['password'] ?? '';
$action = $_POST['action'] ?? ''; // Determinar a qué página redirigir

// Validar campos vacíos
if (empty($user) || empty($pass)) {
    header("Location: admin_login.php?error=Por favor, completa todos los campos.");
    exit;
}

// Consulta para verificar si el usuario es un administrador
$sql = "SELECT * FROM administradores WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Validar usuario y contraseña
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verificar contraseña utilizando password_verify()
    if (password_verify($pass, $row['password'])) { 
        // Almacenar sesión correctamente
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_user'] = $user;

        // Redirigir según la acción seleccionada
        if ($action === "dashboard") {
            header("Location: admin_dashboard.php"); // Redirige al dashboard
        } elseif ($action === "eliminar") {
            header("Location: index2.html"); // Redirige a eliminación
        }
        else if($action === "editar") {
            header("Location: consulta_horas2.php"); // Redirige a edición de entradas y salidas
            exit;
        }
        
        exit;
    } else {
        header("Location: admin_login.php?error=Contraseña incorrecta.");
        exit;
    }
} else {
    header("Location: admin_login.php?error=El usuario no existe.");
    exit;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
