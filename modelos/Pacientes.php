<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */

//conexión a la base de datos

require_once("../config/conexion.php");

class Pacientes extends Conectar
{

    //método para seleccionar registros
    public function get_pacientes()
    {

        $conectar = parent::conexion();

        $sql = "select * from pacientes ORDER BY id_paciente DESC ";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //método para insertar registros
    public function registrar_paciente($identidad, $nombre, $apellido, $genero, $fecha, $tipo_sangre, $edad, $telefono, $correo, $direccion)
    {
        $conectar = parent::conexion();

        $sql = "insert into pacientes
           values(null,?,?,?,?,?,?,?,?,?,?,now());";


        $sql = $conectar->prepare($sql);

        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_ingreso = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["identidad"]);
        $sql->bindValue(2, $_POST["nombre"]);
        $sql->bindValue(3, $_POST["apellido"]);
        $sql->bindValue(4, $_POST["genero"]);
        $sql->bindValue(5, $fecha_ingreso);
        $sql->bindValue(6, $_POST["tipoSangre"]);
        $sql->bindValue(7, $_POST["edad"]);
        $sql->bindValue(8, $_POST["telefono"]);
        $sql->bindValue(9, $_POST["correo"]);
        $sql->bindValue(10, $_POST["direccion"]);
        $sql->execute();


    }

    //método para editar un registro
    public function editar_paciente($id_paciente, $identidad, $nombre, $apellido, $genero, $fecha, $tipo_sangre, $edad, $telefono, $correo, $direccion)
    {

        $conectar = parent::conexion();

        require_once("Pacientes.php");

        $sql = "update pacientes set 

              identidad=?,
              nombre=?,
              apellido=?,
              genero=?,
              fecha=?,
              tipo_sangre=?,
              edad=?,
              telefono=?,
              correo=?,
              direccion=?
              where 
              id_paciente=?



             ";

        //echo $sql;

        $sql = $conectar->prepare($sql);
        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_ingreso = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["identidad"]);
        $sql->bindValue(2, $_POST["nombre"]);
        $sql->bindValue(3, $_POST["apellido"]);
        $sql->bindValue(4, $_POST["genero"]);
        $sql->bindValue(5, $fecha_ingreso);
        $sql->bindValue(6, $_POST["tipoSangre"]);
        $sql->bindValue(7, $_POST["edad"]);
        $sql->bindValue(8, $_POST["telefono"]);
        $sql->bindValue(9, $_POST["correo"]);
        $sql->bindValue(10, $_POST["direccion"]);
        $sql->bindValue(11, $_POST["id_paciente"]);
        $sql->execute();

        //print_r($_POST);

    }


    //mostrar los datos del usuario por el id
    public function get_paciente_por_id($id_paciente)
    {

        $conectar = parent::conexion();

        $sql = "select * from pacientes where id_paciente=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_paciente);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //editar el estado del usuario, activar y desactiva el estado

    public function editar_estado($id_usuario, $estado)
    {

        $conectar = parent::conexion();

        //el parametro est se envia por via ajax
        if ($_POST["est"] == "0") {

            $estado = 1;

        } else {

            $estado = 0;
        }

        $sql = "update usuarios set estado=?
            where id_usuario=?	";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_usuario);
        $sql->execute();

    }


    //valida identidad del paciente
    public function get_identidad_del_paciente($identidad)
    {

        $conectar = parent::conexion();

        $sql = "select * from pacientes where identidad=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $identidad);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //método para eliminar un registro
    public function eliminar_paciente($id_paciente)
    {

        $conectar = parent::conexion();

        $sql = "delete from pacientes where id_paciente=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_paciente);
        $sql->execute();

        return $resultado = $sql->fetch();
    }


}


?>