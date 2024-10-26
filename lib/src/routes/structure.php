<?php

use lib\Route;

/*
use lib\src\Controllers\BackendController;
use lib\src\Controllers\ModeloController;
use lib\src\Controllers\VistaController;
use lib\src\Controllers\ControladorController;
use lib\src\Controllers\MiddlewareController;
use lib\src\Controllers\RouterController;

use lib\src\Middlewares\AuthMiddleware;
use App\Middlewares\PostMiddleware;

Route::controller(BackendController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador', 'index')->name('backend.inicio')->middleware([AuthMiddleware::class, ['estasLogueado']]);
    Route::post('panelConfiguration/website/administrador', 'verificar')->name('backend.verificar')->middleware([PostMiddleware::class, ['isPost']]);
    Route::get('panelConfiguration/website/administrador/dashboard', 'dashboard')->name('backend.dashboard')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/logout', 'logout')->name('backend.logout');
});

Route::controller(ModeloController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador/dashboard/Modelo', 'index')->name('backend.modelo')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/Modelo/Documentacion', 'documentacion')->name('backend.modelo.documentacion')->middleware([AuthMiddleware::class, ['auth']]);
});

Route::controller(VistaController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador/dashboard/Vista', 'index')->name('backend.vista')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/Vista/Documentacion', 'documentacion')->name('backend.vista.documentacion')->middleware([AuthMiddleware::class, ['auth']]);
});

Route::controller(ControladorController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador/dashboard/Controlador', 'index')->name('backend.controlador')->middleware([AuthMiddleware::class, ['auth']]);
    Route::post('panelConfiguration/website/administrador/dashboard/Controlador/registrar', 'registro')->name('backend.controlador.registrar')->middleware([PostMiddleware::class, ['isPost']]);
    Route::post('panelConfiguration/website/administrador/dashboard/Controlador/registrar-metodo', 'metodo')->name('backend.controlador.registrar.metodo')->middleware([PostMiddleware::class, ['isPost']]);
    Route::post('panelConfiguration/website/administrador/dashboard/Controlador/mostrar-metodo', 'mostrarMetodo')->name('backend.controlador.mostrar_metodo');
    Route::get('panelConfiguration/website/administrador/dashboard/Controlador/listar-Controladores', 'listarControlador')->name('backend.controlador.listarControlador')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/Controlador/Documentacion', 'documentacion')->name('backend.controlador.documentacion')->middleware([AuthMiddleware::class, ['auth']]);
});

Route::controller(MiddlewareController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador/dashboard/Middleware', 'index')->name('backend.middleware')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/Middleware/Documentacion', 'documentacion')->name('backend.middleware.documentacion')->middleware([AuthMiddleware::class, ['auth']]);
});

Route::controller(RouterController::class)->group(function () {
    Route::get('panelConfiguration/website/administrador/dashboard/Router', 'index')->name('backend.router')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('panelConfiguration/website/administrador/dashboard/Router/Documentacion', 'documentacion')->name('backend.router.documentacion')->middleware([AuthMiddleware::class, ['auth']]);
});

*/