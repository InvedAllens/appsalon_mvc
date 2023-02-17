<?php 
    namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;
    
    class LoginController{
        public static function login(Router $router){
            $alertas=[];

            if($_SERVER["REQUEST_METHOD"]==='POST'){

                $auth= new Usuario($_POST);
                $auth->validarLogin();
                $alertas=Usuario::getAlertas();
                if(empty($alertas)){
                    $usuario=Usuario::where('email',$auth->email);
                    if($usuario){
                        //verificamos password y confirmado
                        if($usuario->validarPasswordYConfirmado($auth->password)){
                            //autenticar usuario
                            session_start();
                            //el suario es el que tiene los datos completos, auth solo tenia el email y password 
                            $_SESSION['id']=$usuario->idusuario;
                            $_SESSION['nombre']=$usuario->nombre." ".$usuario->apellido;
                            $_SESSION['email']=$usuario->email;
                            $_SESSION['login']=true;
                            //aqui si tengo que utlizar la instancia de usuario que ya trae mas datos del usurio (admin)
                            if($usuario->admin==='1'){
                                $_SESSION['admin']=$usuario->admin;
                                header('Location:/admin');
                            }else{
                                header('Location:/citas');
                            }

                        }
    

                    }else{
                        Usuario::setAlerta('error','El usuario no existe');
                    }
                    $alertas=Usuario::getAlertas();
                }

            }

            $router->render("/auth/login",["alertas"=>$alertas]);
            // echo "desde login";
        }
        public static function logout(){
            session_start();
            $_SESSION=[];
            header('Location:/login');
            
        }
        public static function olvide(Router $router){
            $alertas=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $auth=new Usuario($_POST);
                $auth->validarEmail();
                $alertas=Usuario::getAlertas();
                if(empty($alertas)){
                    $usuario=Usuario::where('email',$auth->email);
                    //si existe el usuario y esta confirmado 
                    if($usuario && $usuario->confirmado==='1'){
                        $usuario->crearToken();
                        $usuario->actualizar();
                        $email=new Email($usuario->email,$usuario->nombre,$usuario->token);
                        $email->enviarRecuperar();
                        Usuario::setAlerta('exito','Revisa tu Email');
                    }else{
                        Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                        
                    }
                }
            }
            $alertas=Usuario::getAlertas();

            $router->render("auth/olvide-password",["alertas"=>$alertas]);
        }
        public static function recuperar(Router $router){
            $alertas=[];
            $error=false;
            $token=s($_GET['token']);
            $usuario=Usuario::where('token',$token);
            //si no hay usuario bloquear el form con error=true y agrega la alerta token no valido
            if(!$usuario){
                Usuario::setAlerta('error','El Token no es valido');
                $error=true;
            }
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $auth=new Usuario($_POST);
                $auth->validarPassword();
                $alertas=Usuario::getAlertas();
                if(empty($alertas)){
                    //si es correcta la contraseña hay que actualizarla
                    
                    $usuario->password=$auth->password;
                    $usuario->hashPassword();
                    $usuario->token=null;
                    $resultado=$usuario->actualizar();
                    if($resultado){
                        header('Location:/login');
                    }

                }

            }
            
            $alertas=Usuario::getAlertas();
            $router->render("auth/recuperar",["alertas"=>$alertas,"error"=>$error]);
            
        }
        public static function crearCuenta(Router $router){
            $usuario=new Usuario();
            if($_SERVER['REQUEST_METHOD']==='POST'){
                // debugear($_POST);
                $usuario->sincronizar($_POST);
                $usuario->validarCuentaNueva();
                $alertas=Usuario::getAlertas();
                if(empty($alertas)){
                    //validar si el usuario existe
                    $resultado=$usuario->existeUsuario();
                    if($resultado->num_rows>0){
                        $alertas=Usuario::getAlertas();
                    }else{
                        $usuario->hashPassword();
                        $usuario->crearToken();
                        //debugear($usuario);
                        $email=new Email($usuario->email,$usuario->nombre,$usuario->token);
                        $email->enviarConfirmacion();
                        $usuario->guardar();
                        
                        header('Location:/mensaje');
                        //debugear($usuario);
                    }

                }
            }
            $router->render("auth/registrarse",["usuario"=>$usuario,"alertas"=>$alertas]);
            
        }
        public static function mensaje(Router $router){
            $router->render("/auth/mensaje",[]);
        }

        public static function confirmar(Router $router){
            $alertas=[];
            $token=$_GET['token'];
            $usuario=Usuario::where('token',$token);
            if(empty($usuario)){
                Usuario::setAlerta('error','Token no valido');
            }else{
                $usuario->confirmado=1;
                $usuario->token=null;
                $usuario->actualizar();
                Usuario::setAlerta('exito','Cuenta Comprobada correctamente');
            }
            
            $alertas=Usuario::getAlertas();
            $router->render("auth/confirmar-cuenta",["alertas"=>$alertas]);
        }

    }