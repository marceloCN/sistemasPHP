<?php

namespace lib;

class View
{
    private $viewName;
    private $data = [];

    public function __construct($viewName)
    {
        $this->viewName = $viewName;
    }

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this; // Permitir encadenamiento de métodos
    }

    public function render()
    {
        $viewPath = __DIR__ . '/../App/views/' . str_replace('.', '/', $this->viewName) . '.php';

        if (file_exists($viewPath)) {
            ob_start(); // Iniciar buffer
            include $viewPath; // Incluir la vista
            $content = ob_get_clean(); // Obtener contenido del buffer

            // Reemplazar variables en el contenido
            foreach ($this->data as $key => $value) {
                $content = str_replace("{{$key}}", $value, $content);
            }

            return $content;
        }

        return $this->handleViewError($this->viewName);
    }

    private function handleViewError($viewName)
    {
        $errorFilePath = __DIR__ . "/../lib/error/error404.php";
        $data = ['route' => $viewName];

        if (file_exists($errorFilePath)) {
            ob_start();
            include $errorFilePath;
            $errorContent = ob_get_clean();

            foreach ($data as $key => $value) {
                $errorContent = str_replace("{{$key}}", $value, $errorContent);
            }

            return $errorContent;
        } else {
            return "Error: La vista '$viewName' no se encuentra y tampoco se encontró la página de error.";
        }
    }
}
