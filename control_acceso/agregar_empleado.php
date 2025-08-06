<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2";
$password = "AdminSrc_1234";
$dbname = "y3w7x7j8_src_control_accesodb";

// Establecer conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Recoger datos del formulario de manera segura
$new_nombre = filter_input(INPUT_POST, 'new_nombre', FILTER_SANITIZE_STRING);
$new_funcion = filter_input(INPUT_POST, 'new_funcion', FILTER_SANITIZE_STRING);

// Verificar que los campos no estén vacíos
if (empty($new_nombre) || empty($new_funcion)) {
    header("Location: index.html?error=missing_fields");
    exit;
}

// Preparar la consulta para evitar inyecciones SQL
$sql = "INSERT INTO empleados (nombre, funcion) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Verificar que la consulta se preparó correctamente
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

// Vincular los parámetros
$stmt->bind_param("ss", $new_nombre, $new_funcion);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir con mensaje de éxito
    header("Location: index.html?success=employee_added");
} else {
    // Redirigir con mensaje de error si falla la inserción
    header("Location: index.html?error=insert_failed");
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
