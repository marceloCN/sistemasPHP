<?php

use lib\Route;
use App\Controllers\HomeController;
use App\Controllers\SoporteController;
use App\Controllers\SistemaController;
use App\Controllers\SolicitudController;

use App\Controllers\Middlewares\AuthMiddleware;
use App\Controllers\Middlewares\PostMiddleware;

use App\Models\Usuarios;

Route::get('', function () {
    return Route::view('inicio')->render();
})->name('inicio')->middleware([AuthMiddleware::class, ['estasLogueado']]);

Route::get('inicio/{id}', function (Usuarios $id) {
    //$usuarios = new Usuarios();
    //$usuarios = $usuarios->select(['*'], ['id' => $id], []);
    //var_dump($usuarios);
});

Route::controller(HomeController::class)->group(function () {
    Route::post('verificar', 'verificar_credencial')->name('verificar_credenciales')->middleware([PostMiddleware::class, ['isPost']]);
    Route::get('Area-de-trabajo', 'dashboard')->name('dashboard')->middleware([AuthMiddleware::class, ['auth']]);
    Route::get('/logout', 'logout')->name('logout');
});

Route::prefix('Area-de-trabajo')->controller(SolicitudController::class)->group(function () {
    // Rutas para Solicitudes no recepcionadas
    Route::get('Solicitudes-no-recepcionadas', 'no_recepcionada')->name('solicitud_no_recepcionada_listar')->middleware([AuthMiddleware::class, ['auth']]);

    // Agrupación de rutas para Solicitudes recepcionadas
    Route::prefix('Solicitudes-recepcionadas')->group(function () {
        Route::get('/', 'recepcionada')->name('solicitud_recepcionada_listar')->middleware([AuthMiddleware::class, ['auth']]);
        Route::post('responder-solicitud', 'responder_solicitud')->name('responder_solicitud')->middleware([PostMiddleware::class, ['isPost']]);
        Route::get('personal_por_direccion/{id}', 'personal_por_direccion')->name('personal_por_direccion');
    });
});


Route::prefix('Area-de-trabajo')->controller(SoporteController::class)->group(function () {
    Route::get('trabajos-soporte', 'soporte')->name('listar_soporte')->middleware([AuthMiddleware::class, ['auth']]);
});

Route::prefix('Area-de-trabajo')->controller(SistemaController::class)->group(function () {
    Route::get('trabajos-sistema', 'sistema')->name('listar_sistema')->middleware([AuthMiddleware::class, ['auth']]);
});



