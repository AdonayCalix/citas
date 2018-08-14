<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */

//conexión a la base de datos

require_once("../config/conexion.php");

class Pacienteshistorial extends Conectar
{

    //método para seleccionar registros
    public function get_pacientesHistorial()
    {

        $conectar = parent::conexion();

        $sql = "select ph.id_historial,ph.id_paciente,ph.padecimientos,ph.alergias,ph.ultima_cita, ph.receta, ph.fecha_registro, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from paciente_historial ph    
           INNER JOIN pacientes p ON ph.id_paciente = p.id_paciente ORDER BY ph.id_historial DESC ";

        $sql = $conectar->prepare($sql);

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    //método para insertar registros
    public function registrar_pacienteHistorial($id_paciente, $padecimientos, $alergias, $ultima_cita, $receta, $id_usuario)
    {

        $conectar = parent::conexion();

        require_once("Pacienteshistorial.php");

        $sql = "insert into paciente_historial
           values(null,?,?,?,?,?,?,now());";

        $sql = $conectar->prepare($sql);

        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_cita = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["paciente"]);
        $sql->bindValue(2, $_POST["padecimientos"]);
        $sql->bindValue(3, $_POST["alergias"]);
        $sql->bindValue(4, $fecha_cita);
        $sql->bindValue(5, $_POST["receta"]);
        $sql->bindValue(6, $_POST["id_usuario"]);
        $sql->execute();

    }

    //método para editar un registro
    public function editar_pacienteHistorial($id_historial, $id_paciente, $padecimientos, $alergias, $ultima_cita, $receta, $id_usuario)
    {

        $conectar = parent::conexion();

        require_once("Pacienteshistorial.php");

        $sql = "update paciente_historial set 

              id_paciente=?,
              padecimientos=?,
              alergias=?,
              ultima_cita=?,
              receta=?,
              id_usuario=?
              where 
              id_historial=?
             ";

        //echo $sql;

        $sql = $conectar->prepare($sql);

        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_cita = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["paciente"]);
        $sql->bindValue(2, $_POST["padecimientos"]);
        $sql->bindValue(3, $_POST["alergias"]);
        $sql->bindValue(4, $fecha_cita);
        $sql->bindValue(5, $_POST["receta"]);
        $sql->bindValue(6, $_POST["id_usuario"]);
        $sql->bindValue(7, $_POST["id_historial"]);
        $sql->execute();
        //print_r($_POST);
    }


    //mostrar los datos  por el id
    public function get_pacienteHistorial_por_id($id_historial)
    {

        $conectar = parent::conexion();

        $sql = "select * from paciente_historial where id_historial=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_historial);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //mostrar los datos por el id
    public function get_pacienteHistorialDetalle_por_id($id_historial)
    {

        $conectar = parent::conexion();

        $sql = "select ph.id_historial,ph.id_paciente,ph.padecimientos,ph.alergias,ph.ultima_cita, ph.receta, ph.fecha_registro, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from paciente_historial ph    
           INNER JOIN pacientes p ON ph.id_paciente = p.id_paciente where ph.id_historial=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_historial);
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

    //valida LA IDENTIDAD DEL PACIENTE
    public function get_identidad_del_paciente($identidad)
    {

        $conectar = parent::conexion();

        $sql = "select * from pacientes where identidad=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $identidad);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //metodo para consultar si la tabla tiene registros asociados
    public function get_hist_por_id_pac($id_paciente)
    {

        $conectar = parent::conexion();

        $sql = "select * from paciente_historial where id_paciente=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_paciente);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

    public function get_pacienteHistorial_por_id_usuario($id_usuario){

        $conectar= parent::conexion();

        $sql="select * from paciente_historial where id_usuario=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);


    }

    //método para eliminar un registro
    public function eliminar_pacienteHistorial($id_historial)
    {
        $conectar = parent::conexion();

        $sql = "delete from paciente_historial where id_historial=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_historial);
        $sql->execute();

        return $resultado = $sql->fetch();
    }


}


?>