<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="detalle_cita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content bg-info">
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
                                <div class="panel panel-border  panel-warning">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Detalle Historial</h3>
                                    </div>
                                    <div class="panel-body">
                                        <!--Start row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="white-box">
                                                    <h2 class="header-title">Paciente</h2>
                                                    <table id="example2" class="display table">
                                                        <thead>
                                                        <tr>
                                                            <th>Identidad</th>
                                                            <th>Paciente</th>
                                                            <th>Genero</th>
                                                            <th>Edad</th>
                                                            <th>Medico</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><h5 id="identidad"><input type="hidden" name="identidad" id="identidad" class="form-control"/></h5></td>
                                                            <td><h5 id="nombre"><input type="hidden" name="nombre" id="nombre" class="form-control"/></h5></td>
                                                            <td><h5 id="genero"><input type="hidden" name="genero" id="genero" class="form-control"/></h5></td>
                                                            <td><h5 id="edad"><input type="hidden" name="edad" id="edad" class="form-control"/></h5></td>
                                                            <td><h5 id="medicoDetalle"><input type="hidden" name="medicoDetalle" id="medicoDetalle" class="form-control"/></h5></td>

                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <h2 class="header-title">Detalle Cita</h2>
                                                    <table id="example1" class="display table">
                                                        <thead>
                                                        <tr>
                                                            <th>Lugar</th>
                                                            <th>Hora</th>
                                                            <th>Fecha</th>
                                                            <th>Estado</th>
                                                            <th>Fecha Ingreso</th>
                                                        </tr>
                                                        </thead>
<!--                                                            <tfoot>-->
<!--                                                            <tr>-->
<!--                                                                <th>Lugar</th>-->
<!--                                                                <th>Hora</th>-->
<!--                                                                <th>Fecha</th>-->
<!--                                                                <th>Estado</th>-->
<!--                                                                <th>Fecha Ingreso</th>-->
<!--                                                            </tr>-->
<!--                                                            </tfoot>-->
                                                        <tbody>
                                                        <tr>
                                                            <td><h5 id="lugarDet"><input type="hidden" name="lugarDet" id="lugarDet" class="form-control"/></h5></td>
                                                            <td><h5 id="horaDet"><input type="hidden" name="horaDet" id="horaDet" class="form-control"/></h5></td>
                                                            <td><h5 id="fechaDet"><input type="hidden" name="fechaDet" id="fechaDet" class="form-control"/></h5></td>
                                                            <td><h5 id="estadoDet"><input type="hidden" name="estadoDet" id="estadoDet" class="form-control"/></h5></td>
                                                            <td><h5 id="fecha_ingresoDet"><input type="hidden" name="fecha_ingresoDet" id="fecha_ingresoDet" class="form-control"/></h5></td>

                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-3 form-control-label"
                                                                       for="email-input">Medicamentos</label>
                                                                <div class="col-md-9">
                                                                <h5 id="medicamentosDet"><textarea class="form-control" rows="3" id="medicamentosDet" name="medicamentosDet"></textarea></h5>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 form-control-label"
                                                                       for="email-input">Prescripcion</label>
                                                                <div class="col-md-9">
                                                                    <h5 id="prescripcionDet"><textarea class="form-control" rows="3" id="prescripcionDet" name="prescripcionDet"></textarea></h5>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 form-control-label"
                                                                       for="email-input">Sintomas</label>
                                                                <div class="col-md-9">
                                                                    <h5 id="sintomasDet"><textarea class="form-control" rows="3" id="sintomasDet" name="sintomasDet"></textarea></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End row-->
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