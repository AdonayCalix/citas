<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 24/07/2018
 * Time: 14:07
 */
require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    ?>
    <!-- INICIO DEL HEADER - LIBRERIAS -->
    <?php require_once("header.php"); ?>

    <!-- FIN DEL HEADER - LIBRERIAS -->

    <!-- Contenido Principal -->
    <div class="wrapper">
        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Citas por Fecha</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Citas por Fecha
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
        <!--End Page Title-->
        <div class="row">
            <div class="panel-wrap">
                <div class="col-md-12">
                    <div class="panel panel-border  panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Consulta de Citas por Fecha</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form class="">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Rango de Fechas</label>
                                            <div class="col-md-9">
                                                <div class="input-daterange input-group">
                                                    <input type="text" class="form-control" name="datepicker" id="datepicker" placeholder="Fecha Inicial">
                                                    <span class="input-group-addon no-border text-white">A</span>
                                                    <input type="text" class="form-control" name="datepicker2" id="datepicker2" placeholder="Fecha Final">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary" id="btn_cita_fecha"><i
                                                    class="fa fa-search" aria-hidden="true"></i> Consultar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--Start row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">
                                        <h2 class="header-title">Lista de Citas por Fecha</h2>
                                        <table id="citas_fecha_data" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Ver Detalle</th>
                                                <th>Identidad</th>
                                                <th>Paciente</th>
                                                <th>Lugar</th>
                                                <th>Hora</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>

                                            </tr>
                                            </thead>


                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--VISTA MODAL PARA VER DETALLE CITAL-->
        <?php require_once("modal/detalle_cita_modal.php");?>
    </div>

    <!-- /Fin del contenido principal -->

    <?php require_once("footer.php"); ?>

    <!--AJAX PROVEEDORES-->
    <script type="text/javascript" src="js/citas.js"></script>


    <?php

} else {

    header("Location:" . Conectar::ruta() . "vistas/index.php");
}

?>