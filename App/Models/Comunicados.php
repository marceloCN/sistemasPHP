<?php

namespace App\Models;

//es obligatorio usar la tabla models y extenderlo como tambien el PDO
use lib\Models;
use PDO;

class Funcionario extends Models
{
    function __construct()
    {
        parent::__construct();
        $this->tablaBD = 'funcionario';
        $this->param['ci'] = PDO::PARAM_STR;
        $this->long['ci'] = 20;
        $this->param['nombre'] = PDO::PARAM_STR;
        $this->long['nombre'] = 200;
        $this->param['cargo'] = PDO::PARAM_STR;
        $this->long['cargo'] = 255;
        $this->param['ci_respaldo'] = PDO::PARAM_STR;
        $this->long['ci_respaldo'] = 20;
        $this->param['id_tipo'] = PDO::PARAM_STR;
        $this->long['id_tipo'] = 0;
    }
}
