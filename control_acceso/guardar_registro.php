<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "y3w7x7j8_Administrador_2";
$password = "AdminSrc_1234";
$dbname = "y3w7x7j8_src_control_accesodb";

// Establecer la zona horaria a la hora actual del servidor
date_default_timezone_set('America/Santo_Domingo');

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Recoger los datos enviados desde el formulario
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$seguridad = filter_input(INPUT_POST, 'seguridad', FILTER_SANITIZE_STRING);
$servicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_STRING);
$fin_servicio = filter_input(INPUT_POST, 'fin_servicio', FILTER_SANITIZE_STRING);

// Validar campos obligatorios
if (!$seguridad || !$servicio || !$fin_servicio) {
    header("Location: consulta_horas.php?error=missing_fields");
    exit;
}

// Insertar en la tabla agente_seguridad (sin el campo agente)
$sql_agente = "INSERT INTO agente_seguridad (seguridad, servicio, fin_servicio, fecha) 
               VALUES (?, ?, ?, ?)";
$stmt_agente = $conn->prepare($sql_agente);
$stmt_agente->bind_param("ssss", $seguridad, $servicio, $fin_servicio, $fecha);

if (!$stmt_agente->execute()) {
    echo "<script>
        alert('Error al guardar el registro de agente de seguridad: " . addslashes($stmt_agente->error) . "');
        window.history.back();
    </script>";
    $stmt_agente->close();
    $conn->close();
    exit;
}

// Verificar el tipo de persona
$tipo_persona = filter_input(INPUT_POST, 'tipo_persona', FILTER_SANITIZE_STRING);

if ($tipo_persona === 'empleado') {
    $nombre = filter_input(INPUT_POST, 'nombre_empleado', FILTER_SANITIZE_STRING);
    $funcion = filter_input(INPUT_POST, 'funcion_empleado', FILTER_SANITIZE_STRING);
    $cedula = null;
    $apellido = $matricula = null;
    if (!$nombre) {
        header("Location: consulta_horas.php?error=missing_name_function_employee");
        exit;
    }
} elseif ($tipo_persona === 'visitante') {
    $nombre = filter_input(INPUT_POST, 'nombre_visitante', FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
    $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
    $funcion = filter_input(INPUT_POST, 'funcion_visitante', FILTER_SANITIZE_STRING);
    if (!$nombre || !$cedula) {
        header("Location: consulta_horas.php?error=missing_name_function_id_visitor");
        exit;
    }
} else {
    header("Location: consulta_horas.php?error=invalid_person_type");
    exit;
}

// Determinar tipo (entrada o salida)
$tipo = 'entrada';
$sql_check = $cedula 
    ? "SELECT tipo FROM registros WHERE cedula = ? AND fecha = ? ORDER BY id DESC LIMIT 1" 
    : "SELECT tipo FROM registros WHERE nombre = ? AND fecha = ? ORDER BY id DESC LIMIT 1";
$stmt_check = $conn->prepare($sql_check);

if ($cedula) {
    $stmt_check->bind_param("ss", $cedula, $fecha);
} else {
    $stmt_check->bind_param("ss", $nombre, $fecha);
}

$stmt_check->execute();
$result = $stmt_check->get_result();
if ($result->num_rows > 0) {
    $last_record = $result->fetch_assoc();
    if ($last_record['tipo'] === 'entrada') {
        $tipo = 'salida';
    }
}
$stmt_check->close();

// Insertar en la tabla registros (sin el campo agente)
$sql_insert = "INSERT INTO registros (fecha, seguridad, servicio, fin_servicio, nombre, apellido, funcion, cedula, matricula, hora, tipo, tipo_persona) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ssssssssssss", $fecha, $seguridad, $servicio, $fin_servicio, $nombre, $apellido, $funcion, $cedula, $matricula, $hora, $tipo, $tipo_persona);

if ($stmt_insert->execute()) {
    echo "<script>
        alert('Registro guardado con éxito');
        window.location.href = 'index.html';
    </script>";
} else {
    echo "<script>
        alert('Error al guardar el registro: " . addslashes($stmt_insert->error) . "');
    </script>";
}

// Cerrar conexiones
$stmt_insert->close();
$conn->close();
?>
