<?php
// db_connect.php
$con = mysqli_connect("localhost", "root", "", "halloween_2024");

// Verificar la conexión
if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
