<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="citaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Citas</h4>
            </div>
            <form method="post" id="cita_form" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-body">
                    <section class="formulario-agregar_cita">
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
                                                <option value="<?php echo $pac[$i]["id_paciente"] ?>"><?php echo $pac[$i]["identidad"] . " " . $pac[$i]["nombre"] . " " . $pac[$i]["apellido"]; ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Lugar</label>
                                    <div class="col-md-9">
                                        <input type="text" name="lugar" id="lugar" class="form-control"
                                               placeholder="Lugar"
                                               required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label"
                                           for="email-input">Medico</label>
                                    <div class="col-md-9">
                                        <select class="form-control selectpicker" id="medico" name="medico"
                                                data-live-search="true" required>
                                            <option value="0">Seleccione el Medico</option>
                                            <?php
                                            for ($i = 0; $i < sizeof($med); $i++) {
                                                ?>
                                                <option value="<?php echo $med[$i]["id_medico"] ?>"><?php echo $med[$i]["identidad"] . " " . $med[$i]["nombre"] . " " . $med[$i]["apellido"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label"
                                           for="email-input">Hora de Cita</label>
                                    <div class="col-md-9">
                                        <div class="bootstrap-timepicker">
                                            <input id="timepicker2" name="timepicker" type="text"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Fecha de Cita</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="datepicker2"
                                               name="datepicker2"
                                               placeholder="Fecha de Cita">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label"
                                           for="email-input">Medicamentos</label>
                                    <div class="col-md-9">
                                            <textarea class="form-control" rows="3" id="medicamentos"
                                                      name="medicamentos"
                                                      placeholder="Medicamentos ..." required
                                                      pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label"
                                           for="email-input">Prescripcion</label>
                                    <div class="col-md-9">
                                            <textarea class="form-control" rows="3" id="prescripcion"
                                                      name="prescripcion"
                                                      placeholder="Prescripcion ..." required
                                                      pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label"
                                           for="email-input">Sintomas</label>
                                    <div class="col-md-9">
                                            <textarea class="form-control" rows="3" id="sintomas" name="sintomas"
                                                      placeholder="Sintomas ..." required
                                                      pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Estado</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="">Selecciona estado</option>
                                            <option value="1" selected>PENDIENTE</option>
                                            <option value="0">ATENDIDO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="id_usuario" id="id_usuario"
                           value="<?php echo $_SESSION["id_usuario"]; ?>"/>

                    <input type="hidden" name="id_cita" id="id_cita"/>

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