<?php

namespace App\Controllers;

use lib\Helpers;
use lib\Route;

//el Helpers es para ayudar a contener las funciones mas fundamentales para el controller
class Controller extends Helpers
{

    public function redirect($route)
    {
        $location = 'location:' . constant('URL') . $route;
        header($location);
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect(Route::route('principal'));
    }

    public function head($title = 'document', $content = 'nombre del documento', $icon = "/gam.ico")
    {
        $ico = constant('URL') . $icon;
        $head = "
        <meta name='description' content='$content'>
        <title>$title</title>
        <link rel='icon' type='image/x-icon' href='$ico' />
        ";
        return $head;
    }

    public function getLinkSrc($enlace = 'link', $link_script = [])
    {
        // Base stylesheets
        $baseLinks = [
            "https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css",
            "https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css",
            "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700",
            "https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"

        ];

        // Base scripts
        $baseScripts = [
            "https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js",
            "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js",
            "https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js",
            "https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"
        ];
        // Merge additional links/scripts if provided
        if (is_array($link_script) && !empty($link_script)) {
            if ($enlace === 'link') {
                $baseLinks = array_merge($baseLinks, $link_script);
            } elseif ($enlace === 'src') {
                $baseScripts = array_merge($baseScripts, $link_script);
            }
        }

        // Generate HTML output
        if ($enlace === 'link') {
            return implode("\n", array_map(fn($url) => "<link rel='stylesheet' href='$url'>", $baseLinks));
        } elseif ($enlace === 'src') {
            return implode("\n", array_map(fn($url) => "<script src='$url'></script>", $baseScripts));
        }

        return ''; // Return an empty string if $enlace is neither 'link' nor 'src'
    }

    public function getNav($route)
    {
        $filePath = "../App/views/" . str_replace('.', '/', $route) . ".php";
        if (file_exists($filePath)) {
            ob_start();
            include $filePath;
            $date = ob_get_clean();
            return $date;
        } else {
            return $this->notFound($route, 2);
        }
    }

    public function setRememberMeCookies($email, $password)
    {
        setcookie("username", $email, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => true, // Asegúrate de que esté en HTTPS
            'httponly' => true,
            'samesite' => 'Strict' // Cambia según tus necesidades
        ]);

        setcookie("password", $password, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'secure' => true, // Asegúrate de que esté en HTTPS
            'httponly' => true,
            'samesite' => 'Strict' // Cambia según tus necesidades
        ]);
    }
}
