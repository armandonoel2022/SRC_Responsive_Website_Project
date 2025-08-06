<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesi√≥n Administrador</title>
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

        .banner {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .field {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="password"] {
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

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="images/home-slide-1.jpg" alt="Banner Principal" class="banner">
        </header>

        <h1>Iniciar Sesi√≥n Administrador</h1>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form action="procesar_admin_login.php" method="POST">
            <div class="field">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="field">
                <label for="password">Contrasena:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Bot®Æn para iniciar sesi®Æn con diferentes opciones -->
            <button type="submit" class="btn" name="action" value="dashboard">Gestionar Usuarios</button>
            <button type="submit" class="btn" name="action" value="eliminar">Eliminar Empleados</button>
            <button type="submit" class="btn" name="action" value="editar">Editar Entradas y Salidas</button>
        </form>
    </div>
</body>
</html>
