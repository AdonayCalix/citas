<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 28/07/2018
 * Time: 14:52
 */

require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    require_once("../modelos/Pacientes.php");
    $paciente = new Pacientes();

    $pac = $paciente->get_pacientes();

    ?>
    <?php

    require_once("header.php");

    ?>
    <div class="wrapper">
        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Historial Clinico por Paciente</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Historial Clinico
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
        <!--End Page Title-->
        <!-- Start responsive Table-->
        <div class="white-box">
            <div id="resultados_ajax"></div>
            <h3>
                <span class="">
                    <button type="button" class="btn btn-info" id="add_button" onclick="limpiar()"
                            data-toggle="modal" data-target="#pacienteHistorialModal">
                        <span class="btn-label"><i class="icon-plus"></i></span>Nuevo
                    </button>
                </span>
            </h3>
            <hr>
            <div class="table-responsive">
                <table id="pacienteHistorial_data" class="table table-bordered table-striped" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Identidad</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Sexo</th>
                        <th>Tipo Sangre</th>
                        <th>Edad</th>
                        <th>Ultima Cita</th>
                        <th>Fecha Registro</th>
                        <th>Mas Detalles</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- End responsive Table-->
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="pacienteHistorialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Agregar Pacientes</h4>
                    </div>
                    <form method="post" id="pacienteHistorial_form" enctype="multipart/form-data" class="form-horizontal">
                        <div class="modal-body">
                            <section class="formulario-agregar_pacienteHistorial">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Paciente</label>
                                            <div class="col-md-9">
                                                <!--                                                <input type="text" name="paciente" id="paciente" class="form-control"/>-->
                                                <select class="form-control selectpicker" id="paciente" name="paciente"
                                                        data-live-search="true" required>
                                                    <option value="0">Seleccione el Paciente</option>
                                                    <?php
                                                    for ($i = 0; $i < sizeof($pac); $i++) {
                                                        ?>
                                                        <option value="<?php echo $pac[$i]["id_paciente"] ?>"><?php echo $pac[$i]["identidad"]." ".$pac[$i]["nombre"]." ".$pac[$i]["apellido"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Padecimientos</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="padecimientos" name="padecimientos"
                                                          placeholder="Padecimientos ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Alergias</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="alergias" name="alergias"
                                                          placeholder="Alergias ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Ultima Cita</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="datepicker2"
                                                       name="datepicker2" placeholder="Ultima Cita..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Receta</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="receta" name="receta"
                                                          placeholder="Receta ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="modal-footer">

                            <input type="hidden" name="id_usuario" id="id_usuario"
                                   value="<?php echo $_SESSION["id_usuario"]; ?>"/>

                            <input type="hidden" name="id_historial" id="id_historial"/>

                            <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left"
                                    value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                            </button>

                            <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fa fa-times" aria-hidden="true"></i> Cerrar
                            </button>

                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <!--VISTA MODAL PARA VER DETALLE PACIENTE EN VISTA MODAL-->
        <?php require_once("modal/detalle_paciente_modal.php");?>
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

    <?php

    require_once("footer.php");
    ?>

    <script type="text/javascript" src="js/pacientesHistorial.js"></script>


    <?php

} else {

    header("Location:" . Conectar::ruta() . "index.php");

}


?>
