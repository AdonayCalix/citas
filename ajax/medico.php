<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */

//llamar a la conexion de la base de datos
require_once("../config/conexion.php");

//llamar a el modelo Medicos
require_once("../modelos/Medicos.php");
$medicos = new Medicos();
//llamar el modelo cita
require_once("../modelos/Citas.php");

$citas = new Citas();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo

$id_medico = isset($_POST["id_medico"]);
$identidad = isset($_POST["identidad"]);
$nombre = isset($_POST["nombre"]);
$apellido = isset($_POST["apellido"]);
$genero = isset($_POST["genero"]);
$fecha_nacimiento = isset($_POST["datepicker2"]);;
$edad = isset($_POST["edad"]);
$telefono = isset($_POST["telefono"]);
$correo = isset($_POST["correo"]);
$direccion = isset($_POST["direccion"]);
$especialidad = isset($_POST["especialidad"]);

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["id_medico"])) {
            /*verificamos si existe la cedula en la base de datos, si ya existe un registro con la cedula o correo entonces no se registra el usuario*/

            $datos = $medicos->get_identidad_del_medico($_POST["identidad"]);

            if (is_array($datos) == true and count($datos) == 0) {

                //no existe el medico por lo tanto hacemos el registros

                $medicos->registrar_medico($identidad, $nombre, $apellido, $genero, $fecha_nacimiento, $edad, $telefono, $correo, $direccion, $especialidad);

                $messages[] = "El medico se registró correctamente";

                /*si ya exista la identidad entonces aparece el mensaje*/

            } else {

                $messages[] = "La Identidad ya existe";

            }

        } //cierre de la validacion empty

        else {

            /*si ya existe entonces editamos el usuario*/

            $medicos->editar_medico($id_medico, $identidad, $nombre, $apellido, $genero, $fecha_nacimiento, $edad, $telefono, $correo, $direccion, $especialidad);

            $messages[] = "El medico se editó correctamente";
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

        //selecciona el id del medico

        $datos = $medicos->get_medico_por_id($_POST["id_medico"]);

        foreach ($datos as $row) {

            $output["identidad"] = $row["identidad"];
            $output["nombre"] = $row["nombre"];
            $output["apellido"] = $row["apellido"];
            $output["genero"] = $row["genero"];
            $output["datepicker2"] = $row["fecha_nacimiento"];
            $output["edad"] = $row["edad"];
            $output["telefono"] = $row["telefono"];
            $output["correo"] = $row["correo"];
            $output["direccion"] = $row["direccion"];
            $output["especialidad"] = $row["especialidad"];
        }

        echo json_encode($output);

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

        $datos = $medicos->get_medicos();

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

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_medico"] . ');"  id="' . $row["id_medico"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_medico"] . ');"  id="' . $row["id_medico"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["apellido"];
            $sub_array[] = $genero;
            $sub_array[] = $row["fecha_nacimiento"];
            $sub_array[] = $row["edad"];
            $sub_array[] = $row["telefono"];
            $sub_array[] = $row["especialidad"];
            $sub_array[] = $row["correo"];
//            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));
            $sub_array[] = '<button type="button" onClick="mostrarDetalle(' . $row["id_medico"] . ');"  id="' . $row["id_medico"] . '" class="btn btn-primary btn-sm"><i class="icon-eye"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(

            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "eliminar_medico":

        $datos = $citas->get_cita_por_id_medico($_POST["id_medico"]);


        if (is_array($datos) == true and count($datos) > 0) {

            $errors[] = "El Medico existe en Citas";

        }//fin

        else {

            $datos = $medicos->get_medico_por_id($_POST["id_medico"]);


            if (is_array($datos) == true and count($datos) > 0) {

                $medicos->eliminar_medico($_POST["id_medico"]);

                $messages[] = "El Medico se eliminó exitosamente";

            }

        }

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