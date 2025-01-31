

<?php
//conexión con base de datos

//Información necesaria sobre la base de datos para la conexión
$host = "localhost";
$user = "root";
$pass = "290515";
$bd = "Informacion";

//new mysqli: crea una nueva instancia u objeto de la clase sql que viene integrada en php

$conexion = new mysqli($host, $user, $pass, $bd);
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error){ //conexion es ahora una instancia que puede utilizar los atributos y métodos de la clase sql. connect_error es un atributo que se utiliza para emitir un error
    die("Error de conexión: ". $conexion->connect_error); 
}// die es una funcion, similar a break (py) pero esta recibe un mensaje y detiene toda la ejecución en lugar de salir del bucle o condición y continuar con lo próximo.
//echo "La conexión ha sido satisfactoria!";
// echo, funciona como el print (py) entre otras cosas


if ($_SERVER["REQUEST_METHOD"] == "POST"){ // _SERVER es una variable superglobal que viene integrada en php, funciona como un array (clave => valor) cuyos datos son especificos. REQUEST_METHOD es una clave de este array que tiene como valores _GET, _POST, etc... es un método de solicitud en el que llega una entrada 

    // ==; se utiliza para igualdad es decir 5 == '5' devuelve true pero === se utiliza para identidad es decir tanto el contenido como el tipo debe coincidir para que sea true.

    $nombre = trim($_POST["nombre"]); // _POST es otra vriable superglobal, dice que recibirás una entrada, y le puedes definir las claves y valores.
    $email = trim($_POST["email"]);
    $ocupacion = trim($_POST["ocupacion"]);
    $telefono = trim($_POST["telefono"]);
    $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);

    if (empty($nombre) || empty($email) || empty($ocupacion) || empty($telefono) || empty($fecha_nacimiento)){
        die("Todos los campos son obligatorios.");
    }


                                                                                     // Marcadores de posición
    $sql = "INSERT INTO Personas (nombre, email, ocupacion, telefono, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)";


    $sentencia = $conexion->prepare($sql);
            // tipo de dato, en este caso String (s)
            // se indican el tipo de datos y las variables que recibira esa base de datos preparada para espera recibirlos con marcadores de posición 
    $sentencia->bind_param("sssss", $nombre, $email, $ocupacion, $telefono, $fecha_nacimiento);
    
    
    

    if ($sentencia->execute()){ // -> se utiliza como el . (py) para llamar métodos
        // query es un método de la clase sql incrustada en php que en este caso devuelve true si el insert fue éxitoso por eso se compara con true (bool).
       // echo "Se ha guardado satisfactoriamente un registro.";
    } else {
        echo "Error: ". $sentencia->error;
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
    <script src="validar.js"></script>
</head>

<body>
    <form id="formRegistro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <!-- Creamos un formulario que con action indica la ruta de donde serán enviadas las entradas del formulario, es decir echo imprimie o emite esta ruta a través de htmlspecialchars() esta función protege los datos o página de recibir scripst malisiosos que puedan afectar la seguridad de los usuarios conocidos como XSS (croos-site scripting). La variable superglobal $_SERVER[] tiene como indice "PHP_SELF" esta clave tiene como valor la ruta del archivo actual, luego tenemos el method que a través del atributo post es una forma segura de enviar datos ya que no se guardan ni envian a través de la URL -->
        
        <h1>Formulario de Registro</h1><br>
        <h2>Nombre: </h2><input type="text" name= "nombre" id="name" placeholder="Nombre" class="inputField" >
        <div id="errorNombre" class="error-message"></div><br>

        
        <h2>Email: </h2><input type="email" name="email" id="email" placeholder= "Ej.:hola@gmail.com" id="mail" class="inputField">
        <div id="errorEmail" class="error-message"></div><br>

       
      
        <h2>Ocupación: </h2><input type="text" name="ocupacion" id="ocupacion" placeholder="Ocupación" class="inputField">
        <div id="errorOcupacion" class="error-message" ></div><br>
       

        <h2>Teléfono: </h2><input type="text" name= "telefono" id="tel" placeholder="Teléfono" class="inputField" >
        <div id="errorTelefono" class="error-message"></div><br>


        <h2>Fecha de Nacimiento: </h2><input type="date" name="fecha_nacimiento" id="born" class="inputField">
        <div id="errorBorn" class="error-message"></div><br>

       
        <input type="submit" value="Enviar" id="register" ><br>
        <div id="confirmationMessage" class="confirmation-message"></div>
    </form>
    <div id="resultado"></div>
    
    
</body>
</html>


