<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 24/07/2018
 * Time: 14:08
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
                            <h3 class="panel-title">Consulta de Citas por Mes</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form class="">
                                    <div class="col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            <select name="mes" id="mes" class="form-control">
                                                <option value="">MES</option>
                                                <option value="01">ENERO</option>
                                                <option value="02">FEBRERO</option>
                                                <option value="03">MARZO</option>
                                                <option value="04">ABRIL</option>
                                                <option value="05">MAYO</option>
                                                <option value="06">JUNIO</option>
                                                <option value="07">JULIO</option>
                                                <option value="08">AGOSTO</option>
                                                <option value="09">SEPTIEMBRE</option>
                                                <option value="10">OCTUBRE</option>
                                                <option value="11">NOVIEMBRE</option>
                                                <option value="12">DICIEMBRE</option>
                                            </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            <select name="ano" id="ano" class="form-control">
                                                <option value="">AÑO</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <button type="button" class="btn btn-primary" id="btn_cita_fecha_mes"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>
                                    </div>
                                </form>
                            </div>
                            <!--Start row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">
                                        <h2 class="header-title">Lista de Citas por Fecha</h2>
                                        <table id="citas_fecha_mes_data" class="table table-bordered table-striped" cellspacing="0" width="100%">
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