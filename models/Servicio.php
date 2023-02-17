<?php 
    namespace Model;

    class Servicio extends ActiveRecord{

        protected static $tabla="servicios";
        protected static $columnasDb=["idservicio","nombre","precio"];
        public $idservicio;
        public $nombre;
        public $precio;

        public function __construct($args=[]){
            $this->idservicio=$args['idservicio'] ?? null;
            $this->nombre=$args['nombre'] ?? '';
            $this->precio=$args['precio'] ?? '';
        }
        public function validar(){
            if(!$this->nombre){
                self::setAlerta("error","El nombre del servicio es obligatorio");
            }
            if(!$this->precio){
                self::setAlerta("error","El precio del servicio es obligatorio");
            }
            if(strlen($this->precio)>=1 && !is_numeric($this->precio)){
                self::setAlerta("error","El precio debe ser tipo numerico");
            }
        }
    }   