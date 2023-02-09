<?php

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
