<?php
if (strlen(session_id()) < 1)
    session_start();
require_once("../config/conexion.php");

if (isset($_SESSION["id_usuario"])) {
    require_once("../modelos/Citas.php");
    $cita = new Citas();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <!-- Mirrored from mixtheme.com/mixtheme/meter/table-responsive.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Jun 2017 19:30:25 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../public/assets/images/favicon.png" type="image/png">
        <title>Citas Medicas</title>
        <link href="../public/assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
        <link href="../public/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="../public/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="../public/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="../public/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="../public/assets/css/icons.css" rel="stylesheet">
        <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../public/assets/css/style.css" rel="stylesheet">
        <link href="../public/assets/css/responsive.css" rel="stylesheet">
        <!--        <link href="../public/vendors/css/style.css" rel="stylesheet">-->
        <link href="../public/vendors/css/select2.css" rel="stylesheet">

        <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
        <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
        <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>

        <!-- Date Picker -->
        <link rel="stylesheet" href="../public/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!--        <!-- bootstrap-select -->
        <link rel="stylesheet" href="../public/vendors/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

<body class="sticky-header left-side-collapsed">


    <!--Start left side Menu-->
    <div class="left-side sticky-left-side">

        <!--logo-->
        <div class="logo">
            <!--            <a href="home.php"><img src="../public/assets/images/logo.png" alt=""></a>-->
            <a href="home.php">Citas Medicas</a>
        </div>

        <div class="logo-icon text-center">
            <a href="home.php"><img src="../public/assets/images/logo-icon.png" alt=""></a>
        </div>
        <!--logo-->

        <div class="left-side-inner">
            <!--Sidebar nav-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="home.php"><i class="icon-speedometer"></i> <span>Escritorio</span></a></li>
                <?php if($_SESSION["citas"]==1){
                    echo '<li class="menu-list"><a href="#"><i class="icon-calendar"></i> <span>Citas</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="citas.php"> Administrar Citas</a></li>
                        <li><a href="consultar_citas_fecha.php"> Consultar Citas Fecha</a></li>
                        <li><a href="consultar_citas_mes.php">Consultar Citas Mes</a></li>
                    </ul>
                </li>';
                }
                ?>
                <?php if($_SESSION["citas"]==1){
                    echo '<li class="menu-list"><a href="#"><i class=" icon-notebook"></i> <span>Pacientes</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="pacientes.php"> Administrar Pacientes</a></li>
                        <li><a href="historial_clinico.php">Historial Clinico</a></li>
                    </ul>
                </li>';
                }
                ?>
                <?php if($_SESSION["medicos"]==1){
                    echo '<li class="menu-list"><a href="#"><i class="icon-user-following"></i> <span>Medicos</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="medicos.php">Administrar Medicos</a></li>
                        <li><a href="especialidades.php">Especialidades</a></li>
                    </ul>
                </li>';
                }
                ?>
                <?php if($_SESSION["usuarios"]==1){
                    echo '<li class="menu-list"><a href="#"><i class="icon-lock"></i> <span>Acceso</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="usuarios.php"> Usuarios</a></li>
                        <li><a href="#"> Roles</a></li>
                    </ul>
                </li>';
                }
                ?>
                <?php if($_SESSION["reporte_citas"]==1){
                    echo '<li class="menu-list"><a href="#"><i class="icon-pie-chart"></i> <span>Reportes</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="reporte_citas.php"> Reporte Citas por Mes</a></li>
                        <li><a href="reporte_citas_medicos.php">Reporte Citas por Medico</a></li>
                    </ul>
                </li>';
                }
                ?>
                <li><a href="#"><i class="icon-book-open"></i><span class="badge badge-success">Ayuda</span></a></li>
                <?php if($_SESSION["reporte_citas"]==1){
                    echo '<li><a href="#"><i class="icon-info"></i><span class="badge badge-info">Acerca de...</span></a></li>';
                }
                ?>
                <!--<li><a href="#"><i class="icon-speedometer"></i> <span>Escritorio</span></a></li>-->
            </ul>
            <!--End sidebar nav-->
        </div>
    </div>
    <!--End left side menu-->
    <!-- main content start-->
<div class="main-content">

    <!-- header section start-->
    <div class="header-section">

        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <!--<form class="searchform">-->
        <!--<input type="text" class="form-control" name="keyword" placeholder="Search here..." />-->
        <!--</form>-->
        <!--notification menu start -->
        <div class="menu-right">
            <ul class="notification-menu">
                <li>
                    <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge"><?php echo $cita->get_filas_cita() + $cita->get_filas_citaMayores(); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-head pull-right">
                        <h5 class="title">Notificaciones</h5>
                        <ul class="dropdown-list normal-list">
                            <li class="message-list message-scroll-list">
                                <a href="<?php echo Conectar::ruta() ?>vistas/citas.php">
                                        <span class="photo"> <img src="../public/assets/images/users/notebook.svg"
                                                                  class="img-circle" alt="img"></span>
                                    <span class="subject">Citas</span>
                                    <span class="message"> Para hoy tiene</span>
                                    <span class="time"><?php echo $cita->get_filas_cita(); ?> Citas</span>
                                </a>
                                <a href="<?php echo Conectar::ruta() ?>vistas/citas.php">
                                        <span class="photo"> <img src="../public/assets/images/users/alarm-clock.svg"
                                                                  class="img-circle" alt="img"></span>
                                    <span class="subject">Pendientes</span>
                                    <span class="message"> Tiene citas pendientes</span>
                                    <span class="time"><?php echo $cita->get_filas_citaMayores(); ?> Citas</span>
                                </a>

                            </li>
                            <li class="last"><a href="#"></a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="../public/assets/images/users/avatar-6.jpg" alt=""/>
                        <?php echo $_SESSION["nombre"] ?><?php echo $_SESSION["apellido"] ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        <li><a class="dropdown-item" href="#"
                               onclick="mostrar_perfil('<?php echo $_SESSION["id_usuario"] ?>')"
                               data-toggle="modal" data-target="#perfilModal"><i class="fa fa-user"></i> Perfil</a></li>
                        <!--<li> <a href="#"> <i class="fa fa-info"></i> Ayuda </a> </li>-->
                        <li><a href="logout.php"> <i class="fa fa-lock"></i> Cerrar </a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!--notification menu end -->

    </div>
    <!-- header section end-->

    <!--FORMULARIO PERFIL USUARIO MODAL-->
    <div id="perfilModal" class="modal fade">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <form action="" class="form-horizontal" method="post" id="perfil_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Perfil</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputText3" class="col-lg-1 control-label">Cédula</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="text" class="form-control" id="cedula_perfil" name="cedula_perfil"
                                       placeholder="Cédula" required pattern="[0-9]{0,15}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText1" class="col-lg-1 control-label">Nombres</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="text" class="form-control" id="nombre_perfil" name="nombre_perfil"
                                       placeholder="Nombres" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText1" class="col-lg-1 control-label">Apellidos</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="text" class="form-control" id="apellido_perfil" name="apellido_perfil"
                                       placeholder="Apellidos" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText1" class="col-lg-1 control-label">Usuario</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="text" class="form-control" id="usuario_perfil" name="usuario_perfil"
                                       placeholder="Nombres" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText3" class="col-lg-1 control-label">Password</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="password" class="form-control" id="password1_perfil"
                                       name="password1_perfil" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText3" class="col-lg-1 control-label">Repita Password</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="password" class="form-control" id="password2_perfil"
                                       name="password2_perfil" placeholder="Repita Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText4" class="col-lg-1 control-label">Teléfono</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="text" class="form-control" id="telefono_perfil" name="telefono_perfil"
                                       placeholder="Teléfono" required pattern="[0-9]{0,15}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText4" class="col-lg-1 control-label">Correo</label>
                            <div class="col-lg-9 col-lg-offset-1">
                                <input type="email" class="form-control" id="email_perfil" name="email_perfil"
                                       placeholder="Correo" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputText5" class="col-lg-1 control-label">Dirección</label>

                            <div class="col-lg-9 col-lg-offset-1">
                                    <textarea class="form-control  col-lg-9" rows="3" id="direccion_perfil"
                                              name="direccion_perfil" placeholder="Direccion ..." required
                                              pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--modal-body-->
                    <div class="modal-footer">
                        <input type="hidden" name="id_usuario_perfil" id="id_usuario_perfil"/>
                        <!--<input type="hidden" name="operation" id="operation"/>-->
                        <button type="submit" name="action" id="" class="btn btn-success pull-left" value="Add"><i
                                    class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"
                                                                                             aria-hidden="true"></i>
                            Cerrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--FIN FORMULARIO PERFIL USUARIO MODAL-->

    <script src="../public/vendors/js/jquery.min.js"></script>

    <script type="text/javascript" src="js/perfil.js"></script>

    <script type="text/javascript" src="js/usuarios.js"></script>

    <?php
} else {

    header("Location:" . Conectar::ruta() . "vistas/index.php");
    exit();
}
?>