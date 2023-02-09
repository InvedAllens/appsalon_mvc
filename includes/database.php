<?php
    
    function conexionDataBase() : mysqli{
        $db= new mysqli('localhost','root','monchito','bienesraices_crud');
        if(!$db){
            echo 'se conecto';
            exit;
        }
        return $db;
    }