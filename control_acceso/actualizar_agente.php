<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Datos del Agente de Seguridad</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos adicionales */
        .fields-container, .service-fields-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .field, .service-field {
            width: 45%;
        }
        .update-container {
            margin-top: 20px;
            text-align: center;
        }
        .update-container button {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Actualizar Datos del Agente de Seguridad</h1>

    <form action="guardar_agente.php" method="POST">
        <div class="fields-container">
            <div class="field">
                <label for="agente_seguridad">Agente de Seguridad:</label>
                <input type="text" id="agente_seguridad" name="seguridad" required>
            </div>
            <div class="field">
                <label for="agente_relevante">Agente Relevante:</label>
                <input type="text" id="agente_relevante" name="agente" required>
            </div>
        </div>

        <!-- Puesta de Servicio y Fin de Servicio -->
        <div class="service-fields-container">
            <div class="service-field">
                <label for="puesta_servicio">Puesta de Servicio:</label>
                <input type="time" id="puesta_servicio" name="servicio" required>
            </div>
            <div class="service-field">
                <label for="fin_servicio">Fin de Servicio:</label>
                <input type="time" id="fin_servicio" name="fin_servicio" required>
            </div>
        </div>

        <div class="update-container">
            <button type="submit">Actualizar Datos del Agente</button>
        </div>
    </form>
</body>
</html>
