<?php

use lib\Route;

?>
<section class="content">

    <div class="card-body">

        <div class="row">

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="solicitudes-faltantes">10</h3>
                        <p>Solicitudes Faltantes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Solicitudes Ejecutadas -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="solicitudes-ejecutadas">25</h3>
                        <p>Solicitudes Ejecutadas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Trabajos Soporte Finalizados -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="soporte-finalizados">15</h3>
                        <p>Trabajos Soporte Finalizados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Trabajos de Sistemas Finalizados -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3 id="sistemas-finalizados">12</h3>
                        <p>Trabajos Sistemas Finalizados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <strong>Nombre:</strong> <?= $_SESSION[constant('APP')]['nombre'] ?><br>
                        <strong>cargo:</strong> <?= $_SESSION[constant('APP')]['cargo'] ?><br>
                        <strong>Correo Electrónico:</strong> <?= $_SESSION[constant('APP')]['email'] ?><br>
                        <strong>Teléfono:</strong> <?= $_SESSION[constant('APP')]['telefono'] ?><br>
                        <strong>Rol:</strong> <?= $_SESSION[constant('APP')]['if_director'] ? 'Es Director Responsable' : 'Funcionario(a) publico' ?><br>
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comunicados</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Comunicado 1:</strong> Se realizará mantenimiento el próximo viernes.</li>
                            <li><strong>Comunicado 2:</strong> Reunión de equipo el lunes a las 10 AM.</li>
                            <li><strong>Comunicado 3:</strong> Nuevas políticas de seguridad a partir del 1 de noviembre.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>