<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 24/07/2018
 * Time: 14:08
 */
require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    require_once("../modelos/Pacientes.php");
    $paciente = new Pacientes();
    $pac = $paciente->get_pacientes();

    require_once("../modelos/Medicos.php");
    $medico = new Medicos();
    $med = $medico->get_medicos();
    ?>
    <!-- INICIO DEL HEADER - LIBRERIAS -->
    <?php require_once("header.php"); ?>

    <!-- FIN DEL HEADER - LIBRERIAS -->

    <!-- Contenido Principal -->
    <div class="wrapper">
        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Reportes por Medico</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Reportes por Medico
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
                            <h3 class="panel-title">Reporte de Citas por Medico</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form class="">
                                    <div class="col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Medico</label>
                                            <div class="col-md-9">
                                                <select class="form-control selectpicker" id="medico" name="medico"
                                                        data-live-search="true" required>
                                                    <option value="0">Seleccione el Medico</option>
                                                    <?php
                                                    for ($i = 0; $i < sizeof($med); $i++) {
                                                        ?>
                                                        <option value="<?php echo $med[$i]["id_medico"] ?>"><?php echo $med[$i]["identidad"] . " " . $med[$i]["nombre"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <button type="button" class="btn btn-primary" id="btn_cita_medico"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>
                                    </div>
                                </form>
                            </div>
                            <!--Start row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">
                                        <h2 class="header-title">Lista de Pacientes por Medico</h2>
                                        <table id="citas_medico_data" class="display table" cellspacing="0" width="100%">
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