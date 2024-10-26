<?php

namespace lib;

use PDO;
use PDOException;
use Exception;

class Models
{

    /*
    $resultado =$users->insert(['nombre' => 'Juan', 'apellido' => 'Cruz de nogales']);
    $resultado = $users->update(['apellido' => 'Nogales Panoso'], ['id' => 56]);
    $users->delete(['id' => 52]);
    $resultado = $users->select(['*'], [], []); //mostrar todos los registros de la tabla
    var_dump($resultado);
    var_dump($users->count("*", [])); //contar todos los elementos de la tabla
            
    */
    protected $database;
    protected $query;
    protected $param = [];
    protected $long = [];

    protected $tablaBD;
    protected $vistaBD;

    public function nuevaConnection($host, $user, $pwd, $charset)
    {
        $this->database->setConnection($host, $user, $pwd, $charset);
    }

    public function __construct($database = null)
    {
        if ($database !== null) {
            $this->database = $database;
        } else {
            $this->database = new Database();
        }
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    private function getConnection()
    {
        return $this->database->connect();
    }

    public function ejecutarConfiguracion($config)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        return $database->exec($config);
    }


    //hace un select, insert, update y delete, solo el select retorna datos en forma de array
    public function byQuery($query)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $stmt = $database->prepare($query);

