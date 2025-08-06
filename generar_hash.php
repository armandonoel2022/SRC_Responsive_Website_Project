<?php
$contraseña = "Src_Control@2025"; // Nueva contraseña para el administrador
$hash = password_hash($contraseña, PASSWORD_DEFAULT); // Genera el hash de la contraseña
echo "El hash para la contraseña es: $hash";
?>

