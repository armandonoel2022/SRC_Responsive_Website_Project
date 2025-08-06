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
$seguridad = filter_input(INPUT_POST, 'seguridad', FILTER_SANITIZE_STRING);
$agente = filter_input(INPUT_POST, 'agente', FILTER_SANITIZE_STRING);
$servicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_STRING);
$fin_servicio = filter_input(INPUT_POST, 'fin_servicio', FILTER_SANITIZE_STRING);
$fecha = date('Y-m-d');

if (!$seguridad || !$agente || !$servicio || !$fin_servicio) {
    die("Error: Todos los campos deben ser completados.");
}

// Insertar o actualizar los datos del agente de seguridad
$sql = "INSERT INTO agente_seguridad (seguridad, agente, servicio, fin_servicio, fecha) 
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        seguridad = VALUES(seguridad),
        agente = VALUES(agente),
        servicio = VALUES(servicio),
        fin_servicio = VALUES(fin_servicio),
        fecha = VALUES(fecha)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $seguridad, $agente, $servicio, $fin_servicio, $fecha);

// Ejecutar la consulta
if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
