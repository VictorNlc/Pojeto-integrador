<?php

    $host= "localhost";
    $user = "roos";
    $pass= "";
    $dbname = "agendamentos";

    try{
        $conn = new mysqli("mysql:host=$host; dbname=" . $dbname, $user, $pass);
        echo"Conexão com banco de dados realizadp com sucesso. ";
    }catch(mysqli_sql_exception $err){
        echo "Erro: conexão com banco de dados não realizada com sucesso. Erro gerado". $err->getMessage();
    }
?>