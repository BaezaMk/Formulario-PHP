<?php
$nombre = $_POST['nombre'];
$contraseña = $_POST['password'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$materia = $_POST['materia'];
$telefono = $_POST['telefono'];

if (
    !empty($nombre) || !empty($contraseña) || !empty($genero) ||
    !empty($email) || !empty($materia) || !empty($telefono)
) {
    $host = "localhost";
    $dbusername =  "root";
    $bdpassword = "";
    $dbname = "estudiante";

    $conn =  new mysqli($host, $dbusername, $bdpassword, $dbname);
    if (mysqli_connect_error()) {
        die('connect error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = " SELECT  telefono from usuario where telefono  = ? limit 1 "; //dato que no se va a repetir en este caso telefono
        $INSERT = " INSERT INTO usuario (nombre,password,genero,email,materia,telefono)values(?,?,?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("i", $telefono);
        $stmt->execute();
        $stmt->bind_result($telefono);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssssi", $nombre, $contraseña, $genero, $email, $materia, $telefono);
            $stmt->execute();
            echo "El registro fue completado exitosamente";
        } else {
            echo "El numero añadido ya esta registrado";
            $stmt->close();
            $conn->close();
        }
    }
} else {
    echo "Debe de rellenar todos los apartados";
    die();
}
