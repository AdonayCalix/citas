<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:06
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
<?php

require_once("header.php");

?>
<?php if ($_SESSION["citas"] == 1) {
    ?>
    <div class="wrapper">
        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Listado de Citas</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Citas
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
        <!--End Page Title-->
        <!-- Start responsive Table-->
        <div class="white-box">
            <div id="resultados_ajax"></div>
            <h3><span class="">
                    <button type="button" class="btn btn-info" id="add_button" onclick="limpiar()"
                            data-toggle="modal" data-target="#citaModal">
                        <span class="btn-label"><i class=" icon-plus"></i></span>Nuevo
                    </button>
                </span>
            </h3>
            <hr>
            <div class="table-responsive">
                <table id="cita_data" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Identidad</th>
                        <th>Paciente</th>
                        <th>Lugar</th>
                        <th>Hora</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Historial</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- End responsive Table-->
        <!--VISTA MODAL PARA VER DETALLE CITAL-->
        <?php require_once("modal/detalle_cita_modal.php"); ?>
        <!--VISTA MODAL PARA EDITAR CITA-->
        <?php require_once("modal/editar_cita_modal.php"); ?>

        <!-- Inicio del modal Eliminar -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Eliminar Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas seguro de eliminar el paciente?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Eliminar -->
    </div>
    <!-- End Wrapper-->
    <?php  } else {

        require("noacceso.php");
    }

    ?><!--CIERRE DE SESSION DE PERMISO -->

    <?php
    require_once("footer.php");
    ?>
    <script type="text/javascript" src="js/citas.js"></script>
    <?php

} else {
    header("Location:" . Conectar::ruta() . "index.php");
}


?>
