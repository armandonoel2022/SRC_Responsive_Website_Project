<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Acceso denegado. Por favor, inicia sesión como administrador.");
}

$user_created = false; // Inicializamos la variable a false por defecto

if (isset($_POST['create_user'])) {
    // Aquí agregas el código para crear el usuario
    // Supón que la creación del usuario fue exitosa

    // Cambiar a true para indicar que el usuario se creó correctamente
    $user_created = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Usuarios</title>
    <link rel="stylesheet" href="/control_acceso/styles.css">
    <style>
        /* Fondo de la página */
        body {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* Contenedor del formulario */
        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            margin: 20px auto;
        }

        /* Banner principal */
        .banner {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Estilo para los campos del formulario */
        .fields-container, .service-fields-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .field, .service-field {
            flex: 1;
            margin: 0 10px;
        }

        input[type="text"], input[type="password"], select {
            height: 35px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            width: 100%;
        }

        /* Estilo para los botones */
        .register-btn {
            background-color: #71b7e6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
            width: 100%;
        }

        .register-btn:hover {
            background-color: #9b59b6;
        }

        /* Modal de éxito */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-content button {
            background-color: #71b7e6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-content button:hover {
            background-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="images/home-slide-1.jpg" alt="Banner Principal" class="banner">
        </header>

        <h1>Administrador de Usuarios</h1>

        <!-- Formulario para crear un nuevo usuario -->
        <h2>Crear Nuevo Usuario</h2>
        <form action="procesar_admin.php" method="POST">
            <label for="new_username">Nombre de Usuario:</label>
            <input type="text" id="new_username" name="new_username" required>

            <label for="new_password">Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit" name="create_user" class="register-btn">Crear Usuario</button>
        </form>

        <!-- Botón de logout -->
        <form action="logout.php" method="POST">
            <button type="submit" class="register-btn">Cerrar Sesión</button>
        </form>
    </div>

    <!-- Modal de éxito -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h2>¡Usuario creado satisfactoriamente!</h2>
            <p>El nuevo usuario se ha creado con éxito. Ahora puedes iniciar sesión.</p>
            <button onclick="window.location.href='login.html';">OK - Volver al Login</button>
        </div>
    </div>

    <script>
        // Mostrar el modal si el usuario fue creado
        <?php if ($user_created === true): ?>
            document.getElementById('successModal').style.display = 'block';
        <?php endif; ?>

        // Cerrar el modal cuando se haga clic fuera de la ventana
        window.onclick = function(event) {
            if (event.target == document.getElementById('successModal')) {
                document.getElementById('successModal').style.display = 'none';
            }
        }
    </script>
</body>
</html>
