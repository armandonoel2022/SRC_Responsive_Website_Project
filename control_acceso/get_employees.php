<?php
// get_employees.php
header('Content-Type: application/json'); // Aseg¨²rate de que la respuesta sea JSON

$conn = new mysqli('localhost', 'y3w7x7j8_Administrador_2', 'AdminSrc_1234', 'y3w7x7j8_src_control_accesodb');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexi¨®n: ' . $conn->connect_error]));
}

$sql = "SELECT id, nombre, funcion FROM empleados"; // Incluimos el ID para mayor precisi¨®n
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Error en la consulta: ' . $conn->error]));
}

$empleados = [];
while ($row = $result->fetch_assoc()) {
    $empleados[] = $row;
}

$conn->close();

echo json_encode($empleados); // Devuelve la lista de empleados en formato JSON
?>