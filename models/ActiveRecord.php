<?php 
    
    namespace Model;

    class ActiveRecord{

        protected static $db;
        protected static $columnasDb=[];
        protected static $alertas=[];
        protected static $tabla='';
       
        //public $imagen;
        
        
        public function guardar(){
            //sanitizar datos
            $sanitizados=$this->sanitizar();
            
            //consulta a la base de datos
            $query="INSERT INTO ".static::$tabla." (";
            // join convierte a string el array, el pimer parametro es la separacion el segundo el array
            // array_keys solo obtiene las llaves y son almacenadas en un arreglo
            //al final el $query.= concatena lo que habia en el $query previamente
            $query.=join(",",array_keys($sanitizados));
            $query.=") VALUES ('";
            $query.=join("','",array_values($sanitizados));
            $query.="')";

            // $query="INSERT INTO propiedades o vendedores (titulo,precio,imagen,descripcion,habitaciones,wc,estacionamiento,creado,vendedores_idvendedor) 
            // VALUES('$this->titulo','$this->precio','$this->imagen','$this->descripcion','$this->habitaciones','$this->wc','$this->estacionamiento'
            // ,'$this->creado','$this->vendedores_idvendedor')";

            //primero accedemos a la propiedad estatica, que ya ha sido establecida desde app.php con el metodo publico estatico
            //setDb, se le asigno la conexion o un objeto de la clase mysqli con las credenciales de la conexion(base de datos, usuario etc.)
            $resultado['guardado']=self::$db->query($query);
            $resultado['id']=self::$db->insert_id;;
            return $resultado;
        }
        public function eliminar(){
            if(static::$tabla==='usuarios'){
                $idtabla="idusuario";
            }elseif(static::$tabla==='citas'){
                $idtabla="idcita";
            }elseif(static::$tabla==='citasservicios'){
                $idtabla="idcita";
            }elseif(static::$tabla==='servicios'){
                $idtabla="idservicio";
            }
            $id=self::$db->escape_string($this->$idtabla);
            $consultaEliminar="DELETE FROM ".static::$tabla." WHERE ".$idtabla."=$id";
            $resultado=self::$db->query($consultaEliminar);
            //DESCOMENTAR PARA IMAGENES
            // if(isset($this->$idtabla)){
            //     $existeArchivo=file_exists(CARPETA_IMAGENES.$this->imagen);
            //     // debugear($existeArchivo);
            //     if($existeArchivo){
            //         unlink(CARPETA_IMAGENES.$this->imagen);
            //     }
            // }

            if($resultado){
                header('Location:/admin?resultado=3');
            }


        }
    //funcion estatica publica para establecer la conexion con la base de ddtos, en este proyecto es establecida 
    //desde app.php 
        public static function setDb($database){
            self::$db=$database;
        }
     //funcion para copiar las propiedades del objeto en un array(propiedad y valor), se utilizara para otras funciones como sanitizar
        public function atributos(){
            if(static::$tabla==='usuarios'){
                $idtabla="idusuario";
            }elseif(static::$tabla==='citas'){
                $idtabla="idcita";
            }elseif(static::$tabla==='citasservicios'){
                $idtabla="idCS";
            }elseif(static::$tabla==='servicios'){
                $idtabla='idservicio';
            }

            $atributos=[];
            foreach(static::$columnasDb as $columna):
                if($columna===$idtabla){continue;}
                $atributos[$columna]=$this->$columna;
            endforeach;
            return $atributos;
        }
    //funcion que sanitiza los string para evitar inyecciones sql(escapa todos los caracteres que podrian afectar una sentencia sql)
        public function sanitizar(){
            $sanitizados=[];
            foreach($this->atributos() as $key=>$value):
                $sanitizados[$key]=self::$db->escape_string($value);
            endforeach;
            return $sanitizados;
        }
    //establece alertas
    public static function setAlerta($tipo,$mensaje){
        static::$alertas[$tipo][]=$mensaje;
    }
    //funcion para obtener los errores
        public static function getAlertas(){
           return static::$alertas;
        }
    //funcion para validar los valores de los atributos del objeto
        public function validar(){
           static::$alertas=[];
                
        }
    //asigna una imagen(nombre imagen) al atributo imagen

    //-------DESCOMENTAR PARA IMAGENES------
        // public function setImagen($imagen){
        //     if(static::$tabla==='propiedades'){
        //         $idtabla="idpropiedad";
        //     }elseif(static::$tabla==='vendedores'){
        //         $idtabla="idvendedor";
        //     }
        //     //para actualizar se verifica si existe un hay id en la instancia, deberia haberla
        //     if(!is_null($this->$idtabla)){
        //         $existeArchivo=file_exists(__DIR__.'/../imagenes/'.$this->imagen);
        //         // debugear($existeArchivo);
        //         if($existeArchivo){
        //             unlink(__DIR__.'/../imagenes/'.$this->imagen);
        //         }
        //     }

        //     if($imagen){
        //         $this->imagen=$imagen;
        //     }
        // }
    //funcion estatica para obtener todos los registros de propiedadades
        public static function all(){
            $query="SELECT * FROM ".static::$tabla;
            $resultado=self::consultaSQL($query);
            return $resultado;
        }
    //funcion estatica para obtener un numero determinado de propiedadades
        public static function get($cantidad){
            $query="SELECT * FROM ".static::$tabla." LIMIT ".$cantidad;
            $resultado=self::consultaSQL($query);
            return $resultado;
        }
     //funcion estatica y protected para consultar en la base de datos
        protected static function consultaSQL($query){
            $resConsulta=self::$db->query($query);
            $array=[];
            while($registro=$resConsulta->fetch_assoc()):
                //debugear($registro);
                $array[]=static::crearObjeto($registro);
            endwhile;
            //liberar memoria
            $resConsulta->free();

            return $array;
            
        }
        //convierte un arreglo en un objeto 
        protected static function crearObjeto($array){
            $instancia=new static;
            foreach($array as $key=>$value):
                if(property_exists($instancia,$key)):
                    $instancia->$key=$value;
                endif;
            endforeach;
            return $instancia;
        }

        public static function find($id){
            if(static::$tabla==='usuarios'){
                $idtabla="idusuario";
            }elseif(static::$tabla==='citas'){
                $idtabla="idcita";
            }elseif(static::$tabla==='citasservicios'){
                $idtabla="idcita";
            }elseif(static::$tabla==='servicios'){
                $idtabla="idservicio";
            }
           $query="SELECT * FROM ".static::$tabla." WHERE ".$idtabla."=$id";
           $resultado=self::consultaSQL($query);
           return  current($resultado);            
        }
        //funcion para encontrar todo un resgistro en funcion de su campo y valor
        public static function where($campo,$valor){
            if(static::$tabla==='usuarios'){
                $idtabla="idusuario";
            }elseif(static::$tabla==='citas'){
                $idtabla="idcita";
            }
           $query="SELECT * FROM ".static::$tabla." WHERE ".$campo."='".$valor."' LIMIT 1";
           //debugear($query);
           $resultado=self::consultaSQL($query);
           return  current($resultado);            
        }

        //funcion para una consulta general a la base de datos
        public static function SQL($query){
            $resultado=self::consultaSQL($query);
            return $resultado;
        }

        public function sincronizar($args){
            foreach($args as $key=>$value):
                if(property_exists($this,$key) && !is_null($value)):
                    $this->$key=self::$db->escape_string($value);
                endif;
            endforeach;
            return $this;
        }
        public function actualizar(){
            if(static::$tabla==='usuarios'){
                $idtabla="idusuario";
            }elseif(static::$tabla==='citas'){
                $idtabla="idcita";
            }elseif(static::$tabla==='citasservicios'){
                $idtabla="idCS";
            }elseif(static::$tabla==='servicios'){
                $idtabla='idservicio';
            }
            //primero hay que sanitizar los datos denuevo
            $sanitizados=$this->sanitizar();
            $valoresSet=[];
            foreach($sanitizados as $key=>$value):
                $valoresSet[]="$key='$value'";
            endforeach;
            //debugear($valoresSet);
            $query="UPDATE ".static::$tabla." SET ";
            $query.=join(",",$valoresSet);
            $query.=" WHERE ".$idtabla."='".self::$db->escape_string($this->$idtabla)."'";
            $query.=" LIMIT 1";
            $resultado=self::$db->query($query);            
            return $resultado;
            //debugear($query);
            // $query= titulo='$this->titulo',precio='$this->precio',imagen='$this->imagen',descripcion='$this->descripcion'
            // ,habitaciones=$this->habitaciones,wc=$this->wc,estacionamiento=$this->estacionamiento,vendedores_idvendedor='$this->vendedores_idvendedor' 
            // WHERE idpropiedad=$propiedadId";
    }
    }