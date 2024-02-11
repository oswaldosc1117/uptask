<?php

namespace Models;

use Models\ActiveRecord;

class Proyecto extends ActiveRecord{
    
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioID'];

    public $id;
    public $proyecto;
    public $url;
    public $propietarioID;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioID = $args['propietarioID'] ?? '';
    }


    public function validarProyecto(){
        
        if(!$this->proyecto){
            self::$alertas['error'][] = 'Debes definir el Nombre del Proyecto';
        }

        return self::$alertas;
    }
}