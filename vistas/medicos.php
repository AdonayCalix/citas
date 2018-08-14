<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:06
 */
require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    ?>
    <?php

    require_once("header.php");

    ?>
<?php if ($_SESSION["medicos"] == 1) {

    ?>
    <div class="wrapper">
        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Listado de Medicos</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Medicos
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
                            data-toggle="modal" data-target="#medicoModal">
                        <span class="btn-label"><i class="icon-plus"></i></span>Nuevo
                    </button>
                </span>
            </h3>
            <hr>
            <div class="table-responsive">
                <table id="medico_data" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Identidad</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Sexo</th>
                        <th>Nacimiento</th>
                        <th>Edad</th>
                        <th>Telefono</th>
                        <th>Especialidad</th>
                        <th>Correo</th>
                        <th>Historial</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- End responsive Table-->
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="medicoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Agregar Medicos</h4>
                    </div>
                    <form method="post" id="medico_form" enctype="multipart/form-data" class="form-horizontal">
                        <div class="modal-body">
                            <section class="formulario-agregar_medico">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="text-input">Identidad</label>
                                            <div class="col-md-9">
                                                <input type="text" name="identidad" id="identidad" class="form-control"
                                                       placeholder="Identidad"
                                                       required pattern="[0-9]{0,15}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Nombres</label>
                                            <div class="col-md-9">
                                                <input type="text" name="nombre" id="nombre" class="form-control"
                                                       placeholder="Nombres"
                                                       required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Apellidos</label>
                                            <div class="col-md-9">
                                                <input type="text" name="apellido" id="apellido" class="form-control"
                                                       placeholder="Apellidos" required
                                                       pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Genero</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="genero" name="genero" required>
                                                    <option value="" selected>Selecciona Sexo</option>
                                                    <option value="0">Masculino</option>
                                                    <option value="1">Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Fecha Nacimiento</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="datepicker2"
                                                       name="datepicker2"
                                                       placeholder="Fecha Nacimiento">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Edad</label>
                                            <div class="col-md-9">
                                                <input type="text" name="edad" id="edad" class="form-control"
                                                       placeholder="Edad" required pattern="[0-9]{0,15}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Teléfono</label>
                                            <div class="col-md-9">
                                                <input type="text" name="telefono" id="telefono" class="form-control"
                                                       placeholder="Teléfono" required pattern="[0-9]{0,15}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Correo</label>
                                            <div class="col-md-9">
                                                <input type="email" name="correo" id="correo" class="form-control"
                                                       placeholder="Correo" required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Dirección</label>
                                            <div class="col-md-9">
                                            <textarea cols="86" rows="3" id="direccion" name="direccion"
                                              placeholder="Direccion ..." required
                                              pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                            </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Especialidad</label>
                                            <div class="col-md-9">
                                            <textarea cols="86" rows="3" id="especialidad" name="especialidad"
                                                      placeholder="Especialidad ..." required
                                                      pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                            </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="modal-footer">

                            <input type="hidden" name="id_medico" id="id_medico"/>

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
    <script type="text/javascript" src="js/medicos.js"></script>
    <?php

} else {

    header("Location:" . Conectar::ruta() . "index.php");

}


?>
