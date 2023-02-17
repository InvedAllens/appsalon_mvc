<?php 
    namespace Controllers;

use Exception;
use Model\AdminCita;
use Model\servicio;
    use Model\Cita;
use Model\CitaServicio;

    class APIController{
        public static function index(){
            $servicios=Servicio::all();
            echo json_encode($servicios);
            
        }
        public static function guardar(){

            $serviciosId=$_POST['servicios'];
            $idservicios=explode(",",$serviciosId);
            $cita=new Cita($_POST);
            $i=0;
            // try {
                $respuesta=$cita->guardar();
                foreach($idservicios as $servicioId){
                    $citaServicio=new CitaServicio(["citaId"=>strval($respuesta['id']),"servicioId"=>$servicioId]);
                    $respuestacys[$i]=$citaServicio->guardar();
                    $i++;
                }
            //} catch(Exception $error){
              //  new Exception("No se pudo guardar la cita");

            //}
            //$error->getMessage()
            $mensaje=["estado"=>'todo ok',
            "saludo"=>'hola desde el servidor',
            "datos"=>$cita,
            "guardado"=>$respuesta['guardado'] ?? '',
            "citas y sevicios"=>$citaServicio];
            
            echo json_encode($mensaje);
        }
        public static function borrar(){
            //  debugear($_POST);
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $cita=Cita::find($_POST['idcita']);
                if($cita){
                    $cita->eliminar();
                    header('Location:'.$_SERVER['HTTP_REFERER']);
                }
            }
        } 
    }