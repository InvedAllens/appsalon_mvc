<?php 
    namespace Model;
    
    class CitaServicio extends ActiveRecord{
        protected static $tabla='citasservicios';
        protected static $columnasDb=['idCS','citaId','servicioId'];
        public $idCS;
        public $citaId;
        public $servicioId;

        public function __construct($args=[]){
            $this->idCS=$args['idCS'] ?? null;
            $this->citaId=$args['citaId'] ?? '';
            $this->servicioId=$args['servicioId'] ?? '';
        }

    }