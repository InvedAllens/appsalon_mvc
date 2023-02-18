<?php 
    namespace MVC;

    class Router{
        public $rutasGET=[];
        public $rutasPOST=[];
        protected $rutasProtegidas=['/admin','/servicios/crear','/servicios/actualizar','/servicios/eliminar',
                                    '/servicios',
                                ];
        
        //establece una funcion para una url (esto para un metodo get/cargar pagina )
        public function get($url,$fn){
            $this->rutasGET[$url]=$fn;
        }
        public function post($url,$fn){
            $this->rutasPOST[$url]=$fn;
        }
        //ejecuta las funciones dependiendo la url y el metodo asociado
        public function comprobarRutas(){
            session_start();
            $autenticado=$_SESSION['login'] ?? null;
            $fn=null;
            //se obtienen los parametros de url y metodoatraves del server 
            $urlActual=$_SERVER['PATH_INFO']=='' ? '/login' : $_SERVER['PATH_INFO'];// REQUEST_URI === '' ? '/login' : $_SERVER['REQUEST_URI']; PATH_INFO
            $metodo=$_SERVER['REQUEST_METHOD'];
            // debugear($_SERVER['REQUEST_METHOD']);
            if(in_array($urlActual,$this->rutasProtegidas) && !$autenticado){
                header('Location:/login');
            }

            //solo si es un metodo get, se obtiene la funcion del arreglo para ejecutarlo posteriormente
            if($metodo==='GET'){
                
                $fn=$this->rutasGET[$urlActual] ?? null;
            }elseif($metodo==='POST'){
                $fn=$this->rutasPOST[$urlActual] ?? null;
            }
            //  debugear($fn);
            //si existe la url se utiliza un callback a la funcion asosciada a la url y metodo
            if($fn){
                call_user_func($fn,$this);
            }else{
                echo 'pagina no encontrada';
            }
        }
        public function render($view,$datos){
            foreach($datos as $key=>$value):
                $$key=$value;
            endforeach;
            ob_start();
            include_once __DIR__."/views/$view.php";
            $contenido=ob_get_clean();
            include_once __DIR__.'/views/layout.php';
            
        }
    }
