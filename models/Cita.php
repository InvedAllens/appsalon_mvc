<?php 
    namespace Model;
    class Cita extends ActiveRecord{
        protected static $tabla='citas';
        protected static $columnasDb=['idcita','fecha','hora','usuarioId'];
        public $idcita;
        public $fecha;
        public $hora;
        public $usuarioId;

        public function __construct($args=[]){
            $this->idcita=$args['idcita'] ?? null;
            $this->fecha=$args['fecha'] ?? '';
            $this->hora=$args['hora'] ?? '';
            $this->usuarioId=$args['usuarioId'] ?? null;
        }
       
    }
