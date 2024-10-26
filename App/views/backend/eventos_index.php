<?php

use lib\Route;

use App\Models\TipoContrato;
use App\Models\Calculo;
use App\Models\Configuracion;
use App\Models\Funcionario;

$tipoContrato = new TipoContrato();
$tipoContrato = $tipoContrato->all();

$Calculos = new Calculo();
$Calculos = $Calculos->listarCalculosActuales();

$configuracion = new Configuracion();
$configuracion = $configuracion->select(['*'], ['estado' => 'AC'], []);

$funcionarios = new Funcionario();
$funcionarios = $funcionarios->all();
?>



<section class="content">
    <div class="container-fluid">

        <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="pt-2 px-3">
                            <h3 class="card-title">Paleta de opciones... marcaciones de:</h3>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Planta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Contrato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Consultor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">Salud</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-settings1-tab" data-toggle="pill" href="#custom-tabs-two-settings1" role="tab" aria-selected="false">Mostrar todos</a>
                        </li>
                    </ul>
                </div>

                <div class="modal fade ver-marcacion-funcionario" id="modal-xl" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title titulo-responsable"> </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>One fine body…</p>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade editar-marcacion-funcionario" id="modal-lg" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title titulo-responsable"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>One fine body…</p>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>



                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de marcaciones de planta</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Planta" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Planta">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Mes</th>
                                                <th scope="col">Retrazos</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($Calculos != null) {
                                                foreach ($Calculos as $calculo) {
                                                    if (intval($calculo['id_tipo']) == 1) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                            <td><?= $calculo['nombre'] ?></td>
                                                            <td><?= $calculo['nombre_mes'] ?></td>
                                                            <td><?= $calculo['totalretrazo'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                                <button type="button" class="btn btn-success ver-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Ver</button>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-marcacion" data-id="<?= $calculo['id'] ?>">Eliminar Marcacion</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de marcaciones de Contrato</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Contrato" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Contrato">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Mes</th>
                                                <th scope="col">Retrazos</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($Calculos != null) {
                                                foreach ($Calculos as $calculo) {
                                                    if (intval($calculo['id_tipo']) == 2) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                            <td><?= $calculo['nombre'] ?></td>
                                                            <td><?= $calculo['nombre_mes'] ?></td>
                                                            <td><?= $calculo['totalretrazo'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                                <button type="button" class="btn btn-success ver-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Ver</button>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-marcacion" data-id="<?= $calculo['id'] ?>">Eliminar Marcacion</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de marcaciones de Consultor(a)</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Consultor" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Consultor">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Mes</th>
                                                <th scope="col">Retrazos</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($Calculos != null) {
                                                foreach ($Calculos as $calculo) {
                                                    if (intval($calculo['id_tipo']) == 3) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                            <td><?= $calculo['nombre'] ?></td>
                                                            <td><?= $calculo['nombre_mes'] ?></td>
                                                            <td><?= $calculo['totalretrazo'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                                <button type="button" class="btn btn-success ver-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Ver</button>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-marcacion" data-id="<?= $calculo['id'] ?>">Eliminar Marcacion</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de marcaciones de Salud</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Salud" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Salud">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Mes</th>
                                                <th scope="col">Retrazos</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($Calculos != null) {
                                                foreach ($Calculos as $calculo) {
                                                    if (intval($calculo['id_tipo']) == 4) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                            <td><?= $calculo['nombre'] ?></td>
                                                            <td><?= $calculo['nombre_mes'] ?></td>
                                                            <td><?= $calculo['totalretrazo'] ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                                <button type="button" class="btn btn-success ver-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Ver</button>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-marcacion" data-calculo="<?= htmlspecialchars(json_encode($calculo), ENT_QUOTES, 'UTF-8') ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-marcacion" data-id="<?= $calculo['id'] ?>">Eliminar Marcacion</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-settings1" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-edit"></i>
                                                Mostrar eventos de los/las funcionarios(as) en general
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <h4>Mostrar eventos de marcacion de contratos por mes</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="mostrar-contratos-por-mes">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Tipo de contrato</label>
                                                                            <select class="form-control" id="tipo_contrato">
                                                                                <?php foreach ($tipoContrato as $tipo): ?>
                                                                                    <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Indicar el mes</label>
                                                                            <select class="form-control" id="mes_indicar_por_contrato">
                                                                                <option value="01">Enero</option>
                                                                                <option value="02">Febrero</option>
                                                                                <option value="03">Marzo</option>
                                                                                <option value="04">Abril</option>
                                                                                <option value="05">Mayo</option>
                                                                                <option value="06">Junio</option>
                                                                                <option value="07">Julio</option>
                                                                                <option value="08">Agosto</option>
                                                                                <option value="09">Septiembre</option>
                                                                                <option value="10">Octubre</option>
                                                                                <option value="11">Noviembre</option>
                                                                                <option value="12">Diciembre</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">mostrar por tipo de contrato</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div id="loading-mostrar-por-tipo" style="display: none; text-align: center; margin-top: 20px;">
                                                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                                <p>Cargando...</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h4>Mostrar eventos por lista de archivo CSV</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="mostrar-eventos-por-csv">
                                                                <div class="row">
                                                                    <b>
                                                                        <p>Te mostrara una lista de marcaciones de los funcionarios(as) en su respectivo mes, sin tomar en cuenta el tipo de contrato. Ejemplo:<br>
                                                                            CI;nombre;cargo <br>
                                                                            4581759;CORREA MALDONADO RUFINO;ALCALDE MUNICIPAL <br>
                                                                            5648133;MARTINEZ SEGURA ROSMERI;SECRETARIO MUNICIPAL GENERAL <br>
                                                                            1865915;VALERIANO FLORES ALEJANDRO;SECRETARIO MUNICIPAL DE ORDENAMIENTO TERRITORIAL Y MEDIO AMBIENTE <br>
                                                                            7738304;ROJAS TORRICO JAVIER FERNANDO;SECRETARIO MUNICIPAL DE ASUNTOS JURIDICOS <br>
                                                                            6308223;VEGA ROJAS JOSE MIJAIL;SECRETARIO MUNICIPAL DE OBRAS PUBLICAS <br>
                                                                            CI del funcionario;nombre completo;Cargo<br>
                                                                        </p>
                                                                    </b>
                                                                    <div class="col-sm-6">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Lista de usuarios CSV</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" id="usuarios_faltantes" class="custom-file-input" id="customFile">
                                                                                <label class="custom-file-label" for="customFile">Subir el archivo con extension .CSV</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Indicar el mes</label>
                                                                            <select class="form-control" id="mes_indicar_por_csv">
                                                                                <option value="01">Enero</option>
                                                                                <option value="02">Febrero</option>
                                                                                <option value="03">Marzo</option>
                                                                                <option value="04">Abril</option>
                                                                                <option value="05">Mayo</option>
                                                                                <option value="06">Junio</option>
                                                                                <option value="07">Julio</option>
                                                                                <option value="08">Agosto</option>
                                                                                <option value="09">Septiembre</option>
                                                                                <option value="10">Octubre</option>
                                                                                <option value="11">Noviembre</option>
                                                                                <option value="12">Diciembre</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <button type="submit" class="btn btn-info btn-block">Mostrar funcionarios por CSV</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div id="loading-mostrar-por-csv" style="display: none; text-align: center; margin-top: 20px;">
                                                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                            <p>Cargando...</p>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <h4>Mostrar eventos por parametro de fecha de funcionario (a)</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id='obtener-marcacion-funcionario-por-mes'>
                                                                <div class="row">
                                                                    <b>
                                                                        <p>Te mostrara el listado del funcionario(a) de su marcacion, en funcion del parametro de mes seleccionado.</p>
                                                                    </b>
                                                                    <div class="col-sm-6">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Mes Inicial</label>
                                                                            <select class="form-control" id="mes_inicial">
                                                                                <option value="01">Enero</option>
                                                                                <option value="02">Febrero</option>
                                                                                <option value="03">Marzo</option>
                                                                                <option value="04">Abril</option>
                                                                                <option value="05">Mayo</option>
                                                                                <option value="06">Junio</option>
                                                                                <option value="07">Julio</option>
                                                                                <option value="08">Agosto</option>
                                                                                <option value="09">Septiembre</option>
                                                                                <option value="10">Octubre</option>
                                                                                <option value="11">Noviembre</option>
                                                                                <option value="12">Diciembre</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Mes Final</label>
                                                                            <select class="form-control" id="mes_final">
                                                                                <option value="01">Enero</option>
                                                                                <option value="02">Febrero</option>
                                                                                <option value="03">Marzo</option>
                                                                                <option value="04">Abril</option>
                                                                                <option value="05">Mayo</option>
                                                                                <option value="06">Junio</option>
                                                                                <option value="07">Julio</option>
                                                                                <option value="08">Agosto</option>
                                                                                <option value="09">Septiembre</option>
                                                                                <option value="10">Octubre</option>
                                                                                <option value="11">Noviembre</option>
                                                                                <option value="12">Diciembre</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- textarea -->
                                                                        <div class="form-group">
                                                                            <label>Funcionario(a)</label>
                                                                            <select class="form-control" id="datos_funcionario">
                                                                                <?php foreach ($funcionarios as $funcionario): ?>
                                                                                    <option value="<?= htmlspecialchars($funcionario['ci']) ?>"><?= htmlspecialchars($funcionario['nombre']) ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Mostrar por fechas</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div id="loading-marcacion-por-mes" style="display: none; text-align: center; margin-top: 20px;">
                                                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                            <p>Cargando...</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</section>


<script>
    $(document).ready(function() {
        $("#tableSearch_Planta").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Planta tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Contrato").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Contrato tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Consultor").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Consultor tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Salud").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Salud tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        $(".descargar-pdf").on("click", function() {
            var formData = {
                id: $(this).data("id"),
            };

            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('descargar_pdf', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var nombreFile = response.nombre;
                        var pdfBase64 = response.pdf;
                        var link = document.createElement('a');
                        link.href = 'data:application/pdf;base64,' + pdfBase64;
                        link.download = nombreFile;
                        document.body.appendChild(link); // Agregamos el link al DOM
                        link.click();
                        document.body.removeChild(link);
                        showNotification('success', 'Se esta descargando el evento...');
                    } else {
                        showNotification('error', response.sms);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    $('#loading-mostrar-por-tipo').hide();
                }
            });
        });

        $(".eliminar-marcacion").on("click", function() {
            var id = $(this).data("id");
            var formData = {
                idCalculo: id,
            };
            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('eliminar_Marcacion', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?= \lib\Route::route('evento_listar', 'GET') ?>";
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                        reject(response.sms);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    reject('Error en la solicitud AJAX');
                }
            });
            window.location.href = url;
        });

        $(".editar-marcacion").on("click", function() {
            // Extraer el JSON del atributo data-calculo
            var calculoJson = $(this).data("calculo");
            var id = calculoJson.id;
            var nombre = calculoJson.nombre.toUpperCase();
            var mes = calculoJson.nombre_mes.toUpperCase();
            var minacum = calculoJson.totalretrazo;
            $('.editar-marcacion-funcionario .titulo-responsable').html('Editar marcacion funcionario(a): <b>' + nombre + '</b>, del mes de <b>' + mes + "</b>, Min Acum.: <b>" + minacum + "</b>");

            obtenerDetalleMarcacion(id).then(function(datos) {
                var modalContent = '<form id="editarMarcacionForm">';
                modalContent += '<div class="form-group row">';
                modalContent += '<label for="totalMin" class="col-sm-3 col-form-label">Minutos acumulados: </label>';
                modalContent += '<div class="col-sm-9">';
                modalContent += '<input type="text" class="form-control" id="totalMin" placeholder="minutos acumulados ...">';
                modalContent += '<input type="hidden" name="idCalculo" id="idCalculo">';
                modalContent += '</div>';
                modalContent += '</div>';
                modalContent += '<table class="table table-bordered table-striped dataTable dtr-inline">';
                modalContent += '<thead><tr><th>ID</th><th>Fecha</th><th>Día</th><th>Hora 1</th><th>Hora 2</th><th>Hora 3</th><th>Hora 4</th><th>Min Retraso</th></tr></thead>';
                modalContent += '<tbody>';

                var totalRetrazo = 0;
                // Recorrer los datos de $calculosObj
                datos.forEach(function(calculo, index) {
                    modalContent += '<tr data-calculo=\'' + JSON.stringify(calculo) + '\'>';
                    modalContent += '<td>' + (calculo.id_calculo_dia !== null ? calculo.id_calculo_dia : '') + '</td>';
                    modalContent += '<td>' + (calculo.fecha !== null ? calculo.fecha : '') + '</td>';
                    modalContent += '<td>' + (calculo.dia !== null ? calculo.dia : '') + '</td>';
                    modalContent += '<td><input class="form-control" type="text" name="hora1" value="' + (calculo.hora1 !== null ? calculo.hora1 : '') + '"></td>';
                    modalContent += '<td><input class="form-control" type="text" name="hora2" value="' + (calculo.hora2 !== null ? calculo.hora2 : '') + '"></td>';
                    modalContent += '<td><input class="form-control" type="text" name="hora3" value="' + (calculo.hora3 !== null ? calculo.hora3 : '') + '"></td>';
                    modalContent += '<td><input class="form-control" type="text" name="hora4" value="' + (calculo.hora4 !== null ? calculo.hora4 : '') + '"></td>';
                    modalContent += '<td><input class="form-control" type="text" name="minretraso" value="' + (calculo.minretrazo !== null ? calculo.minretrazo : '') + '"></td>';
                    modalContent += '</tr>';
                });
                modalContent += '</tbody></table>';
                modalContent += '<div class="modal-footer justify-content-between">';
                modalContent += '<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>';
                modalContent += '<button type="button" class="btn btn-primary" id="guardarCambios">Guardar cambios</button>';
                modalContent += '</div>';
                modalContent += '</form>';
                $('.editar-marcacion-funcionario .modal-body').html(modalContent);
                $('#totalMin').val(minacum);
                $('#idCalculo').val(id);
                $('#modal-lg').modal('show');
            }).catch(function(error) {
                console.log("Error:", error);
            });
        });

        $(document).on("click", "#guardarCambios", function() {
            var datosMarcacion = [];
            $("#editarMarcacionForm tbody tr").each(function() {
                var fila = $(this);
                var id = fila.find("td:eq(0)").text();
                var hora1 = fila.find("input[name='hora1']").val();
                var hora2 = fila.find("input[name='hora2']").val();
                var hora3 = fila.find("input[name='hora3']").val();
                var hora4 = fila.find("input[name='hora4']").val();
                var minretraso = fila.find("input[name='minretraso']").val();

                datosMarcacion.push({
                    id_calculo_dia: id,
                    hora1: hora1,
                    hora2: hora2,
                    hora3: hora3,
                    hora4: hora4,
                    minretraso: minretraso
                });
            });
            var totalMin = $('#totalMin').val();
            var idCalculo = $('#idCalculo').val();

            console.log(datosMarcacion);
            console.log(totalMin);
            console.log(idCalculo);
            var formData = {
                datosMarcacion: datosMarcacion,
                totalMin: totalMin,
                idCalculo: idCalculo
            };
            $.ajax({
                type: 'POST',
                url: "<?= Route::route('guardarCambiosMarcacion', 'POST') ?>",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var url = "<?= Route::route('evento_listar', 'GET') ?>";
                        window.location.href = url;
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });
        });

        $(".ver-marcacion").on("click", function() {
            // Extraer el JSON del atributo data-calculo
            var calculoJson = $(this).data("calculo");
            var id = calculoJson.id;
            var nombre = calculoJson.nombre.toUpperCase();
            var mes = calculoJson.nombre_mes.toUpperCase();
            var minacum = calculoJson.totalretrazo;
            $('.ver-marcacion-funcionario .titulo-responsable').html('Editar marcacion funcionario(a): <b>' + nombre + '</b>, del mes de <b>' + mes + "</b>, Min Acum.: <b>" + minacum + "</b>");
            obtenerDetalleMarcacion(id).then(function(datos) {
                var modalContent = '<table class="table table-bordered table-striped dataTable dtr-inline">';
                modalContent += '<thead><tr><th>ID</th><th>Fecha</th><th>Día</th><th>Hora 1</th><th>Hora 2</th><th>Hora 3</th><th>Hora 4</th><th>Min Retraso</th><th>Localización ID</th></tr></thead>';
                modalContent += '<tbody>';

                datos.forEach(function(calculo) {
                    modalContent += '<tr>';
                    modalContent += '<td>' + (calculo.id_calculo_dia !== null ? calculo.id_calculo_dia : '') + '</td>';
                    modalContent += '<td>' + (calculo.fecha !== null ? calculo.fecha : '') + '</td>';
                    modalContent += '<td>' + (calculo.dia !== null ? calculo.dia : '') + '</td>';
                    modalContent += '<td>' + (calculo.hora1 !== null ? calculo.hora1 : '') + '</td>';
                    modalContent += '<td>' + (calculo.hora2 !== null ? calculo.hora2 : '') + '</td>';
                    modalContent += '<td>' + (calculo.hora3 !== null ? calculo.hora3 : '') + '</td>';
                    modalContent += '<td>' + (calculo.hora4 !== null ? calculo.hora4 : '') + '</td>';
                    modalContent += '<td>' + (calculo.minretrazo !== null ? calculo.minretrazo : '') + '</td>';
                    modalContent += '<td>' + (calculo.localizacion_id !== null ? calculo.localizacion_id : '') + '</td>';
                    modalContent += '</tr>';
                });

                modalContent += '</tbody></table>';

                // Insertar el contenido en el cuerpo del modal
                $('.ver-marcacion-funcionario .modal-body').html(modalContent);

                // Mostrar el modal
                $('#modal-xl').modal('show');
            }).catch(function(error) {
                console.log("Error:", error);
                // Opcional: manejar el error si es necesario
            });

        });

        $('#mostrar-contratos-por-mes').on('submit', function(e) {
            e.preventDefault();
            $('#loading-mostrar-por-tipo').show();
            var formData = {
                tipo_contrato: $('#tipo_contrato').val(),
                fechas: obtenerRangoFechasPorMes($('#mes_indicar_por_contrato').val())
            };

            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('listar_marcacion_por_tipo_y_mes', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#loading-mostrar-por-tipo').hide();
                    if (response.success) {
                        var nombreFile = response.nombre;
                        var pdfBase64 = response.pdf;
                        var link = document.createElement('a');
                        link.href = 'data:application/pdf;base64,' + pdfBase64;
                        link.download = nombreFile;
                        document.body.appendChild(link); // Agregamos el link al DOM
                        link.click();
                        document.body.removeChild(link);
                        showNotification('success', 'El archivo PDF se está descargando...');
                    } else {
                        showNotification('error', response.sms);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    $('#loading-mostrar-por-tipo').hide();
                }
            });
        });

        $('#mostrar-eventos-por-csv').on('submit', function(e) {
            e.preventDefault();
            var fechasElegidas = obtenerRangoFechasPorMes($('#mes_indicar_por_csv').val());

            var fileInput = $('#usuarios_faltantes')[0];
            if (!fileInput.files.length) {
                alert('Por favor, seleccione un archivo CSV.');
                return;
            }
            var file = fileInput.files[0];
            var reader = new FileReader();

            $('#loading-mostrar-por-csv').show();
            $('#mostrar-eventos-por-csv').hide();

            reader.onload = function(event) {
                var csvContent = event.target.result;
                var lines = csvContent.split('\n');
                var isValid = true;
                var invalidRows = [];
                var validData = [];

                // Expresión regular para extraer números enteros
                var ciPattern = /^\d+/;

                // Validar las filas
                for (var i = 1; i < lines.length; i++) {
                    var cells = lines[i].split(';');

                    // Verificar si la línea está vacía
                    if (cells.length < 3 || cells.join('').trim() === '') continue;

                    if (cells.length !== 3) {
                        isValid = false;
                        invalidRows.push(i + 1); // Filas inválidas
                        continue;
                    }

                    // Validar que la primera columna sea un entero
                    var ciRaw = cells[0].trim();
                    var nombre = cells[1].trim();
                    var cargo = cells[2].trim();

                    // Extraer solo números del CI
                    var ciMatch = ciRaw.match(ciPattern);
                    var ci = ciMatch ? ciMatch[0] : ''; // Extrae el primer número entero encontrado
                    if (!/^\d+$/.test(ci)) { // Verifica si CI es un número entero
                        isValid = false;
                        invalidRows.push(i + 1);
                        continue; // No procesar esta fila
                    }

                    // Validar que nombre y cargo sean cadenas de texto
                    if (nombre.length === 0 || cargo.length === 0) {
                        isValid = false;
                        invalidRows.push(i + 1);
                        continue; // No procesar esta fila
                    }
                    // Agregar datos válidos a la lista
                    validData.push({
                        ci: ci,
                        nombre: nombre,
                        cargo: cargo
                    });
                }

                if (isValid) {
                    sendToServer(validData);
                } else {
                    alert('El archivo CSV tiene filas con un formato incorrecto en las filas: ' + invalidRows.join(', '));
                    // Volver a mostrar el formulario
                    $('#loading-mostrar-por-csv').hide();
                    $('#mostrar-eventos-por-csv').show();
                }
            };

            reader.onerror = function() {
                alert('Error al leer el archivo CSV.');
                // Volver a mostrar el formulario
                $('#loading-mostrar-por-csv').hide();
                $('#mostrar-eventos-por-csv').show();
            };
            reader.readAsText(file);

            function sendToServer(data) {
                // Mostrar el indicador de carga
                $('#loading-mostrar-por-csv').show();
                $('#mostrar-eventos-por-csv').hide();
                formData = JSON.stringify({
                    datos: data,
                    fechas: fechasElegidas,
                });
                $.ajax({
                    url: "<?= \lib\Route::route('listar_marcacion_por_CSV', 'POST') ?>", // Cambia esta URL a la ruta correcta
                    method: 'POST',
                    contentType: 'application/json',
                    data: formData,
                    success: function(response) {
                        $('#loading-mostrar-por-csv').hide();
                        $('#mostrar-eventos-por-csv').show();
                        if (response.success) {
                            var nombreFile = response.nombre;
                            var pdfBase64 = response.pdf;
                            var link = document.createElement('a');
                            link.href = 'data:application/pdf;base64,' + pdfBase64;
                            link.download = nombreFile;
                            document.body.appendChild(link); // Agregamos el link al DOM
                            link.click();
                            document.body.removeChild(link);
                            showNotification('success', 'El archivo PDF se está descargando...');
                        } else {
                            showNotification('error', response.sms);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Ocultar el indicador de carga y volver a mostrar el formulario
                        $('#loading-mostrar-por-csv').hide();
                        $('#mostrar-eventos-por-csv').show();
                        console.error('Error en la solicitud:', error);
                        showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    }
                });
            }
        });

        $('#obtener-marcacion-funcionario-por-mes').on('submit', function(e) {
            e.preventDefault();
            $('#loading-mostrar-por-mes').show();
            var mesInicial = $('#mes_inicial').val();
            var mesFinal = $('#mes_final').val();
            var formData = {
                ci: $('#datos_funcionario').val(),
                arrayFechas: generarArrayFechasPorMes(mesInicial, mesFinal),
            };

            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('listar_marcacion_por_mes', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#loading-mostrar-por-mes').hide();
                    if (response.success) {
                        var nombreFile = response.nombre;
                        var pdfBase64 = response.pdf;
                        var link = document.createElement('a');
                        link.href = 'data:application/pdf;base64,' + pdfBase64;
                        link.download = nombreFile;
                        document.body.appendChild(link); // Agregamos el link al DOM
                        link.click();
                        document.body.removeChild(link);
                        showNotification('success', 'El archivo PDF se está descargando...');

                    } else {
                        showNotification('error', response.sms);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    $('#loading-mostrar-por-mes').hide();
                }
            });
        });

        function generarArrayFechasPorMes(mes_ini, mes_fin) {
            // Convertir los meses inicial y final a enteros
            var mesInicial = parseInt(mes_ini);
            var mesFinal = parseInt(mes_fin);

            // Validar que el mes inicial sea menor o igual que el mes final
            if (mesInicial > mesFinal) {
                console.error("El mes inicial debe ser menor o igual que el mes final");
                return [];
            }

            var fechasArray = [];

            // Función auxiliar para obtener el mes en formato MM
            function getMesEnFormato(mes) {
                return mes < 10 ? "0" + mes : mes;
            }

            // Obtener el año actual
            var anioActual = new Date().getFullYear();

            // Iterar sobre los meses entre mes_ini y mes_fin
            for (var mes = mesInicial; mes <= mesFinal; mes++) {
                var mesStr = getMesEnFormato(mes);

                // Obtener el rango de fechas para el mes actual usando la función existente
                var rangoFechas = obtenerRangoFechasPorMes(mesStr);
                fechasArray.push(rangoFechas);
            }

            return fechasArray;
        }

        function obtenerDetalleMarcacion(id) {
            return new Promise(function(resolve, reject) {
                var formData = {
                    idCalculo: id,
                };
                $.ajax({
                    type: 'POST',
                    url: "<?= \lib\Route::route('verMarcacion_funcionario', 'POST') ?>",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            resolve(response.datos);
                        } else {
                            showNotification('error', response.sms); // Manejo de errores de respuesta
                            reject(response.sms);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                        showNotification('error', 'Se produjo un error al procesar su solicitud.');
                        reject('Error en la solicitud AJAX');
                    }
                });
            });
        }

        function obtenerRangoFechasPorMes(mes) {
            // Obtener el año actual
            var anioActual = new Date().getFullYear();

            // Si el mes es enero (01), restamos un año para el mes anterior (diciembre del año anterior)
            var anioMesAnterior = (mes === '01') ? anioActual - 1 : anioActual;

            // Crear las fechas de los meses
            var fecha1, fecha2;

            // Convertir el mes a entero para hacer cálculos
            var mesInt = parseInt(mes);

            // Obtener el mes anterior
            var mesAnterior = mesInt - 1;

            // Si el mes es enero (01), el mes anterior será diciembre (12 del año anterior)
            if (mesInt === 1) {
                fecha1 = (anioMesAnterior) + "-12-21";
                fecha2 = anioActual + "-01-20";
            } else {
                // Si es cualquier otro mes, simplemente restamos 1 al mes actual
                // Convertimos el mes a dos dígitos si es necesario
                fecha1 = anioActual + "-" + (mesAnterior < 10 ? "0" + mesAnterior : mesAnterior) + "-21";
                fecha2 = anioActual + "-" + (mesInt < 10 ? "0" + mesInt : mesInt) + "-20";
            }

            return {
                fecha1: fecha1,
                fecha2: fecha2
            };
        }

        function showNotification(icon, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 5000
            });
        }
    });
</script>