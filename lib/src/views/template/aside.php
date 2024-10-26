<?php

use lib\Route;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= Route::route('backend.dashboard') ?>" class="brand-link">
        <img src="/backend/logo.ico" alt="logo palmas" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Administrador</span>
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
                            Enrutadores
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.router') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Metodos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.router.documentacion') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Documentacion</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Controladores
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.controlador') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar controlador</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.controlador.documentacion') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Documentacion</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Modelos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.modelo') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar modelos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.modelo.documentcacion') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Documentacion</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Vistas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.vista') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Vistas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.vista.documentacion') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Documentacion</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            middlewares
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.middleware') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar midlewares</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::route('backend.middleware.documentacion') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Documentacion</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">Mas opciones...</li>
                <li class="nav-item">
                    <a href="<?= Route::route('backend.logout') ?>" class="nav-link" id="logout-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cerrar Session</p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</aside>