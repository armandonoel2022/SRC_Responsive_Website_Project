<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "y3w7x7j8_Administrador_2", "AdminSrc_1234", "y3w7x7j8_src_control_accesodb");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_user'])) {
        $username = $_POST['new_username'];
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hashear la contrase«Ða
        
        $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->close();

        header("Location: admin_dashboard.php?success=Usuario creado con «±xito.");
    } elseif (isset($_POST['delete_user'])) {
        $username = $_POST['delete_username'];
        
        $sql = "DELETE FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();

        header("Location: admin_dashboard.php?success=Usuario eliminado.");
    } elseif (isset($_POST['change_password'])) {
        $username = $_POST['change_username'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hashear la nueva contrase«Ða
        
        $sql = "UPDATE usuarios SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $username);
        $stmt->execute();
        $stmt->close();

        header("Location: admin_dashboard.php?success=Contrase«Ða cambiada.");
    }
}

$conn->close();
?>
