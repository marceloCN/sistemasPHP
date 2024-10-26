<?php

namespace App\Models;
//es obligatorio usar la tabla models y extenderlo como tambien el PDO
use lib\Models;
use PDO;

class Cargos extends Models
{
    function __construct()
    {
        parent::__construct();
        $this->tablaBD = 'cargos';
        $this->param['id'] = PDO::PARAM_STR;
        $this->long['id'] = 0;
        $this->param['descripcion'] = PDO::PARAM_STR;
        $this->long['descripcion'] = 100;
        $this->param['estado'] = PDO::PARAM_STR;
        $this->long['estado'] = 2;
    }
}
