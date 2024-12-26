<?php

    $host= "localhost";
    $user = "root";
    $pass= "";
    $dbname = "agendamentos";

    try{
        $conn = mysqli_connect("127.0.0.1", "root", "aluno", "agendamentos");
        echo"Conexão com banco de dados realizadp com sucesso. ";
    }catch(mysqli_sql_exception $err){
        echo "Erro: conexão com banco de dados não realizada com sucesso. Erro gerado". $err->getMessage();
    }


?>