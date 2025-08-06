<?php
// Configuración de conexión a la base de datos
$servername = "localhost"; 
$username = "y3w7x7j8_Administrador"; 
$password = "Src_Control@2025"; 
$dbname = "y3w7x7j8_control_acceso";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Recoger los datos enviados desde el formulario
$fecha = date('Y-m-d'); // Fecha actual
$hora = date('H:i:s'); // Hora actual
$seguridad = $_POST['seguridad'];
$agente = $_POST['agente'];
$servicio = $_POST['servicio'];
$fin_servicio = $_POST['fin_servicio'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$funcion = $_POST['funcion'];
$cedula = $_POST['cedula'];
$matricula = $_POST['matricula'];

// Verificar si existe un registro de entrada para el mismo visitante/empleado
$sql_check = "SELECT id FROM registros 
              WHERE cedula = '$cedula' 
              AND fecha = '$fecha' 
              AND tipo = 'entrada'";
$result = $conn->query($sql_check);

// Determinar el tipo de evento (entrada o salida)
if ($result->num_rows > 0) {
    $tipo = 'salida';
} else {
    $tipo = 'entrada';
}

// Preparar la consulta de inserción
$sql_insert = "INSERT INTO registros (fecha, seguridad, agente, servicio, fin_servicio, nombre, apellido, funcion, cedula, matricula, hora, tipo) 
               VALUES ('$fecha', '$seguridad', '$agente', '$servicio', '$fin_servicio', '$nombre', '$apellido', '$funcion', '$cedula', '$matricula', '$hora', '$tipo')";

// Ejecutar la consulta
if ($conn->query($sql_insert) === TRUE) {
    // Redirigir a la página de consulta
    header("Location: control_acceso/consulta_horas.php");
    exit;
} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
