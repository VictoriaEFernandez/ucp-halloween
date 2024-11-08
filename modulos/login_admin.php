<?php
// Conexión a la base de datos
$con = mysqli_connect("localhost", "root", "", "halloween_2024");

if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Cerrar sesión
if(isset($_GET['salir'])) {
    session_destroy();
    echo "<script>window.location='index.php';</script>";
}

// Iniciar sesión como administrador
if(isset($_POST['nombre']) && isset($_POST['clave'])) {
    // Consulta para verificar si el administrador existe
    $sql = "SELECT * FROM admins WHERE nombre='" . $_POST['nombre'] . "'";
    $sql = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($sql) != 0) {
        // Si el administrador existe, obtener los datos
        $r = mysqli_fetch_array($sql);
        
        if(password_verify(addslashes($_POST['clave']), $r['clave'])) {
            // Crear las variables de sesión para el administrador
            $_SESSION['admin_id'] = $r['id'];
            $_SESSION['admin_nombre'] = $r['nombre'];
        
            echo "<script>window.location='index.php?modulo=procesar_disfraz';</script>";
        } else {
            echo "<script>alert('Clave incorrecta.');</script>";
        }
    } else {
        // El administrador no existe
        echo "<script>alert('Verifique los datos.');</script>";
    }
}
?>

<section id="login_admin" class="section">
    <h2>Iniciar Sesión como Administrador</h2>
    <form action="login_admin.php" method="POST">
        <label for="login-username">Nombre de Usuario:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="login-password">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
</section>
