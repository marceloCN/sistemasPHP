<?php

namespace App\Models;

//es obligatorio usar la tabla models y extenderlo como tambien el PDO
use lib\Models;
use PDO;

class Usuarios extends Models
{
    public function __construct()
    {
        parent::__construct();
        $this->tablaBD = 'usuarios';
        $this->param['id'] = PDO::PARAM_STR;
        $this->long['id'] = 0;
        $this->param['ci'] = PDO::PARAM_STR;
        $this->long['ci'] = 20;
        $this->param['emitido'] = PDO::PARAM_STR;
        $this->long['emitido'] = 3;
        $this->param['nombres'] = PDO::PARAM_STR;
        $this->long['nombres'] = 200;
        $this->param['fecha_nac'] = PDO::PARAM_STR;
        $this->long['fecha_nac'] = 20;
        $this->param['sexo'] = PDO::PARAM_STR;
        $this->long['sexo'] = 1;
        $this->param['direccion'] = PDO::PARAM_STR;
        $this->long['direccion'] = 300;
        $this->param['nro_celular'] = PDO::PARAM_STR;
        $this->long['nro_celular'] = 10;
        $this->param['email'] = PDO::PARAM_STR;
        $this->long['email'] = 60;
        $this->param['usuario'] = PDO::PARAM_STR;
        $this->long['usuario'] = 20;
        $this->param['clave'] = PDO::PARAM_STR;
        $this->long['clave'] = 20;
        $this->param['id_rol'] = PDO::PARAM_STR;
        $this->long['id_rol'] = 0;
        $this->param['id_direccion'] = PDO::PARAM_STR;
        $this->long['id_direccion'] = 0;
        $this->param['id_cargo'] = PDO::PARAM_STR;
        $this->long['id_cargo'] = 0;
        $this->param['estado'] = PDO::PARAM_STR;
        $this->long['estado'] = 2;
        $this->param['rrhh'] = PDO::PARAM_STR;
        $this->long['rrhh'] = 1;
        $this->param['if_rrhh'] = PDO::PARAM_STR;
        $this->long['if_rrhh'] = 2;
        $this->param['if_director'] = PDO::PARAM_STR;
        $this->long['if_director'] = 2;
    }
}
