<?php

//llamar a la conexion de la base de datos

require_once("../config/conexion.php");


//llamar a el modelo Usuarios

require_once("../modelos/Usuarios.php");
require_once("../modelos/Citas.php");
require_once("../modelos/Pacienteshistorial.php");

$usuarios = new Usuarios();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo

$id_usuario = isset($_POST["id_usuario"]);
$nombre = isset($_POST["nombre"]);
$apellido = isset($_POST["apellido"]);
$cedula = isset($_POST["cedula"]);
$telefono = isset($_POST["telefono"]);
$email = isset($_POST["email"]);
$direccion = isset($_POST["direccion"]);
$cargo = isset($_POST["cargo"]);
$usuario = isset($_POST["usuario"]);
$password1 = isset($_POST["password1"]);
$password2 = isset($_POST["password2"]);
//este es el que se envia del formulario
$estado = isset($_POST["estado"]);
$imagen = isset($_POST["hidden_usuario_imagen"]);


switch ($_GET["op"]) {

    case "guardaryeditar":

//        verificamos si existe la cedula en la base de datos, si ya existe un registro con la identidad entonces no se registra el usuario

        $datos = $usuarios->get_cedula_correo_del_usuario($_POST["cedula"], $_POST["email"]);

        //validacion de password
        if ($password1 == $password2) {

            if (empty($_POST["id_usuario"])) {

                if (is_array($datos) == true and count($datos) == 0) {

                    //no existe el usuario por lo tanto hacemos el registros

                    $usuarios->registrar_usuario($nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $imagen, $estado);

                    $messages[] = "El usuario se registró correctamente";

                } else {

                    $messages[] = "La cédula o el correo ya existe";

                }

            }
            else {

//                Si ya existe el usuario entonces sera editado

                $usuarios->editar_usuario($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $imagen, $estado);

                $messages[] = "El usuario se editó correctamente";
            }


        } else {
            $errors[] = "El password no coincide";
        }

        //mensaje success
        if (isset($messages)) {

            ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong>
                <?php
                foreach ($messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }

        //mensaje error
        if (isset($errors)) {

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php

        }

        break;


    case "mostrar":

        //selecciona el id del usuario
        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

        if (is_array($datos) == true and count($datos) > 0) {

            foreach ($datos as $row) {

                $output["cedula"] = $row["cedula"];
                $output["nombre"] = $row["nombres"];
                $output["apellido"] = $row["apellidos"];
                $output["cargo"] = $row["cargo"];
                $output["usuario"] = $row["usuario"];
                $output["password1"] = $row["password"];
                $output["password2"] = $row["password2"];
                $output["telefono"] = $row["telefono"];
                $output["correo"] = $row["correo"];
                $output["direccion"] = $row["direccion"];
                $output["estado"] = $row["estado"];
                if ($row["imagen"] != '') {
                    $output['usuario_imagen'] = '<img src="upload/' . $row["imagen"] . '" class="img-thumbnail" width="80" height="40" /><input type="hidden" name="hidden_usuario_imagen" value="' . $row["imagen"] . '" />';
                } else {
                    $output['usuario_imagen'] = '<input type="hidden" name="hidden_usuario_imagen" value="" />';
                }
            }

            echo json_encode($output);

        } else {
            //si no existe el registro entonces no recorre el array
            $errors[] = "El usuario no existe";
        }

        //inicio de mensaje de error
        if (isset($errors)) {

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }

        break;

    case "activarydesactivar":

        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

        //valida el id del usuario
        if (is_array($datos) == true and count($datos) > 0) {
            //edita el estado del usuario
            $usuarios->editar_estado($_POST["id_usuario"], $_POST["est"]);
        }
        break;

    case "listar":

        $datos = $usuarios->get_usuarios();
        //declaramos el array
        $data = Array();

        foreach ($datos as $row) {
            $sub_array = array();
            //ESTADO
            $est = '';
            $atrib = "label label-success estado";
            if ($row["estado"] == 0) {
                $est = 'INACTIVO';
                $atrib = "label label-warning estado";
            } else {
                if ($row["estado"] == 1) {
                    $est = 'ACTIVO';

                }
            }

            //cargo
            if ($row["cargo"] == 1) {

                $cargo = "MEDICO";

            } else {

                if ($row["cargo"] == 0) {

                    $cargo = "EMPLEADO";
                }
            }

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
            $sub_array[] = $row["cedula"];
            $sub_array[] = $row["nombres"];
            $sub_array[] = $row["apellidos"];
            $sub_array[] = $row["usuario"];
            $sub_array[] = $cargo;
            $sub_array[] = $row["telefono"];
            $sub_array[] = $row["correo"];
            $sub_array[] = $row["direccion"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));

            $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_usuario"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_usuario"] . '" class="' . $atrib . '">' . $est . '</button>';

            if ($row["imagen"] != '') {
                $sub_array[] = '<img src="upload/' . $row["imagen"] . '" class="img-thumbnail" width="50" height="50" /><input type="hidden" name="hidden_usuario_imagen" value="' . $row["imagen"] . '" />
                 <span></span>';
            } else {
                $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i></button>';
            }

            $data[] = $sub_array;


        }

        $results = array(

            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "eliminar_usuario":

        //verificamos si el usuario existe en las tablas citas, paciente historial
        $citas = new Citas();
        $pacienteHistorial = new Pacienteshistorial();

        $cit = $citas->get_cita_por_id_usuario($_POST["id_usuario"]);

        $pacienteH = $pacienteHistorial->get_pacienteHistorial_por_id_usuario($_POST["id_usuario"]);

        $usuario_permiso = $usuarios->get_usuario_permiso_por_id_usuario($_POST["id_usuario"]);


        if (
            is_array($usuario_permiso) == true and count($usuario_permiso) > 0 or
            is_array($cit) == true and count($cit) > 0 or
            is_array($pacienteH) == true and count($pacienteH) > 0) {


            //si existe el usuario en las tablas relacionadas no lo elimina

            $errors[] = "El usuario existe en los registros, no se puede eliminar";


        }

        else {

            $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

            //si solo  existe en la tabla de usuario entonces se elimina
            if (is_array($datos) == true and count($datos) > 0) {

                $usuarios->eliminar_usuario($_POST["id_usuario"]);

                $messages[] = "El usuario se eliminó exitosamente";


            }


        }

        //prueba mensaje de success
        if (isset($messages)) {

            ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong>
                <?php
                foreach ($messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }

        //inicio de mensaje de error
        if (isset($errors)) {

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }

        break;


    case 'permisos':

        //Obtenemos todos los permisos de la tabla permisos
        $listar_permisos = $usuarios->permisos();

        //Obtener los permisos asignados al usuario
        $id_usuario = $_GET['id_usuario'];

        //echo $id_usuario;
        $marcados = $usuarios->listar_permisos_por_usuario($id_usuario);

        //print_r($marcados);

        //Declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        foreach ($marcados as $re) {
            /*NO hay que tratar a $re como si fuera un objeto o un metodo
                hay que manejarlo como un array como en el siguiente ejemplo*/
            $valores[] = $re["id_permiso"];
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        foreach ($listar_permisos as $row) {

            $output["id_permiso"] = $row["id_permiso"];
            $output["nombre"] = $row["nombre"];

            $sw = in_array($row['id_permiso'], $valores) ? 'checked' : '';

            echo '<li><input id="checkbox-2" type="checkbox" ' . $sw . ' name="permiso[]" value="' . $row["id_permiso"] . '">' . $row["nombre"] . '</li>';
        }

        break;
}


?>