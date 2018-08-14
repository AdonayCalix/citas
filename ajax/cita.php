<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */
//llamar a la conexion de la base de datos

require_once("../config/conexion.php");


//llamar a el modelo Pacientes
require_once("../modelos/Citas.php");
//llamar a el modelo PacientesHistorial
require_once("../modelos/Pacientes.php");

$citas = new Citas();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo

$id_cita = isset($_POST["id_cita"]);
$id_paciente = isset($_POST["paciente"]);
$lugar = isset($_POST["lugar"]);
$id_medico = isset($_POST["medico"]);
$id_usuario = isset($_POST["id_usuario"]);
$hora = isset($_POST["timepicker"]);
$fecha = isset($_POST["datepicker2"]);
$medicamentos = isset($_POST["medicamentos"]);
$prescripcion = isset($_POST["prescripcion"]);
$sintomas = isset($_POST["sintomas"]);
$estado = isset($_POST["estado"]);

switch ($_GET["op"]) {

    case "guardaryeditar":

        if (empty($_POST["id_cita"])) {

            $citas->registrar_cita($id_paciente, $lugar, $id_medico, $hora, $fecha, $medicamentos, $prescripcion, $sintomas, $estado, $id_usuario);

            $messages[] = "La Cita se registró correctamente";

        } else {

            $citas->editar_cita($id_cita, $id_paciente, $lugar, $id_medico, $hora, $fecha, $medicamentos, $prescripcion, $sintomas, $estado, $id_usuario);

            $messages[] = "La Cita se editó correctamente";
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

        break;


    case "mostrar":

        //selecciona el id del usuario
        $datos = $citas->get_cita_por_id($_POST["id_cita"]);

        foreach ($datos as $row) {

            $output["id_cita"] = $row["id_cita"];
            $output["paciente"] = $row["id_paciente"];
            $output["lugar"] = $row["lugar"];
            $output["medico"] = $row["id_medico"];
            $output["timepicker"] = $row["hora"];
            $output["datepicker2"] = $row["fecha"];
            $output["medicamentos"] = $row["medicamentos"];
            $output["prescripcion"] = $row["prescripcion"];
            $output["sintomas"] = $row["sintomas"];
            $output["estado"] = $row["estado"];

        }
        echo json_encode($output);

        break;

    case "activarydesactivar":

        $datos = $citas->get_cita_por_id($_POST["id_cita"]);

        //valida el id de la cita
        if (is_array($datos) == true and count($datos) > 0) {

            //edita el estado de la cita
            $citas->editar_estado($_POST["id_cita"], $_POST["est"]);
        }
        break;

    case "listar":

        $datos = $citas->get_citas();

        $data = Array();

        foreach ($datos as $row) {

            $sub_array = array();
            //ESTADO
            $est = '';

            $atrib = "label label-success estado";
            if ($row["estado"] == 0) {
                $est = 'ANTENDIDO';
                $atrib = "label label-warning estado";
            } else {
                if ($row["estado"] == 1) {
                    $est = 'PENDIENTE';

                }
            }

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_cita"] . ');"  id="' . $row["id_cita"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_cita"] . ');"  id="' . $row["id_cita"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"] . " " . $row["apellido"];
            $sub_array[] = $row["lugar"];
            $sub_array[] = $row["hora"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_cita"]));
            $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_cita"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_cita"] . '" class="' . $atrib . '">' . $est . '</button>';
//            $sub_array[] = '<button type="button" onClick="mostrarDetalle(' . $row["id_cita"] . ');"  id="' . $row["id_cita"] . '" class="btn btn-primary btn-sm"><i class="icon-eye"></i></button>';
            $sub_array[] = '<button class="btn btn-warning detalle"  id="' . $row["id_cita"] . '"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>';
            $data[] = $sub_array;


        }

        $results = array(

            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "eliminar_cita":

        //verificamos si la ccita existe en la base de datos en la tabla citas, si existe entonces lo elimina

        $datos = $citas->get_cita_por_id($_POST["id_cita"]);

        if (is_array($datos) == true and count($datos) > 0) {

            $citas->eliminar_cita($_POST["id_cita"]);

            $messages[] = "La Cita se eliminó exitosamente";

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

    case "ver_detalle_cita":

        $datos = $citas->get_detalle_citas($_POST["id_cita"]);

        // si existe la cita se recorre el array
        if (is_array($datos) == true and count($datos) > 0) {

            foreach ($datos as $row) {
                if ($row["genero"] == 0) {

                    $genero = "Masculino";

                } else {

                    if ($row["genero"] == 1) {

                        $genero = "Femenino";
                    }
                }

                //ESTADO
                $est = '';
                if ($row["estado"] == 0) {
                    $est = 'ANTENDIDO';
                } else {
                    if ($row["estado"] == 1) {
                        $est = 'PENDIENTE';

                    }
                }

                $output["identidad"] = $row["identidad"];
                $output["nombre"] = $row["nombre"]." ".$row["apellido"];
                $output["genero"] = $genero;
                $output["edad"] = $row["edad"];
                $output["medicoDetalle"] = $row["apellidoM"]." ".$row["nombreM"];
                $output["lugarDet"] = $row["lugar"];
                $output["horaDet"] = $row["hora"];
                $output["fechaDet"] = $row["fecha"];
                $output["estadoDet"] = $est;
                $output["fecha_ingresoDet"] = $row["fecha_ingreso"];
                $output["medicamentosDet"] = $row["medicamentos"];
                $output["prescripcionDet"] = $row["prescripcion"];
                $output["sintomasDet"] = $row["sintomas"];

            }

            echo json_encode($output);


        } else {

            //si no existe el registro entonces no recorre el array
            $errors[] = "no existe";

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

    case "buscar_citas_fecha":

        $datos = $citas->lista_busca_registros_fecha($_POST["fecha_inicial"], $_POST["fecha_final"]);

        $data = Array();

        foreach ($datos as $row) {
            $sub_array = array();

            //ESTADO
            $est = '';

            $atrib = "label label-success estado";
            if ($row["estado"] == 0) {
                $est = 'ANTENDIDO';
                $atrib = "label label-warning estado";
            } else {
                if ($row["estado"] == 1) {
                    $est = 'PENDIENTE';

                }
            }
            $sub_array[] = '<button class="btn btn-warning detalle"  id="' . $row["id_cita"] . '"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"]." ".$row["apellido"];
            $sub_array[] = $row["lugar"];
            $sub_array[] = $row["hora"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_cita"]));
            $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_cita"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_cita"] . '" class="' . $atrib . '">' . $est . '</button>';

            $data[] = $sub_array;
        }


        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "buscar_citas_fecha_mes":

        $datos = $citas->lista_busca_registros_fecha_mes($_POST["mes"], $_POST["ano"]);

        //Vamos a declarar un array
        $data = Array();

        foreach ($datos as $row) {
            $sub_array = array();

            //ESTADO
            $est = '';

            $atrib = "label label-success estado";
            if ($row["estado"] == 0) {
                $est = 'ANTENDIDO';
                $atrib = "label label-warning estado";
            } else {
                if ($row["estado"] == 1) {
                    $est = 'PENDIENTE';

                }
            }
            $sub_array[] = '<button class="btn btn-warning detalle"  id="' . $row["id_cita"] . '"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"]." ".$row["apellido"];
            $sub_array[] = $row["lugar"];
            $sub_array[] = $row["hora"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_cita"]));
            $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_cita"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_cita"] . '" class="' . $atrib . '">' . $est . '</button>';

            $data[] = $sub_array;
        }


        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "buscar_citas_medico":

        $datos = $citas->get_cita_por_medico($_POST["medico"]);

        //Vamos a declarar un array
        $data = Array();

        foreach ($datos as $row) {
            $sub_array = array();

            //ESTADO
            $est = '';

            if ($row["estado"] == 0) {
                $est = 'ANTENDIDO';
            } else {
                if ($row["estado"] == 1) {
                    $est = 'PENDIENTE';
                }
            }
            $sub_array[] = '<button class="btn btn-warning detalle"  id="' . $row["id_cita"] . '"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"]." ".$row["apellido"];
            $sub_array[] = $row["lugar"];
            $sub_array[] = $row["hora"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_cita"]));
            $sub_array[] = $est;
            $data[] = $sub_array;
        }


        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;

    case "buscar_citas_mes":

        $datos = $citas->busca_registros_mes($_POST["mes1"], $_POST["ano1"]);

        //Vamos a declarar un array
        $data = Array();

        foreach ($datos as $row) {
            $sub_array = array();

            //ESTADO
            $est = '';

            if ($row["estado"] == 0) {
                $est = 'ANTENDIDO';
            } else {
                if ($row["estado"] == 1) {
                    $est = 'PENDIENTE';

                }
            }
            $sub_array[] = '<button class="btn btn-warning detalle"  id="' . $row["id_cita"] . '"  data-toggle="modal" data-target="#detalle_cita"><i class="fa fa-eye"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"]." ".$row["apellido"];
            $sub_array[] = $row["lugar"];
            $sub_array[] = $row["hora"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_cita"]));
            $sub_array[] = $est;
//            $sub_array[] = '<button type="button" onClick="cambiarEstado(' . $row["id_cita"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_cita"] . '" class="' . $atrib . '">' . $est . '</button>';

            $data[] = $sub_array;
        }


        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);


        break;
}


?>