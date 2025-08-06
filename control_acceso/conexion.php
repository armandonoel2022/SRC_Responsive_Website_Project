<?php
// Establecer la conexión con la base de datos "intranet"
$connection = mysqli_connect('localhost', 'root', '', 'y3w7x7j8_intranet');

// Verificar si la conexión fue exitosa
if (!$connection) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
