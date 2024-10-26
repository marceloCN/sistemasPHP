<?php

namespace App\Models;

//es obligatorio usar la tabla models y extenderlo como tambien el PDO
use lib\Models;
use PDO;
use Exception;

class Validacion extends Models
{
    function __construct()
    {
        parent::__construct();
        $this->tablaBD = 'validacion';
        $this->param['id'] = PDO::PARAM_STR;
        $this->long['id'] = 0;
        $this->param['codigo'] = PDO::PARAM_STR;
        $this->long['codigo'] = 0;
        $this->param['fecha_validacion'] = PDO::PARAM_STR;
        $this->long['fecha_validacion'] = 60;
        $this->param['id_direccion_derivacion'] = PDO::PARAM_STR;
        $this->long['id_direccion_derivacion'] = 0;
        $this->param['id_personal_revision'] = PDO::PARAM_STR;
        $this->long['id_personal_revision'] = 0;
        $this->param['observacion'] = PDO::PARAM_STR;
        //$this->long['observacion'] = 600;
        $this->param['id_clasificacion'] = PDO::PARAM_STR;
        $this->long['id_clasificacion'] = 0;
        $this->param['estado'] = PDO::PARAM_STR;
        $this->long['estado'] = 2;
        $this->param['id_usuario_registro_validacion'] = PDO::PARAM_STR;
        $this->long['id_usuario_registro_validacion'] = 0;
        $this->param['id_direccion_registro_validacion'] = PDO::PARAM_STR;
        $this->long['id_direccion_registro_validacion'] = 0;
    }

    public function listarSolicitudes()
    {
        $query = "SELECT 
                    v.codigo, v.fecha_validacion, 
                    (SELECT referencia from correspondencia where id = v.codigo) as observacion, 
                    (SELECT remitente from correspondencia where id = v.codigo) as remitente, 
                    (SELECT nombres FROM usuarios WHERE id = v.id_usuario_registro_validacion) AS usuario_registrado, 
                    (SELECT descripcion FROM direccion WHERE id = v.id_direccion_registro_validacion) AS direccion_registro, 
                    (SELECT nombres FROM usuarios WHERE id = v.id_personal_revision) AS usuario_revision, 
                    (SELECT CASE WHEN COUNT(*) > 0 THEN 'Respondido' ELSE 'No Respondido' END FROM validacion r WHERE r.id_direccion_registro_validacion = 22 AND r.codigo = v.codigo) AS estado_respuesta 
                  FROM validacion v 
                  WHERE v.id_direccion_derivacion = 22 AND v.estado = 'AC' ORDER BY v.codigo DESC; ";
        $result = $this->byQuery($query);
        return $result;
    }
}
