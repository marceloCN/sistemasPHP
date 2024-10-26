<?php

namespace App\Models;

//es obligatorio usar la tabla models y extenderlo como tambien el PDO
use lib\Models;
use PDO;

class Correspondencia extends Models
{
    function __construct()
    {
        parent::__construct();
        $this->tablaBD = 'correspondencia';
        $this->param['id'] = PDO::PARAM_STR;
        $this->long['id'] = 0;
        $this->param['fecha_ingreso'] = PDO::PARAM_STR;
        $this->long['fecha_ingreso'] = 100;
        $this->param['id_usuario'] = PDO::PARAM_STR;
        $this->long['id_usuario'] = 0;
        $this->param['id_direccion_registro'] = PDO::PARAM_STR;
        $this->long['id_direccion_registro'] = 0;
        $this->param['id_direccion_destinatario'] = PDO::PARAM_STR;
        $this->long['id_direccion_destinatario'] = 0;
        $this->param['id_direccion_revision'] = PDO::PARAM_STR;
        $this->long['id_direccion_revision'] = 0;
        $this->param['id_personal_revision'] = PDO::PARAM_STR;
        $this->long['id_personal_revision'] = 0;
        $this->param['id_via_usuario'] = PDO::PARAM_STR;
        $this->long['id_via_usuario'] = 0;
        $this->param['id_cargo_via_usuario'] = PDO::PARAM_STR;
        $this->long['id_cargo_via_usuario'] = 0;
        $this->param['id_cargo_via_usuario'] = PDO::PARAM_STR;
        $this->long['id_cargo_via_usuario'] = 0;
        $this->param['id_cargo_remitente'] = PDO::PARAM_STR;
        $this->long['id_cargo_remitente'] = 0;
        $this->param['id_clasificacion'] = PDO::PARAM_STR;
        $this->long['id_clasificacion'] = 0;
        $this->param['referencia'] = PDO::PARAM_STR;
        //$this->long['referencia'] = 400;
        $this->param['remitente'] = PDO::PARAM_STR;
        $this->long['remitente'] = 10000;
        $this->param['tipo'] = PDO::PARAM_STR;
        $this->long['tipo'] = 80;
        $this->param['id_via_usuario'] = PDO::PARAM_STR;
        $this->long['id_via_usuario'] = 0;
        $this->param['id_cargo_via_usuario'] = PDO::PARAM_STR;
        $this->long['id_cargo_via_usuario'] = 0;
        $this->param['file'] = PDO::PARAM_STR;
        $this->long['file'] = 80;
        $this->param['observacion'] = PDO::PARAM_STR;
        //$this->long['observacion'] = 1000;
        $this->param['estado'] = PDO::PARAM_STR;
        $this->long['estado'] = 2;
        $this->param['tramite'] = PDO::PARAM_STR;
        $this->long['tramite'] = 1;
        $this->param['secretaria'] = PDO::PARAM_STR;
        $this->long['secretaria'] = 100;
        $this->param['nombre_secretario'] = PDO::PARAM_STR;
        $this->long['nombre_secretario'] = 180;
        $this->param['validados'] = PDO::PARAM_STR;
        $this->long['validados'] = 2;
    }
}
