<?php

require_once("config/conexion.php");

if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {

    require_once("modelos/Usuarios.php");

    $usuario = new Usuarios();

    $usuario->login();

}

?>
<!DOCTYPE html>
<html lang="es">
<!-- Mirrored from mixtheme.com/mixtheme/meter/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Jun 2017 19:32:50 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="public/assets/images/favicon.png" type="image/png">
    <title>Citas Medicas</title>
    <link href="public/assets/css/icons.css" rel="stylesheet">
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/assets/css/style.css" rel="stylesheet">
    <link href="public/assets/css/responsive.css" rel="stylesheet">

    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>

</head>

<body class="sticky-header">


<!--Start login Section-->
<section class="login-section">
    <div class="container">
        <div class="row">
            <div class="login-wrapper">
                <div class="login-inner">
                    <!--INICIO MENSAJES DE ALERTA-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box-body">
                                    <?php
                                    if (isset($_GET["m"])) {
                                        switch ($_GET["m"]) {
                                            case "1";
                                                ?>
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-hidden="true">&times;
                                                    </button>
                                                    <h4><i class="icon fa fa-ban"></i> El correo y/o password es
                                                        incorrecto o no tienes permiso!</h4>
                                                </div>
                                                <?php
                                                break;
                                            case "2";
                                                ?>
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-hidden="true">&times;
                                                    </button>
                                                    <h4><i class="icon fa fa-ban"></i> Los campos estan vacios</h4>
                                                </div>
                                                <?php
                                                break;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/container-fluid-->
                    <!-- FIN MENSAJES DE ALERTA-->

<!--                    <div class="logo">-->
<!--                        <img src="assets/images/logo-dark.png"  alt="logo"/>-->
<!--                    </div>-->

                    <h1 class="header-title text-center">INICIAR SESIÓN</h1>

                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="correo" id="correo"  placeholder="Usuario" >
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control"  placeholder="Password" >
                        </div>

                        <div class="form-group">
                            <div class="pull-left">
                                <div class="checkbox primary">
                                    <input  id="checkbox-2" type="checkbox">
                                    <label for="checkbox-2">Recuérdame</label>
                                </div>
                            </div>

                            <div class="pull-right">
                                <a href="reset-password.html" class="a-link">
                                    <i class="fa fa-unlock-alt"></i>¿Se te olvidó tu contraseña?
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="enviar" class="form-control" value="si">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Acceder" class="btn btn-primary btn-block" >
                        </div>
                    </form>

                    <div class="copy-text">
                        <p class="m-0">2018 &copy; Negocios Web</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!--End login Section-->




<!--Begin core plugin -->
<script src="public/assets/js/jquery.min.js"></script>
<script src="public/assets/js/bootstrap.min.js"></script>
<!-- End core plugin -->

</body>


<!-- Mirrored from mixtheme.com/mixtheme/meter/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Jun 2017 19:32:52 GMT -->
</html>


