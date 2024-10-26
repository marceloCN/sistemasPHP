<?php

namespace lib;

use Closure;

use lib\Error;


class Route
{
    private static $routes = [];
    private static $lastRoute = null;  // Para almacenar la última ruta registrada
    private static $currentController = null; // Para almacenar el controlador actual

    public static function get($uri, $callback)
    {
        return self::registerRoute('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        return self::registerRoute('POST', $uri, $callback);
    }

    private static function registerRoute($method, $uri, $callback)
    {
        // Si hay un controlador asignado, se agrega al callback
        if (self::$currentController) {
            $callback = [self::$currentController, $callback];
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

        //verifica si la url empieza con resources
        if (strpos($uri, 'resources') === 0) {
            return self::serveStaticFile($uri);
        }

        // Verifica si la URI empieza con 'backend' o 'frontend o 'librery
        if (strpos($uri, 'backend') === 0 || strpos($uri, 'frontend') === 0 || strpos($uri, 'librery') === 0) {
            //sirve para poder encontrar las librerias que tienes guardado
            return self::serveStaticFileBackend($uri);
        }

        foreach (self::$routes[$method] as $route => $routeInfo) {
            $callback = $routeInfo['callback'];
            /*
            if (strpos($route, ':') !== false) {
                $route = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $route);
            }*/
            $route = preg_replace('#{[a-zA-Z0-9_]+}#', '([^/]+)', $route);
            if (preg_match("#^$route$#", $uri, $matches)) {

                $params = array_slice($matches, 1);

                /************************************************************************* */
                // Ejecutar middleware si existe
                if (isset($routeInfo['middleware'])) {
                    if (self::executeMiddleware($routeInfo['middleware'], $queryParams) === false) {
                        // Si algún middleware falla, detener la ejecución
                        echo "Middleware falló";
                        return;
                    }
                }
                $_SESSION['previous_url'] = self::getCurrentUrl();
                /************************************************************************* */

                if (is_callable($callback)) {
                    if (is_array($callback) && isset($callback[0]) && isset($callback[1])) {
                        $controller = new $callback[0];
                        $response = $controller->{$callback[1]}(...$params);
                    } else {
                        $response = $callback(...$params);
                    }
                    if (is_object($response)) {
                        header('Content-Type: application/json');
                        return json_encode($response);
                    } else {
                        echo $response;
                    }
                    return;
                } else { //no es una funcion callback
                    //require_once "../resources/views/error/not_found.php";
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


    private static function serveStaticFile($uri)
    {
        // Construir la ruta completa al archivo estático
        $filePath = './../' . $uri;

        // Verificar si el archivo existe
        if (file_exists($filePath)) {
            // Si el archivo es un archivo PHP, incluirlo y detener la ejecución
            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                include $filePath;
                return true;
            }

            // Determinar el tipo MIME del archivo
            $contentType = mime_content_type($filePath);

            // Establecer el encabezado Content-Type
            header("Content-Type: $contentType");

            // Servir el archivo estático y detener la ejecución
            readfile($filePath);
            return true;
        } else {
            // Si el archivo no existe, devolver un 404 Not Found
            http_response_code(404);
            echo '404 Not Found';
            return false;
        }
    }

    private static function serveStaticFileBackend($uri)
    {

        // Definir las rutas base según el prefijo de la URI
        $baseDirs = [
            'backend' => __DIR__ . '/../lib/src/public/',
            'frontend' => __DIR__ . '/../App/public/',
            'librery' => __DIR__ . '/../vendor/'
        ];
        // Identificar el prefijo de la URI (backend, frontend, vendor)
        foreach ($baseDirs as $key => $baseDir) {
            if (strpos($uri, $key) === 0) {
                // Remover el prefijo de la URI para obtener la parte relativa
                $relativeUri = preg_replace("#^$key/#", '', $uri);
                // Construir la ruta completa al archivo
                $filePath = realpath($baseDir . $relativeUri);
                // Verificar si el archivo existe
                if (file_exists($filePath)) {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    $contentType = self::getMimeType($ext);
                    header("Content-Type: $contentType");
                    readfile($filePath);
                    return true;
                }
            }
        }

        // Si no se encuentra el archivo, devolver 404
        return self::handleNotFound();
    }

    // Método para obtener el tipo MIME basado en la extensión
    private static function getMimeType($extension)
    {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'html' => 'text/html',
            'txt' => 'text/plain',
            // Agrega más tipos MIME según sea necesario
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream'; // Valor por defecto si no se encuentra
    }

    private static function handleNotFound()
    {
        http_response_code(404);
        echo '404 Not Found';
        return false;
    }

    public static function view($viewName)
    {
        $viewPath = __DIR__ . '/../App/views/' . str_replace('.', '/', $viewName) . '.php';
        if (file_exists($viewPath)) {
            ob_start(); // Inicia el buffer de salida
            include $viewPath; // Incluye la vista
            return ob_get_clean(); // Devuelve el contenido del buffer
        }
        return "Vista no encontrada"; // Manejo de errores
    }
}
