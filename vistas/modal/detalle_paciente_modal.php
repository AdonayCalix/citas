<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="detalle_paciente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Detalle de Historial de Paciente</h4>
            </div>
            <form method="post" id="" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-body">
                    <!--Start row-->
                    <div class="row">
                        <div class="panel-wrap">
                            <div class="col-md-12">
                                <div class="panel panel-border  panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Detalle Historial</h3>
                                    </div>
                                    <div class="panel-body">
                                        <section class="">
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
                                                        <label class="col-md-3 form-control-label" for="email-input">Tipo de
                                                            Sangre</label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" id="tipoSangre" name="tipoSangre" required>
                                                                <option value="" selected>Selecciona tipo sangre</option>
                                                                <option value="ON">O negativo</option>
                                                                <option value="OP">O positivo</option>
                                                                <option value="AN">A negativo</option>
                                                                <option value="AP">A positivo</option>
                                                                <option value="BN">B negativo</option>
                                                                <option value="BP">B positivo</option>
                                                                <option value="ABN">AB negativo</option>
                                                                <option value="ABP">AB positivo</option>
                                                            </select>
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
                                                               for="email-input">Padecimientos</label>
                                                        <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="padecimientos1" name="padecimientos1"
                                                          placeholder="Padecimientos ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label"
                                                               for="email-input">Alergias</label>
                                                        <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="alergias1" name="alergias1"
                                                          placeholder="Alergias ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Ultima Cita</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="datepicker21"
                                                                   name="datepicker21" placeholder="Ultima Cita..">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label"
                                                               for="email-input">Receta</label>
                                                        <div class="col-md-9">
                                                <textarea class="form-control" rows="3" id="receta1" name="receta1"
                                                          placeholder="Receta ..."
                                                          pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End row-->
                </div>

                <div class="modal-footer">

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