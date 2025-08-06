<?php
header('Content-Type: application/json');

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2";
$password = "AdminSrc_1234";
$dbname = "y3w7x7j8_src_control_accesodb";

// Establecer conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'La conexión ha fallado: ' . $conn->connect_error]));
}

// Recoger datos del cuerpo de la solicitud (en formato JSON)
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id']; // ID del empleado a eliminar

// Validar que se recibió el ID del empleado
if (empty($id)) {
    echo json_encode(['success' => false, 'message' => 'ID del empleado no proporcionado.']);
    exit;
}

// Preparar la consulta SQL para eliminar el empleado
$sql = "DELETE FROM empleados WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    exit;
}

// Vincular el parámetro (ID del empleado) a la consulta
$stmt->bind_param("i", $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Verificar si se eliminó algún registro
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Empleado eliminado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró un empleado con ese ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>