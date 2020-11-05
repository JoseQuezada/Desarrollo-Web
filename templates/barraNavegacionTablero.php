<?php

require('./php/validacionUsuario.php');

// echo var_dump($_SESSION);

?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="tablero.php"></a>
    <!--Hola estoy bien-->
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="./ActualizarUsuario.php">Ajustes</a>
                <a class="dropdown-item" href="#">Actividad</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="./cerrarSesion.php">Cerrar Sesión</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <a class="nav-link" href="tablero.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Panel de Control
                    </a>
                    <div class="sb-sidenav-menu-heading">Gastos</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProvedores" aria-expanded="false" aria-controls="collapseProvedores">

                        <div class="sb-nav-link-icon"><i class="fas fa-people-carry"></i></i></div>
                        Proveedores
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseProvedores" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="proveedor.php"><i class="far fa-plus-square"></i>&nbsp;Agregar</a>
                            <a class="nav-link" href="ListarProveedor.php"><i class="fas fa-th-list"></i>&nbsp;Listado</a>
                        </nav>
                    </div>



                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInsumos" aria-expanded="false" aria-controls="collapseInsumos">
                        <div class="sb-nav-link-icon"><i class="fas fa-stroopwafel"></i></div>
                        Insumos
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseInsumos" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="AgregarInsumo.php"><i class="far fa-plus-square"></i>&nbsp;Agregar</a>
                            <a class="nav-link" href="ListarInsumo.php"><i class="fas fa-th-list"></i>&nbsp;Listado</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras">

                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Compras
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="AgregarCompra.php"><i class="far fa-plus-square"></i>&nbsp;Agregar</a>
                            <a class="nav-link" href="ListarCompra.php"><i class="fas fa-th-list"></i>&nbsp;Listado</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Ingresos</div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="false" aria-controls="collapseClientes">

                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Clientes
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseClientes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="AgregarCliente.php"><i class="far fa-plus-square"></i>&nbsp;Agregar</a>
                            <a class="nav-link" href="ListarCliente.php"><i class="fas fa-th-list"></i>&nbsp;Listado</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVentas" aria-expanded="false" aria-controls="collapseVentas">

                        <div class="sb-nav-link-icon"><i class="fas fa-universal-access"></i></div>
                        Ventas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseVentas" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="AgregarVenta.php"><i class="far fa-plus-square"></i>&nbsp;Agregar</a>
                            <a class="nav-link" href="ListarVenta.php"><i class="fas fa-th-list"></i>&nbsp;Listado</a>
                        </nav>
                    </div>

                    </a>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">

                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Reportes
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseReportes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="ReporteInsumos.php"><i class="fas fa-stroopwafel"></i>&nbsp;Insumos</a>
                            <a class="nav-link" href="ReporteCompras.php"><i class="fas fa-users"></i>&nbsp;Compras</a>
                            <a class="nav-link" href="ReporteVentas.php"><i class="fas fa-universal-access"></i>&nbsp;Ventas</a>
                            <a class="nav-link" href="ReporteClientes.php"><i class="fas fa-users"></i>&nbsp;Clientes</a>
                            <a class="nav-link" href="ReporteProveedores.php"><i class="fas fa-parachute-box"></i>&nbsp;Proveedores</a>
                        </nav>
                    </div>
                    <?php if ($_SESSION['ID_Tipo'] == 1 or $_SESSION['ID_Tipo'] == 2) : ?>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Usuarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseUsuarios" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="registr.php"><i class="far fa-plus-square"></i>&nbsp;Agregar Usuario</a>
                                <a class="nav-link" href="ListarUsuarios.php"><i class="fas fa-th-list"></i>&nbsp;Listado Usuarios</a>
                            </nav>
                        </div>
                    <?php endif ?>

                </div>
            </div>

        </nav>
    </div>