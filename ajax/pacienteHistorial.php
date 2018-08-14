<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */
//llamar a la conexion de la base de datos

require_once("../config/conexion.php");


//llamar a el modelo Usuarios

require_once("../modelos/Pacienteshistorial.php");


$pacientesHistorial = new Pacienteshistorial();
$pacientesHistorialDetalle = new Pacienteshistorial();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo

$id_historial = isset($_POST["id_historial"]);
$id_paciente = isset($_POST["paciente"]);
$id_usuario = isset($_POST["id_usuario"]);
$padecimientos = isset($_POST["padecimientos"]);
$alergias = isset($_POST["alergias"]);
$ultima_cita = isset($_POST["datepicker2"]);
$receta = isset($_POST["receta"]);

switch ($_GET["op"]) {

    case "guardaryeditar":
        /*si el id no existe entonces lo registra
         importante: se debe poner el $_POST sino no funciona*/
        if (empty($_POST["id_historial"])) {
            //no existe el usuario por lo tanto hacemos el registros
            $pacientesHistorial->registrar_pacienteHistorial($id_paciente, $padecimientos, $alergias, $ultima_cita, $receta, $id_usuario);

            $messages[] = "El historial clinico del paciente se registró correctamente";
        } //cierre de la validacion empty

        else {
            /*si ya existe entonces editamos el usuario*/
            $pacientesHistorial->editar_pacienteHistorial($id_historial, $id_paciente, $padecimientos, $alergias, $ultima_cita, $receta, $id_usuario);

            $messages[] = "El historial del paciente se editó correctamente";
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
        //fin success
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
        //fin mensaje error
        break;
    case "mostrar":

        //selecciona el id del usuario

        $datos = $pacientesHistorial->get_pacienteHistorial_por_id($_POST["id_historial"]);

        //validacion del id del usuario

        if (is_array($datos) == true and count($datos) > 0) {

            foreach ($datos as $row) {

                $output["id_historial"] = $row["id_historial"];
                $output["paciente"] = $row["id_paciente"];
                $output["padecimientos"] = $row["padecimientos"];
                $output["alergias"] = $row["alergias"];
                $output["datepicker2"] = $row["ultima_cita"];
                $output["receta"] = $row["receta"];
            }

            echo json_encode($output);

        } else {

            //si no existe el registro entonces no recorre el array
            $errors[] = "El historial del paciente no existe";

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

        //fin de mensaje de error

        break;

    case "mostrarDetalle":

        $datos1 = $pacientesHistorialDetalle->get_pacienteHistorialDetalle_por_id($_POST["id_historial"]);

        //validacion del id del usuario

        if (is_array($datos1) == true and count($datos1) > 0) {

            foreach ($datos1 as $row) {

                $output["id_historial"] = $row["id_historial"];
                $output["identidad"] = $row["identidad"];
                $output["nombre"] = $row["nombre"];
                $output["apellido"] = $row["apellido"];
                $output["genero"] = $row["genero"];
                $output["tipoSangre"] = $row["tipo_sangre"];
                $output["edad"] = $row["edad"];
                $output["telefono"] = $row["telefono"];
                $output["correo"] = $row["correo"];
                $output["direccion"] = $row["direccion"];
//                $output["paciente"] = $row["id_paciente"];
                $output["padecimientos"] = $row["padecimientos"];
                $output["alergias"] = $row["alergias"];
                $output["datepicker2"] = $row["ultima_cita"];
                $output["receta"] = $row["receta"];
            }

            echo json_encode($output);

        } else {

            //si no existe el registro entonces no recorre el array
            $errors[] = "El historial del paciente no existe";

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

        //fin de mensaje de error

        break;

    case "activarydesactivar":

        //los parametros id_usuario y est vienen por via ajax
        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);

        //valida el id del usuario
        if (is_array($datos) == true and count($datos) > 0) {

            //edita el estado del usuario
            $usuarios->editar_estado($_POST["id_usuario"], $_POST["est"]);
        }
        break;

    case "listar":

        $datos = $pacientesHistorial->get_pacientesHistorial();

        //declaramos el array

        $data = Array();


        foreach ($datos as $row) {


            $sub_array = array();

            if ($row["genero"] == 0) {

                $genero = "Masculino";

            } else {

                if ($row["genero"] == 1) {

                    $genero = "Femenino";
                }
            }

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_historial"] . ');"  id="' . $row["id_historial"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_historial"] . ');"  id="' . $row["id_historial"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["apellido"];
            $sub_array[] = $genero;
            $sub_array[] = $row["tipo_sangre"];
            $sub_array[] = $row["edad"];
            $sub_array[] = $row["ultima_cita"];
//            $sub_array[] = $row["correo"];
//            $sub_array[] = $row["direccion"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_registro"]));
            $sub_array[] = '<button type="button" onClick="mostrarDetalle(' . $row["id_historial"] . ');"  id="' . $row["id_historial"] . '" class="btn btn-primary btn-sm"><i class="icon-eye"></i></button>';

//            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));


            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);

        break;

    case "eliminar_pacienteHistorial":

        //verificamos si la ccita existe en la base de datos en la tabla citas, si existe entonces lo elimina

        $datos = $pacientesHistorial->get_pacienteHistorial_por_id($_POST["id_historial"]);

        if (is_array($datos) == true and count($datos) > 0) {

            $pacientesHistorial->eliminar_pacienteHistorial($_POST["id_historial"]);

            $messages[] = "El Historial Paciente se eliminó exitosamente";

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

}


?>