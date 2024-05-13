<?php

 if(isset($_POST["iduser"])){
    $iduser = $_POST["iduser"];

    echo $iduser;

    $user = "anastacio";
    $servidor = "localhost";
    $passw = "123";
    $database ="reserva";
   
    //Conexion a la base de datos
    $conexion=mysqli_connect($servidor,$user, $passw, $database);

    if ($conexion) {
        //Create a prepared statement
        $stmt = mysqli_prepare($conexion, "INSERT INTO people(users) VALUES (?)");

        if ($stmt) {
            //Bind the user input to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $iduser);

            //Execute the prepared statement
            mysqli_stmt_execute($stmt);
        } 
    }
 }
?>