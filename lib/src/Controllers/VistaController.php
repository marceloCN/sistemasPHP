<?php

namespace lib\src\Controllers;

use lib\Route;

class VistaController extends Controller
{
    public function index()
    {
        return $this->view(
            'template.dashboard',
            [
                'head' => $this->head('Vista', 'Contenido de la pagina principal de Vista'), //aqui es donde varia
                'link' => $this->getLinkSrc('link', ['https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css']),
                'src' => $this->getLinkSrc('src', [
                    constant('URL') . "/backend/dist/js/adminlte.min.js"
                ]),
                'nav' => $this->getNav('template.nav'),
                'aside' => $this->getNav('template.aside'),
                'title' => 'Area de Vista',
                'session' => 'Area de Vista',
                'content' => $this->getNav('backend.content_vista'), //aqui es donde varia siempre
            ]
        );
    }
}
