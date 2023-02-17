<?php
    define('CARPETA_IMAGENES',$_SERVER['DOCUMENT_ROOT'].'/imagenes/');

    function debugear($variable){
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        exit;
    }
    function debugear2($variable){
        echo $variable;
        
        exit;
    }
    //Escapa el html (agrega seguridad de inyecciones en los inputs de los formularios)
    function s($html):string{
        $s=htmlspecialchars($html);
        return $s;
    }

    function isAuth():void{
        if(!isset($_SESSION['login'])){
            header('Location:/login');
        }
    }
    function isAdmin():void{
        if(!isset($_SESSION['admin'])){
            header('Location:/login');
        }
    }
