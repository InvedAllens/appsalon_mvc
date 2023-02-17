<?php 
    namespace Controllers;
    use MVC\Router;
    use Model\Servicio;

    class ServicioController{
        public static function index(Router $router){
            session_start();
            $servicios=Servicio::all();

            $router->render("servicios/index",["nombre"=>$_SESSION['nombre'],"servicios"=>$servicios]);
        }
        public static function crear(Router $router){
            session_start();
            isAdmin();
            $servicio= new Servicio;
            $alertas=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $servicio->sincronizar($_POST);
                $servicio->validar();
                $alertas=Servicio::getAlertas();
                if(empty($alertas)){
                    $servicio->guardar();
                    header('Location:/admin');
                    $alertas=Servicio::setAlerta("exito","Servicio Creado Correctamente");
                }

            }
            $alertas=Servicio::getAlertas();
            $router->render("servicios/crear",["nombre"=>$_SESSION['nombre'],
                                                "alertas"=>$alertas,
                                                "servicio"=>$servicio
                                                ]);
        }
        public static function actualizar(Router $router){
            // session_start();
            isAdmin();
            $idservicio=$_GET['id'];
            if(!is_numeric($idservicio)){
                header('Location:/servicios');
            }
            $servicio=Servicio::find($idservicio);
            $alertas=[];

            if($_SERVER['REQUEST_METHOD']==='POST'){
                $servicio->sincronizar($_POST);
                $servicio->validar();
                $alertas=Servicio::getAlertas();
                if(empty($alertas)){
                    $servicio->actualizar();
                    header('Location:/servicios');
                }
                
            }
            $router->render("servicios/actualizar",["nombre"=>$_SESSION['nombre'],
                                                    "servicio"=>$servicio,
                                                    "alertas"=>$alertas
                                                    ]);
        }
        public static function eliminar(){
            isAdmin();
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $idservicio=$_POST['idservicio'];
                if(!is_numeric($idservicio)){
                    header('Location:/servicios');
                }
                $servicio=Servicio::find($idservicio);
                $servicio->eliminar();
                header('Location:/servicios');
            }
            
        }
    }