<?php
// Conexión con la base de datos
$conn = new mysqli('localhost', 'y3w7x7j8_Administrador_2', 'AdminSrc_1234', 'y3w7x7j8_src_control_accesodb');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del registro a editar
$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Actualizar el registro en la base de datos
    $servicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_STRING);
    $fin_servicio = filter_input(INPUT_POST, 'fin_servicio', FILTER_SANITIZE_STRING);
    $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);
    $hora = filter_input(INPUT_POST, 'hora', FILTER_SANITIZE_STRING);

    $sql_update = "UPDATE registros SET servicio = ?, fin_servicio = ?, fecha = ?, hora = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ssssi', $servicio, $fin_servicio, $fecha, $hora, $id);

    if ($stmt_update->execute()) {
        echo "<script>
            alert('Registro actualizado con éxito');
            window.location.href = 'consulta_horas2.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al actualizar el registro: " . addslashes($stmt_update->error) . "');
        </script>";
    }

    $stmt_update->close();
} else {
    // Obtener el registro existente
    $sql = "SELECT seguridad, servicio, fin_servicio, nombre, apellido, funcion, cedula, matricula, fecha, hora, tipo FROM registros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $seguridad = $row['seguridad'];
        $servicio = $row['servicio'];
        $fin_servicio = $row['fin_servicio'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $funcion = $row['funcion'];
        $cedula = $row['cedula'];
        $matricula = $row['matricula'];
        $fecha = $row['fecha'];
        $hora = $row['hora'];
        $tipo = $row['tipo'];
    } else {
        echo "<script>
            alert('Registro no encontrado');
            window.location.href = 'consulta_horas2.php';
        </script>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .field {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="time"], input[type="date"] {
            height: 35px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            width: 100%;
            margin-top: 5px;
        }

        .btn {
            background-color: #71b7e6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        .btn:hover {
            background-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Registro</h1>

        <form method="POST" action="editar_registro.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="field">
                <label for="servicio">Puesta de Servicio:</label>
                <input type="time" id="servicio" name="servicio" value="<?php echo htmlspecialchars($servicio); ?>" required>
            </div>

            <div class="field">
                <label for="fin_servicio">Fin de Servicio:</label>
                <input type="time" id="fin_servicio" name="fin_servicio" value="<?php echo htmlspecialchars($fin_servicio); ?>" required>
            </div>

            <div class="field">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" required>
            </div>

            <div class="field">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" value="<?php echo htmlspecialchars($hora); ?>" required>
            </div>

            <button type="submit" class="btn" name="update">Actualizar Registro</button>
        </form>

        <button onclick="window.location.href='consulta_horas2.php'" class="btn">Cancelar</button>
    </div>
</body>
</html>
