<?php 
    require 'funciones.php';
    require 'database.php';
    require __DIR__.'/../vendor/autoload.php';
    use Model\ActiveRecord;
    $db=conexionDataBase();
   $db->set_charset('utf8');
  //pasa la conexion de la base de datos atraves del metodo estatico de la clase propiedad
    ActiveRecord::setDb($db);
