<?php
// Esta una prueba para subir un archivo a github a través del Bash utilizando el comando = git push -u origin main 

$host = "localhost";
$user = "root";
$pass = "290515";
$bd = "Informacion";

$conexion = new mysqli($host, $user, $pass, $bd);


if ($conexion->connect_error){
    die("Error de la conexión: ".$conexion->connect_error);
}
echo "La conexión ha sido satisfactoria!";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $ocupacion = $_POST["ocupacion"];
    $telefono = $_POST["telefono"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];


    $sql = "INSERT INTO Personas (nombre, email, ocupacion, telefono, fecha_nacimiento) VALUES ('$nombre', '$email', '$ocupacion', '$telefono', '$facha_nacimiento')";

    if ($conexion->query($sql) === true){
        echo "Se ha realizado satifactoriamente el registro.";
    } else {
        echo "Error: ". $conexion->error;
    }
}


$conexion->close();

?>

