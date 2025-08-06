<?php
// Conexión con la base de datos
$conn = new mysqli('localhost', 'y3w7x7j8_Administrador_2', 'AdminSrc_1234', 'y3w7x7j8_src_control_accesodb');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los filtros si existen
$filterName = isset($_POST['filter_name']) ? $_POST['filter_name'] : '';
$filterStartDate = isset($_POST['filter_start_date']) ? $_POST['filter_start_date'] : '';
$filterEndDate = isset($_POST['filter_end_date']) ? $_POST['filter_end_date'] : '';
$timeFormat = isset($_POST['time_format']) ? $_POST['time_format'] : '12h';

// Consultar los registros con opción de filtrar por persona, fechas y ordenados por fecha más reciente
$sql = "SELECT id, seguridad, servicio, fin_servicio, nombre, apellido, funcion, cedula, matricula, fecha, hora, tipo FROM registros";
$whereClauses = [];

if ($filterName != '') {
    $whereClauses[] = "(nombre LIKE '%$filterName%' OR cedula LIKE '%$filterName%' OR matricula LIKE '%$filterName%')";
}

if ($filterStartDate != '' && $filterEndDate != '') {
    $whereClauses[] = "(fecha BETWEEN '$filterStartDate' AND '$filterEndDate')";
} elseif ($filterStartDate != '') {
    $whereClauses[] = "(fecha >= '$filterStartDate')";
} elseif ($filterEndDate != '') {
    $whereClauses[] = "(fecha <= '$filterEndDate')";
}

if (count($whereClauses) > 0) {
    $sql .= " WHERE " . implode(' AND ', $whereClauses);
}

$sql .= " ORDER BY fecha DESC, hora DESC"; // Asegúrate de ordenar por fecha y hora para obtener los eventos correctos
$result = $conn->query($sql);

// Establecer la fecha actual con meses abreviados
$meses = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
$fecha_actual = date('j') . " " . $meses[date('n') - 1] . " " . date('Y');

// Generar tabla HTML con estilos
echo "<style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header .date { margin-top: 5px; }
        .table-container { margin: 0 auto; width: 90%; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th.date-column, th.time-column, td.date-column, td.time-column {
            width: 150px; /* Aumentar el ancho de las columnas de fecha y hora */
        }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:nth-child(odd) { background-color: #ffffff; }
        th { background-color: #4CAF50; color: white; }
        .form-container { margin: 20px auto; width: 90%; text-align: center; }
        .form-container input, .form-container select { padding: 5px; }
        .form-container button { padding: 5px 10px; margin-left: 5px; }
      </style>";

echo "<div class='header'>
        <img src='images/SRC_Logo.png' alt='SRC Logo' style='width: 100px; margin-top: 10px;'>
        <h1>CONTROL DE ACCESO DIARIO EN PUESTO RESIDENCIA DE FRANCIA</h1>
        <div class='date'>Fecha: $fecha_actual</div>
      </div>";

if ($result->num_rows > 0) {
    echo "<div class='form-container'>
            <form method='POST' action=''>
                <label for='filter_name'>Filtrar por Persona:</label>
                <input type='text' name='filter_name' id='filter_name' value='$filterName'>
                
                <label for='filter_start_date'>Fecha de Inicio:</label>
                <input type='date' name='filter_start_date' id='filter_start_date' value='$filterStartDate'>
                
                <label for='filter_end_date'>Fecha de Fin:</label>
                <input type='date' name='filter_end_date' id='filter_end_date' value='$filterEndDate'>
                
                <label for='time_format'>Formato de Hora:</label>
                <select name='time_format' id='time_format' onchange='this.form.submit()'>
                    <option value='12h' " . ($timeFormat == '12h' ? 'selected' : '') . ">12 Horas</option>
                    <option value='24h' " . ($timeFormat == '24h' ? 'selected' : '') . ">24 Horas</option>
                </select>
                
                <button type='submit'>Filtrar</button>
                <button type='button' onclick='window.print();'>Imprimir</button>
                <button type='button' onclick='window.location.href=\"index.html\";'>Volver al formulario</button>
                <button type='button' onclick='clearFilters();'>Limpiar filtros</button>
            </form>
          </div>";

    echo "<div class='table-container'>
            <table>
                <tr>
                    <th>Agente de Seguridad</th>
                    <th>Puesta de Servicio</th>
                    <th>Fin de Servicio</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Función</th>
                    <th>Cédula/Pasaporte</th>
                    <th>Matrícula</th>
                    <th class='date-column'>Fecha</th>
                    <th class='time-column'>Hora</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>";

    while ($row = $result->fetch_assoc()) {
        // Convertir la hora según el formato seleccionado
        if ($timeFormat == '24h') {
            $hora_formateada = date('H:i:s', strtotime($row['hora']));
            $servicio_formateado = date('H:i', strtotime($row['servicio']));
            $fin_servicio_formateado = date('H:i', strtotime($row['fin_servicio']));
        } else {
            $hora_formateada = date('h:i:s A', strtotime($row['hora']));
            $servicio_formateado = date('h:i A', strtotime($row['servicio']));
            $fin_servicio_formateado = date('h:i A', strtotime($row['fin_servicio']));
        }
        $fecha_formateada = date('j', strtotime($row['fecha'])) . " " . $meses[date('n', strtotime($row['fecha'])) - 1] . " " . date('Y', strtotime($row['fecha']));

        echo "<tr>
                <td>{$row['seguridad']}</td>
                <td>{$servicio_formateado}</td>
                <td>{$fin_servicio_formateado}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido']}</td>
                <td>{$row['funcion']}</td>
                <td>{$row['cedula']}</td>
                <td>{$row['matricula']}</td>
                <td class='date-column'>{$fecha_formateada}</td>
                <td class='time-column'>{$hora_formateada}</td>
                <td>{$row['tipo']}</td>
                <td>
                    <form action='editar_registro.php' method='POST'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Editar</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table></div>";
} else {
    echo "<p>No hay registros disponibles.</p>";
}

// Mostrar mensaje de éxito si se ha redirigido correctamente desde guardar_registro.php
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<p>El registro se ha guardado correctamente.</p>";
}

echo "<br><button onclick='window.location.href=\"index.html\"'>Volver al formulario</button>";

$conn->close();
?>

<script>
    function clearFilters() {
        // Resetea los campos del formulario y recarga la página sin los filtros
        document.getElementById('filter_name').value = '';
        document.getElementById('filter_start_date').value = '';
        document.getElementById('filter_end_date').value = '';
        document.getElementById('time_format').value = '12h'; // Opcional, puedes dejar el valor por defecto

        // Recargar la página para aplicar los filtros limpiados
        window.location.href = window.location.pathname;
    }
