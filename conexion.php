<?php

echo "This is PHP page.";

$connection = mysqli_connect('localhost','root','','book_db');

//contador
if($_COOKIE["MIS_VISITAS"] != 'OK'){
    setcookie('MIS_VISITAS','OK',time()+(60*60*24*365));

    $ip = $_SERVER['REMOTE_ADDR'];

    $query = 'INSERT INTO visitas (ip)
    VALUES (\''.$ip.'\')';
    mysqli_query($conexion,$query);
}
?>