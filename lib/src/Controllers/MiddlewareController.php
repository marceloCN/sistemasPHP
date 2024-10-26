<?php

namespace lib\src\Controllers;

use lib\Route;

class MiddlewareController extends Controller
{
    public function index()
    {
        return $this->view(
            'template.dashboard',
            [
                'head' => $this->head('Middlewares', 'Contenido de la pagina principal de middlewares'), //aqui es donde varia
                'link' => $this->getLinkSrc('link', ['https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css']),
                'src' => $this->getLinkSrc('src', [
                    constant('URL') . "/backend/dist/js/adminlte.min.js"
                ]),
                'nav' => $this->getNav('template.nav'),
                'aside' => $this->getNav('template.aside'),
                'title' => 'Area de Middleware',
                'session' => 'Area de Middleware',
                'content' => $this->getNav('backend.content_middleware'), //aqui es donde varia siempre
            ]
        );
    }
}