/*
use App\Controllers\NuevoController;
use App\Controllers\DateController;
use App\Controllers\DatosController;

//  utilizando controladores
use App\Controllers\HomeController;
use App\Controllers\EventoController;
use App\Controllers\UsuariosController;
use App\Controllers\ConfiguracionController;

// utilizando middlewares
use App\Middlewares\AuthMiddleware;
use App\Middlewares\PostMiddleware;


// Grupo de rutas para HomeController
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('principal')->middleware([AuthMiddleware::class, ['estasLogueado']]);
    Route::post('/Verificar-credenciales', 'verificar_credenciales')->name('verificar_credenciales')->middleware([PostMiddleware::class, ['isPost']]);
    Route::get('/Area-de-trabajo', 'dashboard')->name('dashboard')->middleware([AuthMiddleware::class, ['auth', 'isAdmin']]);
    Route::get('/logout', 'logout')->name('logout');
    Route::get('loguearDatos4534', 'index1');
});

// Grupo de rutas para EventoController
Route::controller(EventoController::class)->group(function () {
    Route::post('/pdf_funcionario', 'descargar_pdf')->name('pdf_funcionario')->middleware([PostMiddleware::class, ['isPost']]);
    Route::post('/Area-de-trabajo/registrar-marcacion', 'create')->name('registrar-marcacion');
    Route::get('/Area-de-trabajo/Evento-Listar', 'index')->name('evento_listar')->middleware([AuthMiddleware::class, ['auth', 'isAdmin']]);
    Route::post('/Area-de-trabajo/Evento-Listar/descargarPDF', 'verEvento')->name('descargar_pdf')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/verMarcacion_funcionario', 'verMarcacion_funcionario')->name('verMarcacion_funcionario')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/guardarCambiosMarcacion', 'guardarCambiosMarcacion')->name('guardarCambiosMarcacion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/eliminarMarcacion', 'eliminarMarcacion')->name('eliminar_Marcacion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/Por-tipo', 'listar_por_tipo_contrato')->name('listar_marcacion_por_tipo_y_mes')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/Por-CSV', 'listar_por_CSV')->name('listar_marcacion_por_CSV')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/Por-Mes', 'listar_por_mes')->name('listar_marcacion_por_mes')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/existe-marcacion-funcionario', 'mes_indicar_funcionario')->name('mes_indicar_funcionario')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/obtener_eventos_fechas', 'obtener_eventos_fechas')->name('obtener_eventos_fechas')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Evento-Listar/guardar_datos_calculo', 'guardar_datos_calculo')->name('guardar_datos_calculo')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
});

// Grupo de rutas para UsuariosController
Route::controller(UsuariosController::class)->group(function () {
    Route::post("/Area-de-trabajo/registrar-funcionario", 'create')->name('registrar-funcionario');
    Route::post("/Area-de-trabajo/registrar-un-funcionario", 'createOne')->name('registrar_un_funcionario')->middleware([PostMiddleware::class, ['isPost']]);
    Route::get('/Area-de-trabajo/Funcionarios-Listar', 'index')->name('funcionarios')->middleware([AuthMiddleware::class, ['auth', 'isAdmin']]);
    Route::post('/Area-de-trabajo/Funcionarios-Listar/modificar-datos-funcionarios', 'modificar_datos_usuarios')->name('modificar_datos_usuarios')->middleware([AuthMiddleware::class, ['auth']]);
});

// Grupo de rutas para ConfiguracionController
Route::controller(ConfiguracionController::class)->group(function () {
    Route::get('/Area-de-trabajo/Configuraciones', 'index')->name('configuracion')->middleware([AuthMiddleware::class, ['auth', 'isAdmin']]);
    Route::post('/Area-de-trabajo/Configuraciones/editar-localizacion', 'editar_localizacion')->name('editar_localizacion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/editar-tipo-contrato', 'editar_tipo_contrato')->name('editar_tipo_contrato')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/registrar-localizacion', 'registrar_localizacion')->name('registrar_localizacion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/registrar-contratos', 'registrar_contratos')->name('registrar_contratos')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/registrar-configuracion', 'registrar_configuracion')->name('registrar_configuracion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/activar-configuracion', 'activar_configuracion')->name('activar_configuracion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
    Route::post('/Area-de-trabajo/Configuraciones/editar-configuracion', 'editar_configuracion')->name('editar_configuracion')->middleware([[AuthMiddleware::class, ['auth']], [PostMiddleware::class, ['isPost']]]);
});

Route::get('/ingresar', function () {
    return "hola";
})->middleware([AuthMiddleware::class, ['auth']]);

Route::controller(DatosController::class)->group(function () {
    Route::get('loguearDatos', 'index');
});

Route::controller(DateController::class)->group(function () {
    Route::get('sdfsd', 'index');
    Route::get('sdf234', 'index32');
    Route::post('reter', 'verificar_credenciales');
    Route::get('fsfa1', 'verificar_credenciales1');
    Route::post('yth45', 'loguearDatos');
    Route::get('fj76', 'fghf45432');
    Route::get('ghfhdhd', 'rg24312');
});

Route::controller(NuevoController::class)->group(function () {
    Route::get('th', 'index');
    Route::get('loguearDatoshgdh56', 'verificar_credenciales');
    Route::post('hjk', 'verificar_credenciales1');
});
*/