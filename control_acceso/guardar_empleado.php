<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2";
$password = "AdminSrc_1234";
$dbname = "y3w7x7j8_src_control_accesodb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Recoger los datos enviados desde el formulario
$nombre_empleado = filter_input(INPUT_POST, 'nombre_empleado', FILTER_SANITIZE_STRING);
$funcion_empleado = filter_input(INPUT_POST, 'funcion_empleado', FILTER_SANITIZE_STRING);

if (!$nombre_empleado || !$funcion_empleado) {
    die("Error: Todos los campos deben ser completados.");
}

// Insertar el nuevo empleado en la base de datos
$sql_insert = "INSERT INTO empleados (nombre, funcion) VALUES (?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ss", $nombre_empleado, $funcion_empleado);

if ($stmt_insert->execute()) {
    echo "Empleado agregado correctamente.";
} else {
    echo "Error: " . $stmt_insert->error;
}

// Cerrar la conexión
$stmt_insert->close();
$conn->close();
?>
