
<?php
//conexión con base de datos

//Información necesaria sobre la base de datos para la conexión
$host = "localhost";
$user = "root";
$pass = "290515";
$bd = "Informacion";


//new mysqli: crea una nueva instancia u objeto de la clase sql que viene integrada en php

$conexion = new mysqli($host, $user, $pass, $bd);
$conexion->set_charset("utf8mb4"); //Esta función hacer posible que todos los posibles caracteres en Unicode que es un sistema de de codificación de caracteres, sean correctamente almacenados y precesados en la base de datos de modo que acepta carateres especiales, emojis...

if ($conexion->connect_error){ //conexion es ahora una instancia que puede utilizar los atributos y métodos de la clase sql. connect_error es un atributo que se utiliza para emitir un error
    die("Error de conexión: ". $conexion->connect_error); 
}// die es una funcion, similar a break (py) pero esta recibe un mensaje y detiene toda la ejecución en lugar de salir del bucle o condición y continuar con lo próximo.
echo "La conexión ha sido satisfactoria!";
// echo, funciona como el print (py) entre otras cosas


if ($_SERVER["REQUEST_METHOD"] == "POST"){ // _SERVER es una variable superglobal que viene integrada en php, funciona como un array (clave => valor) cuyos datos son especificos. REQUEST_METHOD es una clave de este array que tiene como valores _GET, _POST, etc... es un método de solicitud en el que llega una entrada 

    // ==; se utiliza para igualdad es decir 5 == '5' devuelve true pero === se utiliza para identidad es decir tanto el contenido como el tipo debe coincidir para que sea true.
    $nombre = $_POST["nombre"]; // _POST es otra vriable superglobal, dice que recibirás una entrada, y le puedes definir las claves y valores.
    $email = $_POST["email"];
    $ocupacion = $_POST["ocupacion"];
    $telefono = $_POST["telefono"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];


    $sql = ("INSERT INTO Personas (nombre, email, ocupacion, telefono, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)");
                         // Función prepare; prepara la consulta como una clase de plantilla segura que puede ejecutarse las veces que sean necesarias además de permitirnos utilizar paramentros en lugar de valores y son indicados como marcadores de posición ?
    $sentencia = $conexion->prepare($sql);

    // La funcion bin_param; asegura los valores insertados contando con automatización interna es decir, utiliza estrategías que garantizan que esos valores seran tratados de forma que no sean maliciosos como en el caso de tratar al código malicioso sql como string (s) en caso de que ese haya sido el tipo de dato definido en bin_param
    $sentencia->bind_param("sssss", $nombre, $email, $ocupacion, $telefono, $fecha_nacimiento);


    if($sentencia->execute() === False){
        die("Error: ". $sentencia->error);
    } else {
        echo "El registro se ha insertado satisfactoriamente!";
    }

    // delete de dos registros que se habian guardado incorrectamente debido a la falta de utf8mb4

    $id_1 = 6;
    $id_2 = 20;
    
    $delete = $conexion->prepare("DELETE FROM Personas WHERE id IN (?, ?)");

    if ($delete === False){
        die("Error al preparar la sentencia: ". $conexion->error);
    }

    $delete->bind_param("ii", $id_1, $id_2);

    if($delete->execute()){
        echo "Lod ids se han eliminado satisfactoriamente!";
    } else {
        die("Error: ". $delete->error);
    }




   
}
$conexion->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>FORMULARIO DE REGISTRO</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <!-- Creamos un formulario que con action indica la ruta de donde serán enviadas las entradas del formulario, es decir echo imprimie o emite esta ruta a través de htmlspecialchars() esta función protege los datos o página de recibir scripst malisiosos que puedan afectar la seguridad de los usuarios conocidos como XSS (croos-site scripting). La variable superglobal $_SERVER[] tiene como indice "PHP_SELF" esta clave tiene como valor la ruta del archivo actual, luego tenemos el method que a través del atributo post es una forma segura de enviar datos ya que no se guardan ni envian a través de la URL -->
        
        <h1>Formulario de Registro</h1><br>
        <h2>Nombre: </h2><input type="text" name= "nombre" placeholder="Nombre" required><br>
        <h2>Email: </h2><input type="email" name="email" placeholder= "Ej.:hola@gmail.com" id="mail" required><br>
        <h2>Ocupación: </h2><input type="text" name="ocupacion" placeholder="Ocupación" required><br>
        <h2>Teléfono: </h2><input type="text" name= "telefono" placeholder="Teléfono" required><br>
        <h2>Fecha de Nacimiento: </h2><input type="date" name="fecha_nacimiento" id="born"><br> <input type="submit" id="register">
    </form>
    
</body>
</html>



