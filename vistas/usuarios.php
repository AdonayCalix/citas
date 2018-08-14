<?php

require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    ?>
    <?php

    require_once("header.php");

    ?>
<?php if ($_SESSION["usuarios"] == 1) {

    ?>
    <div class="wrapper">

        <!--Start Page Title-->
        <div class="page-title-box">
            <h4 class="page-title">Listado de Usuarios</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li class="active">
                    Usuarios
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
                            data-toggle="modal" data-target="#usuarioModal">
                        <span class="btn-label"><i class="icon-plus"></i></span>Nuevo
                    </button>
                </span>
            </h3>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped" id="usuario_data" class="table table-bordered table-striped"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Opciones</th>
                        <th>Cédula</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Cargo</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Fecha Ingreso</th>
                        <th>Estado</th>
                        <th>Foto</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- End responsive Table-->
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">Agregar usuarios</h4>
                    </div>
                    <form method="post" id="usuario_form" enctype="multipart/form-data" class="form-horizontal">
                        <div class="modal-body">
                            <section class="formulario-agregar_usuario">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="text-input">Cédula</label>
                                            <div class="col-md-9">
                                                <input type="text" name="cedula" id="cedula" class="form-control"
                                                       placeholder="Cédula"
                                                       required pattern="[0-9]{0,15}"/>
                                                <!--                                <span class="help-block">(*) Ingrese la cedula</span>-->
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
                                            <label class="col-md-3 form-control-label" for="email-input">Cardo</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="cargo" name="cargo" required>
                                                    <option value="">-- Selecciona cargo --</option>
                                                    <option value="1" selected>Medico</option>
                                                    <option value="0">Empleado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                            <div class="col-md-9">
                                                <input type="text" name="usuario" id="usuario" class="form-control"
                                                       placeholder="Usuario" required
                                                       pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Password</label>
                                            <div class="col-md-9">
                                                <input type="password" name="password1" id="password1"
                                                       class="form-control"
                                                       placeholder="Password" required/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Repita
                                                Password</label>
                                            <div class="col-md-9">
                                                <input type="password" name="password2" id="password2"
                                                       class="form-control"
                                                       placeholder="Repita Password" required/>
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
                                                <input type="email" name="email" id="email" class="form-control"
                                                       placeholder="Correo" required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label"
                                                   for="email-input">Dirección</label>
                                            <div class="col-md-9">
                                    <textarea cols="80" rows="3" id="direccion" name="direccion"
                                              placeholder="Direccion ..." required
                                              pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="email-input">Estado</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="estado" name="estado" required>
                                                    <option value="">-- Selecciona estado --</option>
                                                    <option value="1" selected>Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="col-sm-7 col-lg-offset-3 col-sm-offset-3">
                                                <input type="file" id="usuario_imagen" name="usuario_imagen">
                                                <span id="usuario_uploaded_image"></span>
                                            </div>
                                        </div>
                                        <!--LISTA DE PERMISOS-->
                                        <div class="form-group">
                                            <label for="" class="col-md-3 form-control-label">Permisos</label>
                                            <div class="col-lg-6">
                                                <ul style="list-style:none;" id="permisos">

                                                </ul>
                                            </div>
                                        </div>
                                        <!--FIN LISTA DE PERMISOS-->
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="modal-footer">

                            <input type="hidden" name="id_usuario" id="id_usuario"/>

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
                        <p>Estas seguro de eliminar la categoría?</p>
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

    <script type="text/javascript" src="js/usuarios.js"></script>


    <?php

} else {

    header("Location:" . Conectar::ruta() . "index.php");

}


?>

