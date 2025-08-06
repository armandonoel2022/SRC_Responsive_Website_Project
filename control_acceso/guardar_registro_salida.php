<?php
// Configuración de conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "y3w7x7j8_intranet"; 

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Recoger los datos enviados desde el formulario de salida
$fecha_salida = $_POST['fecha_salida'];
$cedula_salida = $_POST['cedula_salida'];
$salida = $_POST['salida'];

// Actualizar la hora de salida en la base de datos para el empleado según su cédula
$sql = "UPDATE registros SET salida='$salida' WHERE fecha='$fecha_salida' AND cedula='$cedula_salida' AND salida IS NULL";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    // Redirigir a la página consulta_horas.php
    header("Location: consulta_horas.php");
    exit; // Detener la ejecución para evitar errores
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
