<?php 
    namespace Controllers;

use Model\AdminCita;
use MVC\Router;

    class AdminController{

        public static function inicio(Router $router){
            isAdmin();
            session_start();
            // debugear($_GET);
            
            $fechaSeleccionada=$_GET['fecha'] ?? date('Y-m-d');
            $fechaArreglo=explode("-",$fechaSeleccionada);
            
             if(checkdate($fechaArreglo[1],$fechaArreglo[2],$fechaArreglo[0])){
                 $fecha= $fechaSeleccionada;
             }else{
                $fecha=date('Y-m-d');
             }
        
            
            $consulta = "SELECT citas.idcita, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
            $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
            $consulta .= " FROM citas  ";
            $consulta .= " LEFT OUTER JOIN usuarios ";
            $consulta .= " ON citas.usuarioId=usuarios.idusuario  ";
            $consulta .= " LEFT OUTER JOIN citasServicios ";
            $consulta .= " ON citasServicios.citaId=citas.idcita ";
            $consulta .= " LEFT OUTER JOIN servicios ";
            $consulta .= " ON servicios.idservicio=citasServicios.servicioId ";
            $consulta .= " WHERE fecha =  '$fecha' ";
            $citas= AdminCita::SQL($consulta);
            // debugear($citas);
            
    
            $router->render('admin/index',["nombre"=>$_SESSION['nombre'],"citas"=>$citas,"fecha"=>$fecha]);
        }
    }