<?php
session_start();
include 'C:\Users\vicki\Desktop\Xampp\htdocs\ucp_halloween\db_connect.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Por favor, inicie sesión para votar.'); window.location.href = 'index.php?modulo=procesar_login';</script>";
    exit();
}

// Verificar que se recibió el ID del disfraz a votar
if (isset($_POST['disfraz_id'])) {
    $disfraz_id = intval($_POST['disfraz_id']);
    $user_id = $_SESSION['id'];

    // Verificar si el usuario ya ha votado por este disfraz
    $verificar_voto = "SELECT * FROM votos WHERE id_usuario = $user_id AND id_disfraz = $disfraz_id";
    $resultado = mysqli_query($con, $verificar_voto);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<script>alert('Ya has votado por este disfraz.'); window.location.href = 'index.php';</script>";
    } else {
        // Registrar el voto en la tabla votos
        $insertar_voto = "INSERT INTO votos (id_usuario, id_disfraz) VALUES ($user_id, $disfraz_id)";
        if (mysqli_query($con, $insertar_voto)) {
            // Actualizar el contador de votos en la tabla disfraces
            $actualizar_votos = "UPDATE disfraces SET votos = votos + 1 WHERE id = $disfraz_id";
            mysqli_query($con, $actualizar_votos);
            echo "<script>alert('Gracias por votar.'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el voto.'); window.location.href = 'index.php';</script>";
        }
    }
} else {
    echo "<script>alert('Disfraz no encontrado.'); window.location.href = 'index.php';</script>";
}

mysqli_close($con);
?>
