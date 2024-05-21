<?php
    //Importar la conexion
    require '../bienesraices/includes/config/database.php';
    $db = conectarDB();

    //Crear un email y un password
    $email = "correo@correo.com";
    $password = "123456";

    $passwoerHash = password_hash($password, PASSWORD_DEFAULT);

    //Consultar la BD
    $query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwoerHash');";
 
    echo $query;

    exit;

    //mysqli_query($db, $query);
?>