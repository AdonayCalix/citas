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
require_once("../modelos/Pacientes.php");
//llamar a el modelo PacientesHistorial
require_once("../modelos/Pacienteshistorial.php");

$pacientes = new Pacientes();
$pacientesHistorial = new Pacienteshistorial();

//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo

$id_paciente = isset($_POST["id_paciente"]);
$identidad = isset($_POST["identidad"]);
$nombre = isset($_POST["nombre"]);
$apellido = isset($_POST["apellido"]);
$genero = isset($_POST["genero"]);
$fecha = isset($_POST["datepicker2"]);
$tipo_sangre = isset($_POST["tipoSangre"]);
$edad = isset($_POST["edad"]);
$telefono = isset($_POST["telefono"]);
$correo = isset($_POST["correo"]);
$direccion = isset($_POST["direccion"]);

switch ($_GET["op"]) {

    case "guardaryeditar":
        /*si el id no existe entonces lo registra
         importante: se debe poner el $_POST sino no funciona*/

        if (empty($_POST["id_paciente"])) {
            /*verificamos si existe la cedula y correo en la base de datos, si ya existe un registro con la cedula o correo entonces no se registra el usuario*/

            $datos = $pacientes->get_identidad_del_paciente($_POST["identidad"]);

            /*si coincide password1 y password2 entonces verificamos si existe la cedula y correo en la base de datos, si ya existe un registro con la cedula o correo entonces no se registra el usuario*/

            if (is_array($datos) == true and count($datos) == 0) {

                //no existe el usuario por lo tanto hacemos el registros

                $pacientes->registrar_paciente($identidad, $nombre, $apellido, $genero, $fecha, $tipo_sangre, $edad, $telefono, $correo, $direccion);

                $messages[] = "El paciente se registró correctamente";

                /*si ya exista el correo y la cedula entonces aparece el mensaje*/

            } else {

                $messages[] = "La Identidad ya existe";

            }

        } //cierre de la validacion empty

        else {

            /*si ya existe entonces editamos el usuario*/

            $pacientes->editar_paciente($id_paciente, $identidad, $nombre, $apellido, $genero, $fecha, $tipo_sangre, $edad, $telefono, $correo, $direccion);

            $messages[] = "El paciente se editó correctamente";
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

        //el parametro id_usuario se envia por AJAX cuando se edita el usuario

        $datos = $pacientes->get_paciente_por_id($_POST["id_paciente"]);

        //validacion del id del usuario

//        if (is_array($datos) == true and count($datos) > 0) {

        foreach ($datos as $row) {

            $output["identidad"] = $row["identidad"];
            $output["nombre"] = $row["nombre"];
            $output["apellido"] = $row["apellido"];
            $output["genero"] = $row["genero"];
            $output["datepicker2"] = $row["fecha"];
            $output["tipoSangre"] = $row["tipo_sangre"];
            $output["edad"] = $row["edad"];
            $output["telefono"] = $row["telefono"];
            $output["correo"] = $row["correo"];
            $output["direccion"] = $row["direccion"];
        }

        echo json_encode($output);

//        } else {
//
//            //si no existe el registro entonces no recorre el array
//            $errors[] = "El paciente no existe";
//
//        }


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

        $datos = $pacientes->get_pacientes();

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

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
//            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["id_categoria"] . ');"  id="' . $row["id_categoria"] . '" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["apellido"];
            $sub_array[] = $genero;
            $sub_array[] = $row["fecha"];
            $sub_array[] = $row["tipo_sangre"];
            $sub_array[] = $row["edad"];
            $sub_array[] = $row["telefono"];
//            $sub_array[] = $row["correo"];
//            $sub_array[] = $row["direccion"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));
            $sub_array[] = '<button type="button" onClick="mostrarDetalle(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-primary btn-sm"><i class="icon-eye"></i></button>';

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

    case "listarHistorial":

        $datos = $pacientes->get_pacientes();

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

            $sub_array[] = '<button type="button" onClick="mostrar(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button> <button type="button" onClick="eliminar(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>';
            $sub_array[] = $row["identidad"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["apellido"];
            $sub_array[] = $genero;
//            $sub_array[] = $row["fecha"];
            $sub_array[] = $row["tipo_sangre"];
            $sub_array[] = $row["edad"];
//            $sub_array[] = $row["telefono"];
//            $sub_array[] = $row["correo"];
//            $sub_array[] = $row["direccion"];
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));
            $sub_array[] = '<button type="button" onClick="mostrarDetalle(' . $row["id_paciente"] . ');"  id="' . $row["id_paciente"] . '" class="btn btn-primary btn-sm"><i class="icon-eye"></i></button>';

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

    case "eliminar_paciente":

        $datos = $pacientesHistorial->get_hist_por_id_pac($_POST["id_paciente"]);


        if (is_array($datos) == true and count($datos) > 0) {

            $errors[] = "El Paciente existe en Historial";


        }//fin

        else {

            $datos = $pacientes->get_paciente_por_id($_POST["id_paciente"]);


            if (is_array($datos) == true and count($datos) > 0) {

                $pacientes->eliminar_paciente($_POST["id_paciente"]);

                $messages[] = "El Paciente se eliminó exitosamente";

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


        //fin mensaje success


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
}


?>