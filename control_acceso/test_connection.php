<?php
$conn = new mysqli("localhost", "y3w7x7j8_Administrador_2", "AdminSrc_1234", "y3w7x7j8_src_control_accesodb");

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
} else {
    echo "¡Conexión exitosa!";
    $conn->close();
}
?>