<?php

namespace lib;

use Closure;


class Route
{
    private static $routes = [];
    private static $lastRoute = null;  // Para almacenar la última ruta registrada
    private static $currentController = null; // Para almacenar el controlador actual
    private static $currentPrefix = ''; // Para almacenar el prefijo actual

    public static function get($uri, $callback)
    {
        return self::registerRoute('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        return self::registerRoute('POST', $uri, $callback);
    }

    public static function prefix($prefix)
    {
        // Establece el prefijo actual, eliminando las barras iniciales y finales
        self::$currentPrefix = trim($prefix, "/");
        return new static(); // Devuelve una instancia para el encadenamiento de métodos
    }


    private static function registerRoute($method, $uri, $callback)
    {
        // Si hay un controlador asignado, se agrega al callback
        if (self::$currentController) {
            $callback = [self::$currentController, $callback];
        }

        // Agregar el prefijo a la URI si existe
        if (!empty(self::$currentPrefix)) {
            $uri = self::$currentPrefix . '/' . $uri;
        }

        $uri = trim($uri, "/");
        self::$routes[$method][$uri] = ['callback' => $callback, 'named' => null, 'middleware' => []];

        // Almacena la última ruta registrada
        self::$lastRoute = ['method' => $method, 'uri' => $uri];

        return new static();
    }

    public static function name($name)
    {
        // Asegúrate de que haya una última ruta registrada
        if (self::$lastRoute) {
            $method = self::$lastRoute['method'];
            $uri = self::$lastRoute['uri'];

            // Asigna el nombre a la última ruta registrada
            self::$routes[$method][$uri]['named'] = $name;

            // Resetea la última ruta después de nombrarla
            //self::$lastRoute = null;
        } else {
            var_dump('error no hay ruta registrada para asignar un nombre');
        }
        return new static(); // Devuelve una instancia para el encadenamiento de métodos
    }


    // Asigna nombre a una ruta específica por su URI
    public static function named($uri, $name)
    {
        $uri = trim($uri, "/");
        if (isset(self::$routes['GET'][$uri])) {
            self::$routes['GET'][$uri]['named'] = $name;
        } else if (isset(self::$routes['POST'][$uri])) {
            self::$routes['POST'][$uri]['named'] = $name;
        } else {
            var_dump('error no existe la uri => /' . $uri);
        }

        return new static(); // Devuelve una instancia para el encadenamiento de métodos
    }

    //para agrupar rutas por medio de un controlador
    public static function controller($controller)
    {
        // Guarda el controlador actual para usarlo en el grupo
        self::$currentController = $controller;
        return new static(); // Devuelve una instancia para el encadenamiento de métodos
    }

    public function group(Closure $callback)
    {
        // Ejecuta el callback que define las rutas dentro del grupo
        $callback();

        // Resetea el controlador actual después de registrar las rutas del grupo
        self::$currentController = null;
        self::$currentPrefix = ''; // Resetea el prefijo
    }

    // Asignar middleware a una ruta específica
    public static function middleware($middlewares)
    {
        if (self::$lastRoute) {
            $method = self::$lastRoute['method'];
            $uri = self::$lastRoute['uri'];

            // Asigna los middlewares a la última ruta registrada
            self::$routes[$method][$uri]['middleware'] = $middlewares;
            self::$lastRoute = null;
        } else {
            var_dump('No hay ruta registrada para asignar middleware');
        }
        return new static();
    }

    public static function executeMiddleware($middlewares, $queryParams = [])
    {

        // Si el middleware no es un array de arrays (es decir, es un solo middleware)
        if (isset($middlewares[0]) && !is_array($middlewares[0])) {
            // Entonces asumimos que es un solo middleware y lo convertimos en un array de arrays
            $middlewares = [$middlewares];
        }

        // Iterar sobre todos los middlewares
        foreach ($middlewares as $middleware) {
            // Si el middleware es un array, debe contener [Clase, Método]
            if (is_array($middleware)) {
                $middlewareClass = $middleware[0];
                $methods = $middleware[1]; //puede ser un arrat o un solo metodo

                // Crear una instancia del middleware
                if (!class_exists($middlewareClass)) {
                    echo "La clase $middlewareClass no existe";
                    return false;
                }

                $middlewareInstance = new $middlewareClass();

                // Si los métodos son un array, los recorremos, si no, lo tratamos como un solo método
                $methods = is_array($methods) ? $methods : [$methods];

                // Ejecutar cada método en el middleware
                foreach ($methods as $method) {
                    // Verificar que el método exista
                    if (!method_exists($middlewareInstance, $method)) {
                        echo "El método $method no existe en la clase $middlewareClass";
                        return false;
                    }

                    // Ejecutar el método con o sin parámetros según la existencia de $queryParams
                    if (!empty($queryParams)) {
                        if ($middlewareInstance->$method($queryParams) === false) {
                            return false;  // Detener la ejecución si algún middleware falla
                        }
                    } else {
                        if ($middlewareInstance->$method() === false) {
                            return false;  // Detener la ejecución si algún middleware falla
                        }
                    }
                }
            }
        }
        // Si todos los middlewares se ejecutaron correctamente, continuar
        return true;
    }

    public static function route($name, $expectedMethod = null)
    {

        // Verificar si se ha especificado un método esperado
        if ($expectedMethod !== null) {
            // Buscar la ruta asociada al nombre especificado para el método esperado
            foreach (self::$routes[$expectedMethod] as $uri => $routeInfo) {
                if (isset($routeInfo['named']) && $routeInfo['named'] === $name) {
                    return '/' . $uri;
                }
            }
            return null;
        } else {
            // Si no se especifica, usar el método de la solicitud actual
            $currentMethod = $_SERVER['REQUEST_METHOD'];

            if (isset(self::$routes[$currentMethod])) {
                foreach (self::$routes[$currentMethod] as $uri => $routeInfo) {
                    if (isset($routeInfo['named']) && $routeInfo['named'] === $name) {
                        return '/' . $uri;
                    }
                }
            }
        }
        return null;
    }

    // Obtener la URL actual
    public static function getCurrentUrl()
    {
        return $_SERVER['REQUEST_URI'] ?? '/'; // Retorna la URL actual o "/" si no existe
    }

    // Obtener la URL anterior válida desde la sesión
    public static function getPreviousUrl()
    {
        return $_SESSION['previous_url'] ?? '/'; // Retorna la última URL conocida desde la sesión o "/" si no existe
    }

    //para acer un listado de rutas, ya sean tipo GET o POST
    public static function ruta($method)
    {
        return self::$routes[$method];
    }

    public static function enrutador()
    {
        return self::$routes;
    }

    public static function dispatch()
    {

        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, "/");
        $method = $_SERVER['REQUEST_METHOD'];

        // Extraer los parámetros de la query string
        $queryParams = [];  //?edad=25&id=1
        if (strpos($uri, '?')) {
            $queryString = substr($uri, strpos($uri, '?') + 1);
            parse_str($queryString, $queryParams); // Convierte la query string en un array asociativo
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        // Intenta servir archivos estáticos de manera dinámica
        if (self::serveStaticIfMatched($uri)) {
            return; // Si se sirvió un archivo, detener la ejecución
        }

        foreach (self::$routes[$method] as $route => $routeInfo) {
            $callback = $routeInfo['callback'];
            $route = preg_replace('#{[a-zA-Z0-9_]+}#', '([^/]+)', $route);
            if (preg_match("#^$route$#", $uri, $matches)) {
                $params = array_slice($matches, 1);
                // Ejecutar middleware si existe
                if (isset($routeInfo['middleware'])) {
                    if (self::executeMiddleware($routeInfo['middleware'], $queryParams) === false) {
                        // Si algún middleware falla, detener la ejecución
                        echo "Middleware falló";
                        return;
                    }
                }
                $_SESSION['previous_url'] = self::getCurrentUrl();
                if (is_callable($callback)) {
                    $response = is_array($callback) ? (new $callback[0])->{$callback[1]}(...$params) : $callback(...$params);
                    if (is_object($response)) {
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        echo $response;
                    }
                    return;
                }
            }
        }
        return new Error(); // lo define como error si no lo encuentra la pagina
    }

    //especifica la redireccion de la pagina web a otra url
    public static function redirect($to, $statusCode = 302)
    {
        // Si la ruta es una ruta nombrada, obtener la URI correspondiente
        if (strpos($to, '/') !== 0 && self::route($to)) {
            $to = self::route($to);
        }
        // Redirigir a la URL o ruta dada
        header('Location: ' . $to, true, $statusCode);
        exit();
    }

    private static function serveStaticIfMatched($uri)
    {
        $baseDirs = MimeType::getBaseDirs(); // Obtiene los baseDirs desde MimeType

        foreach ($baseDirs as $prefix => $baseDir) {
            if (strpos($uri, $prefix) === 0) {
                // Si coincide con un prefijo, servir el archivo correspondiente
                return MimeType::serveStaticFile($uri);
            }
        }

        return false; // Si no coincide con ningún prefijo
    }



    public static function view($viewName)
    {
        return new View($viewName); // Devolver una nueva instancia de View
    }
}
