<?php 
    namespace Model;
    class AdminCita extends ActiveRecord{
        protected static $tabla='citasservicios';
        protected static $columnasDb=['idcita','hora','cliente','email','telefono','servicio','precio'];
        public $idcita;
        public $hora;
        public $cliente;
        public $email;
        public $telefono;
        public $servicio;
        public $precio;

        public function __construct($args=[])
        {
            $this->idcita=$args['idcita'] ?? null;
            $this->hora=$args['hora'] ?? '';
            $this->cliente=$args['cliente'] ?? '';
            $this->email=$args['email'] ?? '';
            $this->telefono=$args['telefono'] ?? '';
            $this->servicio=$args['servicio'] ?? '';
            $this->precio=$args['precio'] ?? '';
        }

    }