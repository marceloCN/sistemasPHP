<?php

use lib\Route;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= Route::route('dashboard', 'GET') ?>" class="brand-link">
        <img src="/palmas.jpg" alt="logo palmas" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light"><?= ($_SESSION[constant("APP")]["ADM"] === "SI" ? 'Administrador' : ('Funcionario (a)<br>' . $_SESSION[constant('APP')]['nombre'])) ?></span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Eventos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('evento_listar', 'GET') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Eventos</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Funcionarios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('funcionarios', 'GET') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Funcionarios</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Configuraciones
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('configuracion', 'GET') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Modificar configuracion</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">Mas opciones...</li>
                <li class="nav-item">
                    <a href="<?= Route::route('logout', 'GET') ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cerrar Session</p>
                    </a>
                </li>


            </ul>
        </nav>

    </div>
</aside>