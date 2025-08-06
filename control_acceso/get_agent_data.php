<?php
// get_agent_data.php
$conn = new mysqli('localhost', 'y3w7x7j8_Administrador_2', 'AdminSrc_1234', 'y3w7x7j8_src_control_accesodb');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM agente_seguridad ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

$conn->close();

echo json_encode($data);
?>
