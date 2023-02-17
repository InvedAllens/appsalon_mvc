<?php 
    namespace Model;

    class Usuario extends ActiveRecord{
        protected static $tabla='usuarios';
        protected static $columnasDb=['idusuario','nombre','apellido','email','password',
                                        'telefono','admin','confirmado','token'];
        public $idusuario;
        public $nombre;
        public $apellido;
        public $email;
        public $password;
        public $telefono;
        public $admin;
        public $confirmado;
        public $token;

        public function __construct($args=[]){
            $this->idusuario=$args['idusuario'] ?? null;
            $this->nombre=$args['nombre'] ?? '';
            $this->apellido=$args['apellido'] ?? '';
            $this->email=$args['email'] ?? '';
            $this->password=$args['password'] ?? '';
            $this->telefono=$args['telefono'] ?? '';
            $this->admin=$args['admin'] ?? '0';
            $this->confirmado=$args['confirmado'] ?? '0';
            $this->token=$args['token'] ?? '';
        }
        
        public function validarCuentaNueva(){
            if(!$this->nombre){
                self::$alertas['error'][]='El nombre es obligatorio';   
            }
            if(!$this->apellido){
                self::$alertas['error'][]='El apellido es obligatorio';   
            }
            if(!$this->telefono){
                self::$alertas['error'][]='El Telefono es obligatorio';   
            }
            if(!$this->email){
                self::$alertas['error'][]='El Email es obligatorio';   
            }
            if(!$this->password || strlen($this->password)<6){
                self::$alertas['error'][]='El Password debe contener almenos 6 caracteres';   
            }
        }
        public function validarLogin(){
            if(!$this->email){
                self::$alertas['error'][]='El Email es Obligatorio';   
            }
            if(!$this->password){
                self::$alertas['error'][]='El Password es Obligatorio';   
            }
        }

        public function existeUsuario(){
            $query="SELECT * FROM ". self::$tabla ." WHERE email='".$this->email."' LIMIT 1";
            $resultado=self::$db->query($query);
            // debugear($resultado);
            if($resultado->num_rows>0){
                self::$alertas['error'][]='El usuario ya existe';
            }
            return $resultado;

        }
        public function hashPassword(){
            $this->password=password_hash($this->password,PASSWORD_BCRYPT);
        }
        public function crearToken(){
            $this->token=uniqid();
        }
        public function validarPasswordYConfirmado($password){
            $matchPassword=password_verify($password,$this->password);
            if(!$matchPassword || !$this->confirmado){
                self::setAlerta('error','El Password es incorrecto o no se ha confirmado la cuenta');
                return false;
            }else{
                //self::setAlerta('exito',"Es correcto el Password y se esta confirmado");
                return true;
            }
        
        }
        public function validarEmail(){
            if(!$this->email){
                self::setAlerta('error','El Email es Obligatorio');
            }
            // $resultado=self::where('email',$this->email);
            // if($resultado){
            //     self::setAlerta('exito','si existe el usuario');
            // }elseif(!$resultado && $this->email){
            //     self::setAlerta('error','No existe el usuario');
            // }
            // return $resultado;
        }
        public function validarPassword(){
            if(!$this->password || strlen($this->password)<6){
                self::$alertas['error'][]='El Password debe contener almenos 6 caracteres';   
            }
        }
    }
