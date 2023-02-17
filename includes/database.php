<?php
    
    function conexionDataBase() : mysqli{
        $db= new mysqli('localhost','root','monchito','appsalon_mvc');
        if(!$db){
            echo 'Error no se pudo conectar a MySQL';
            echo 'Errno de depuracion'. mysqli_connect_errno();
            echo 'Error de depuracion'. mysqli_connect_errno();
            exit;
        }
        return $db;
    }