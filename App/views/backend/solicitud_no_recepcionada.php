<?php

use lib\Route;

?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="pt-2 px-3">
                        <h3 class="card-title">Opciones:</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">faltantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">finalizadas</a>
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
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>