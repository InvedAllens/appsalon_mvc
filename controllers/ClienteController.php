<?php 

    namespace Controllers;
    use MVC\Router;

    class ClienteController{

        public static function inicio(Router $router){
            isAuth();
            session_start();
            
            $router->render("cita/index",["nombre"=>$_SESSION['nombre'],"idusuario"=>$_SESSION['id']]);
        }
    }