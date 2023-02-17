<?php
    
    function conexionDataBase() : mysqli{
        $db= new mysqli($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASS'],$_ENV['DB_BD']);
        if(!$db){
            echo 'Error no se pudo conectar a MySQL';
            echo 'Errno de depuracion'. mysqli_connect_errno();
            echo 'Error de depuracion'. mysqli_connect_errno();
            exit;
        }
        return $db;
    }