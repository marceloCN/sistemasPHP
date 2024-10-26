<?php

use lib\Route;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= Route::route('dashboard') ?>" class="brand-link">
        <span class="brand-text font-weight-light">Bienvenido (a)<br><?= $_SESSION[constant('APP')]['nombre'] ?></span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Panel de Control</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-car"></i>
                        <p>
                            Gestion de solicitudes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('solicitud_recepcionada_listar') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Solicitudes Recepcionadas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('solicitud_no_recepcionada_listar') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Solicitudes no recepcionadas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Gestion de Soporte
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('listar_soporte') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar trabajos</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Gestion de Sistemas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('listar_sistema') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar trabajos</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Mas opciones...</li>
                <li class="nav-item">
                    <a href="<?= Route::route('logout') ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cerrar Session</p>
                    </a>
                </li>


            </ul>
        </nav>

    </div>
</aside>