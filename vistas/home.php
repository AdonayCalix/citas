<?php

require_once("../config/conexion.php");

if (isset($_SESSION["correo"])) {
    require_once("../modelos/Citas.php");
    $cita = new Citas();
    require_once("../modelos/Pacientes.php");
    $paciente = new Pacientes();
    $pac = $paciente->get_pacientes();

    require_once("../modelos/Medicos.php");
    $medico = new Medicos();
    $med = $medico->get_medicos();
    $ci = $cita->get_citas_actuales();
    ?>
    <?php require_once("header.php"); ?>
    <!--body wrapper start-->
    <div class="wrapper">

        <!--Start Page Title-->
        <!--        <div class="page-title-box">-->
        <!--            <h4 class="page-title">Timeline</h4>-->
        <!--            <ol class="breadcrumb">-->
        <!--                <li>-->
        <!--                    <a href="#">Dashboard</a>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <a href="#">Pages</a>-->
        <!--                </li>-->
        <!--                <li class="active">-->
        <!--                    Timeline-->
        <!--                </li>-->
        <!--            </ol>-->
        <!--            <div class="clearfix"></div>-->
        <!--        </div>-->
        <!--End Page Title-->

        <!--Start row-->
        <div class="row">
            <div class="col-md-12">
                <div id="timeline" class="container">
                    <?php
                    for ($i = 0; $i < sizeof($ci); $i++) {
                        ?>
                        <div class="timeline-block">
                            <div class="timeline-img bg-primary"><i class="fa fa-calendar" style="margin-top: 10px;"></i>
                            </div>
                            <div class="timeline-content">
                                <h3><?php echo $ci[$i]["nombre"]." ".$ci[$i]["apellido"]; ?></h3>
                                <h4><?php echo $ci[$i]["identidad"] ?></h4>
                                <p><?php echo $ci[$i]["hora"]; ?></p>
                                <hr>
                                <span class="date"><?php echo $ci[$i]["fechaCita"]; ?></span>
                                <div class="button-wrap">
<!--                                    <button class="btn btn-primary" title="Ver Historial del Paciente" id="add_button"-->
<!--                                            data-toggle="modal" data-target="#citasModal"><i class="fa fa-eye"></i> <span>Ver</span>-->
<!--                                    </button>-->
                                    <button class="btn btn-primary detalle"  id="<?php echo $ci[$i]["id_cita"]; ?>"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>
<!--                                    <button class="btn btn-info"><i class="fa fa fa-plus"></i> <span>Editar</span></button>-->
                                    <button type="button" onClick="mostrar('<?php echo $ci[$i]["id_cita"]; ?>');"  id="<?php echo $ci[$i]["id_cita"]; ?>" class="btn btn-info"><i class="fa fa fa-plus"></i> <span>Editar</span></button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--End row-->
        <!--VISTA MODAL PARA VER DETALLE CITAL-->
        <?php require_once("modal/detalle_cita_modal.php"); ?>
        <!--VISTA MODAL PARA EDITAR CITA-->
        <?php require_once("modal/editar_cita_modal.php"); ?>

    </div>
    <!-- End Wrapper-->
    <?php require_once("footer.php"); ?>
    <script type="text/javascript" src="js/citas.js"></script>
    <?php

} else {

    header("Location:" . Conectar::ruta() . "vistas/index.php");
    exit();
}
?>

<!--SELECT * FROM `pacientes` WHERE fecha=CURDATE()-->


