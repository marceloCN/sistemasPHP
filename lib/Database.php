<?php

namespace lib;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $user;
    private $pwd;
    private $charset;

    public function __construct($dbIdentifier = null)
    {
        if ($dbIdentifier) {
            $this->setMultipleConnection($dbIdentifier);
        } else {
            $this->host = constant('HOST');
            $this->user = constant('USER');
            $this->pwd = constant('PWD');
            $this->charset = constant('CHARSET');
        }
    }

    public function setMultipleConnection($dbIdentifier)
    {
        // Determina las constantes a utilizar según el identificador
        $this->host = constant($dbIdentifier . '_HOST');
        $this->user = constant($dbIdentifier . '_USER');
        $this->pwd = constant($dbIdentifier . '_PWD');
        $this->charset = constant('CHARSET'); // Puedes mantener CHARSET constante para todos
    }


    function connect()
    {
        try {
            $options = [
                PDO::ATTR_ERRMODE           =>  PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  =>  true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$this->charset}"
            ];
            $pdo = new PDO($this->host, $this->user, $this->pwd, $options);
            //$pdo->exec("set names utf8");
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
    }

    public function toString()
    {
        return "HOST: {$this->host} <br>USER: {$this->user} <br>PWD: {$this->pwd} <br>CHARSET: {$this->charset} <br>";
    }
}
