<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Acceso Diario</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="container">
    <header>
        <img src="images/home-slide-1.jpg" alt="Banner Principal" class="banner">
    </header>

    <h1>CONTROL DE ACCESO DIARIO EN PUESTO RESIDENCIA DE FRANCIA</h1>

    <?php
    // Conexión con la base de datos
    $conn = new mysqli('localhost', 'Administrador', 'AdminSrc_1234', 'src_control_accesodb');

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Cargar datos del agente de seguridad
    $sql = "SELECT * FROM agente_seguridad ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    $seguridad = "";
    $agente = "";
    $servicio = "";
    $fin_servicio = "";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $seguridad = $row['seguridad'];
        $agente = $row['agente'];
        $servicio = $row['servicio'];
        $fin_servicio = $row['fin_servicio'];
    }

    // Cargar datos de los empleados
    $sql_empleados = "SELECT nombre, funcion FROM empleados";
    $result_empleados = $conn->query($sql_empleados);
    $empleados = [];
    while ($row_empleado = $result_empleados->fetch_assoc()) {
        $empleados[] = $row_empleado;
    }

    $conn->close();
    ?>

    <form action="guardar_registro.php" method="POST" onsubmit="saveFormData()">
        <!-- Campos Agente de Seguridad y Agente Relevante -->
        <div class="fields-container">
            <div class="field">
                <label for="agente_seguridad">Agente de Seguridad:</label>
                <input type="text" id="agente_seguridad" name="seguridad" value="<?php echo htmlspecialchars($seguridad); ?>" required>
            </div>
            <div class="field">
                <label for="agente_relevante">Agente Relevante:</label>
                <input type="text" id="agente_relevante" name="agente" value="<?php echo htmlspecialchars($agente); ?>" required>
            </div>
        </div>

        <!-- Puesta de Servicio y Fin de Servicio -->
        <div class="service-fields-container">
            <div class="service-field">
                <label for="puesta_servicio">Puesta de Servicio:</label>
                <input type="time" id="puesta_servicio" name="servicio" value="<?php echo htmlspecialchars($servicio); ?>" required>
            </div>
            <div class="service-field">
                <label for="fin_servicio">Fin de Servicio:</label>
                <input type="time" id="fin_servicio" name="fin_servicio" value="<?php echo htmlspecialchars($fin_servicio); ?>" required>
            </div>
        </div>

        <!-- Fecha y Reloj -->
        <div class="date" id="date">Fecha: </div>
        <div class="clock" id="clock">00:00:00</div>

        <!-- Tipo de Persona -->
        <label for="tipo_persona">Tipo de Persona:</label>
        <select id="tipo_persona" name="tipo_persona" onchange="toggleFields()">
            <option value="empleado">Empleado</option>
            <option value="visitante">Visitante</option>
        </select>

        <!-- Campos para Empleado -->
        <div id="empleado-fields">
            <label for="nombre_empleado">Nombre del Empleado:</label>
            <select id="nombre_empleado" name="nombre_empleado" onchange="updateFuncion()">
                <?php
                foreach ($empleados as $empleado) {
                    echo "<option value='{$empleado['nombre']}'>{$empleado['nombre']}</option>";
                }
                ?>
            </select>

            <label for="funcion">Función:</label>
            <input type="text" id="funcion" name="funcion" readonly>
        </div>

        <!-- Campos para Visitante -->
        <div id="visitante-fields" class="hidden">
            <label for="nombre_visitante">Nombre(s):</label>
            <input type="text" id="nombre_visitante" name="nombre_visitante">

            <label for="apellido">Apellido(s):</label>
            <input type="text" id="apellido" name="apellido">

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula">

            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula">
        </div>

        <!-- Botones -->
        <button type="submit" class="register-btn">REGISTRAR</button>
        <button type="button" onclick="window.location.href='consulta_horas.php'" class="register-btn">CONSULTAR</button>
        <button type="button" onclick="openModal()" class="register-btn">AGREGAR EMPLEADO</button>
    </form>

    <!-- Modal para agregar empleado -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form action="agregar_empleado.php" method="POST" onsubmit="return addEmployee()">
                <label for="new_nombre">Nombre:</label>
                <input type="text" id="new_nombre" name="new_nombre" required>
                
                <label for="new_funcion">Función:</label>
                <input type="text" id="new_funcion" name="new_funcion" required>
                
                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }
        setInterval(updateClock, 1000);

        function updateDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('es-ES', options);
            document.getElementById('date').textContent = `Fecha: ${formattedDate}`;
        }
        updateDate();

        function toggleFields() {
            const tipoPersona = document.getElementById('tipo_persona').value;
            document.getElementById('empleado-fields').classList.toggle('hidden', tipoPersona !== 'empleado');
            document.getElementById('visitante-fields').classList.toggle('hidden', tipoPersona !== 'visitante');
        }

        function updateFuncion() {
            const nombreEmpleado = document.getElementById('nombre_empleado').value;
            const funcion = document.getElementById('funcion');
            const funciones = {
                <?php
                foreach ($empleados as $empleado) {
                    echo "'{$empleado['nombre']}': '{$empleado['funcion']}',";
                }
                ?>
            };
                        funcion.value = funciones[nombreEmpleado] || '';
        }

        // Guardar los datos del formulario en localStorage
        function saveFormData() {
            const seguridad = document.getElementById('agente_seguridad').value;
            const agente = document.getElementById('agente_relevante').value;
            const servicio = document.getElementById('puesta_servicio').value;
            const fin_servicio = document.getElementById('fin_servicio').value;
            localStorage.setItem('seguridad', seguridad);
            localStorage.setItem('agente', agente);
            localStorage.setItem('servicio', servicio);
            localStorage.setItem('fin_servicio', fin_servicio);
        }

        // Cargar los datos del formulario desde localStorage
        window.onload = function() {
            document.getElementById('agente_seguridad').value = localStorage.getItem('seguridad') || '';
            document.getElementById('agente_relevante').value = localStorage.getItem('agente') || '';
            document.getElementById('puesta_servicio').value = localStorage.getItem('servicio') || '';
            document.getElementById('fin_servicio').value = localStorage.getItem('fin_servicio') || '';
            updateFuncion();
        };

        function openModal() {
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        function addEmployee() {
            // Aquí puedes agregar lógica adicional si necesitas procesar datos antes de enviar el formulario
            return true;
        }
    </script>
</body>
</html>