        if (stristr(strtoupper($query), 'SELECT') === FALSE) {
            return $stmt->execute();
        } else {
            $stmt->execute();
            if ($stmt->rowCount() > 1)
                while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result[] = $res;
                }
            else
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    //ejecuta un select
    public function select($targets, $filtros, $orderby)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $selects = '';
        foreach ($targets as $sel) {
            $selects .= $selects == '' ? $sel : ',' . $sel;
        }
        $where = '';
        foreach ($filtros as $key => $value) {
            $where = $where == '' ? ' WHERE ' : $where . ' and ';
            $where .= $key . '=:' . $key;
        }
        $order = '';
        foreach ($orderby as $orde) {
            $order = $order == '' ? ' order by ' : $order . ", ";
            $order .= $orde;
        }
        $query = "SELECT " . $selects . " FROM " . $this->tablaBD . $where . $order;
        $stmt = $database->prepare($query);
        foreach ($filtros as $key => $value) {
            $valor = ($this->long[$key] > 0 ? (strlen($value) > $this->long[$key] ? null : $value) : $value);
            $stmt->bindvalue(':' . $key, $valor, $this->param[$key]);
        }
        $stmt->execute();
        if ($stmt->rowCount() > 1)
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $res;
            }
        else
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //ejecuta un insert
    public function insert($data, $column = 'id')
    {
        $fields = '';
        $values = '';
        foreach ($data as $key => $value) {
            $fields = $fields == '' ? $key : $fields . ',' . $key;
            $values = $values == '' ? ':' . $key : $values . ',:' . $key;
        }
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $query  =   'INSERT INTO ' . $this->tablaBD . '(' . $fields . ') values (' . $values . ')';
        $stmt   =   $database->prepare($query);

        foreach ($data as $key => $value) {
            $valor = ($this->long[$key] > 0 ? (strlen($value) > $this->long[$key] ? null : $value) : $value);
            $stmt->bindvalue(':' . $key, $valor, $this->param[$key]);
        }
        $success = $stmt->execute();
        if ($success) {
            // Obtener el ID del nuevo registro insertado
            $id = $database->lastInsertId($column);
            // Obtener el objeto insertado
            $insertedObject = $this->getObjectById($id, $column);
            return $insertedObject;
        } else {
            return false; // Si falla la inserción
        }
    }

    // por si el insert lleva una llave compuesta, es decir 2 o mas primary key
    public function insert2($data)
    {
        $fields = '';
        $values = '';
        foreach ($data as $key => $value) {
            $fields .= ($fields == '' ? '' : ',') . $key;
            $values .= ($values == '' ? '' : ',') . ':' . $key;
        }
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $query = 'INSERT INTO ' . $this->tablaBD . '(' . $fields . ') VALUES (' . $values . ')';
        $stmt = $database->prepare($query);

        foreach ($data as $key => $value) {
            // Verificar si la clave existe antes de acceder a ella
            if (array_key_exists($key, $this->long) && array_key_exists($key, $this->param)) {
                $valor = ($this->long[$key] > 0 ? (strlen($value) > $this->long[$key] ? null : $value) : $value);
                $stmt->bindvalue(':' . $key, $valor, $this->param[$key]);
            }
        }

        $success = $stmt->execute();
        if ($success) {
            // No podemos obtener el ID de un registro cuando la clave primaria es compuesta
            // Retornamos true para indicar que la inserción fue exitosa
            return true;
        } else {
            return false; // Si falla la inserción
        }
    }



    //--------------------------------------------------------------  ahora, un update
    public function update($params, $filtros)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $sets = '';
        foreach ($params as $key => $value) {
            $sets .= $sets == '' ? $key . '=:' . $key : ', ' . $key . '=:' . $key;
        }

        $where = '';
        foreach ($filtros as $key => $value) {
            $where .= $where == '' ? ' WHERE ' . $key . '=:' . $key : ' AND ' . $key . '=:' . $key;
        }

        $query = "UPDATE " . $this->tablaBD . " SET " . $sets . $where;
        $stmt = $database->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        foreach ($filtros as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $success = $stmt->execute();
        if ($success) {
            // Obtener el objeto actualizado
            $updatedObject = $this->getObjectByFilters($filtros);
            return $updatedObject;
        } else {
            return false; // Si falla la actualización
        }
    }

    //--------------------------------------------------------------- delete from where
    public function delete($filtros)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $where = '';
        foreach ($filtros as $key => $value) {
            $where .= $where == '' ? ' WHERE ' . $key . '=:' . $key : ' and ' . $key . '=:' . $key;
        }
        $query = "DELETE FROM " . $this->tablaBD . $where;
        $stmt = $database->prepare($query);
        foreach ($filtros as $key => $value) {
            $valor = ($this->long[$key] > 0 ? (strlen($value) > $this->long[$key] ? null : $value) : $value);
            $stmt->bindvalue(':' . $key, $valor, $this->param[$key]);
        }
        return $stmt->execute();
    }

    public function getObjectById($id, $primaryKey = 'id')
    {
        try {
            $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
            $query = "SELECT * FROM " . $this->tablaBD . " WHERE $primaryKey = :id";
            $stmt = $database->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Verificar si la consulta encontró una fila
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Si no se encontró ninguna fila, podrías devolver null o lanzar una excepción
                return null;
            }
        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO aquí
            echo "Error de base de datos: " . $e->getMessage();
            return null;
        }
    }

    //obtener objeto completo por su filtro
    public function getObjectByFilters($filtros)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $where = '';
        foreach ($filtros as $key => $value) {
            $where .= $where == '' ? ' WHERE ' . $key . ' = :' . $key : ' AND ' . $key . ' = :' . $key;
        }

        $query = "SELECT * FROM " . $this->tablaBD . $where;
        $stmt = $database->prepare($query);

        foreach ($filtros as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //------------------------------------------------------------ SELECT COUNT
    public function count($campo, $filtros)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $where = '';
        foreach ($filtros as $key => $value) {
            $where .= $where == '' ? ' WHERE ' . $key . '=:' . $key : ' and ' . $key . '=:' . $key;
        }
        $query = "SELECT " . $campo . " FROM " . $this->tablaBD . $where;
        $stmt = $database->prepare($query);
        foreach ($filtros as $key => $value) {
            $valor = ($this->long[$key] > 0 ? (strlen($value) > $this->long[$key] ? null : $value) : $value);
            $stmt->bindvalue(':' . $key, $valor, $this->param[$key]);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    //muestra todos los datos de una base de datos
    function all()
    {
        $result = null;
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        // Agrega un espacio después de "FROM" para que la consulta sea válida
        $query = "SELECT * FROM " . $this->tablaBD;
        $stmt = $database->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 1) {
            // Si hay múltiples resultados, crea un array para almacenarlos
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($stmt->rowCount() == 1) {
            // Si hay un solo resultado, obtén ese resultado directamente
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    function allColumn($columns)
    {
        $result = null;
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        // Verifica si se proporcionaron columnas válidas
        if (!is_array($columns) || empty($columns)) {
            throw new Exception("Debe proporcionar al menos una columna para seleccionar.");
        }
        // Construye la lista de columnas para la consulta
        $columnList = implode(", ", $columns);
        $query = "SELECT $columnList FROM " . $this->tablaBD;
        $stmt = $database->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            // Si hay resultados, almacénalos en el array resultante
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function existe($campo, $filtro)
    {
        $database = $this->getConnection();   //coloque aqui =>  $database = $this->database->connect()
        $query = "SELECT * FROM " . $this->tablaBD . " WHERE $campo = :filtro";
        $stmt = $database->prepare($query);
        $stmt->bindValue(':filtro', $filtro);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($r); // Devuelve true si el elemento existe, false si no existe.
    }
}
