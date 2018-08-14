<?php
/**
 * Created by PhpStorm.
 * User: nehem
 * Date: 23/07/2018
 * Time: 19:09
 */

//conexión a la base de datos

require_once("../config/conexion.php");

class Citas extends Conectar
{

    //método para seleccionar registros
    public function get_filas_cita(){

        $conectar= parent::conexion();

        $sql="select * from citas WHERE fecha=CURDATE() AND estado='1'";
//        SELECT * FROM `citas` WHERE fecha=CURDATE()

        $sql=$conectar->prepare($sql);

        $sql->execute();

        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

        return $sql->rowCount();

    }

    public function get_filas_citaMayores(){

        $conectar= parent::conexion();

        $sql="select * from citas WHERE fecha>CURDATE() AND estado='1'";
//        SELECT * FROM `citas` WHERE fecha=CURDATE()

        $sql=$conectar->prepare($sql);

        $sql->execute();

        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

        return $sql->rowCount();

    }

    public function get_citas()
    {

        $conectar = parent::conexion();

//        $sql = "select * from citas ORDER BY id_cita DESC ";
        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha as fecha_cita, c.id_medico, c.fecha_ingreso, c.estado, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from citas c    
           INNER JOIN pacientes p ON c.id_paciente = p.id_paciente ORDER BY c.id_cita DESC ";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_citas_actuales()
    {
        $conectar = parent::conexion();

        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha AS fechaCita, c.medicamentos, c.prescripcion, c.sintomas, c.id_usuario,c.id_medico, c.estado, c.fecha_ingreso, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from citas c    
           INNER JOIN pacientes p ON c.id_paciente = p.id_paciente WHERE c.fecha=CURDATE() AND c.estado='1' ORDER BY c.hora ASC ";
        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //método para insertar registros
    public function registrar_cita($id_paciente, $lugar, $id_medico, $hora, $fecha, $medicamentos, $prescripcion, $sintomas, $estado, $id_usuario)
    {
        $conectar = parent::conexion();

        require_once("Citas.php");

        $sql = "insert into citas
           values(null,?,?,?,?,?,?,?,?,?,?,now());";

        $sql = $conectar->prepare($sql);

        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_ingreso = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["paciente"]);
        $sql->bindValue(2, $_POST["lugar"]);
        $sql->bindValue(3, $_POST["medico"]);
        $sql->bindValue(4, $_POST["timepicker"]);
        $sql->bindValue(5, $fecha_ingreso);
        $sql->bindValue(6, $_POST["medicamentos"]);
        $sql->bindValue(7, $_POST["prescripcion"]);
        $sql->bindValue(8, $_POST["sintomas"]);
        $sql->bindValue(9, $_POST["estado"]);
        $sql->bindValue(10, $_POST["id_usuario"]);

        $sql->execute();
//        print_r($_POST);


    }

    //método para editar un registro
    public function editar_cita($id_cita, $id_paciente, $lugar, $id_medico, $hora, $fecha, $medicamentos, $prescripcion, $sintomas, $estado, $id_usuario)
    {

        $conectar = parent::conexion();

        require_once("Citas.php");

        $sql = "update citas set 
              id_paciente=?,
              lugar=?,
              id_medico=?,
              hora=?,
              fecha=?,
              medicamentos=?,
              prescripcion=?,
              sintomas=?,
              estado=?,
              id_usuario=?
              where 
              id_cita=?
             ";

        //echo $sql;

        $sql = $conectar->prepare($sql);

        $date_ingreso= $_POST["datepicker2"];
        $date = str_replace('/', '-', $date_ingreso);
        $fecha_cita = date("Y-m-d", strtotime($date));

        $sql->bindValue(1, $_POST["paciente"]);
        $sql->bindValue(2, $_POST["lugar"]);
        $sql->bindValue(3, $_POST["medico"]);
        $sql->bindValue(4, $_POST["timepicker"]);
        $sql->bindValue(5, $fecha_cita);
        $sql->bindValue(6, $_POST["medicamentos"]);
        $sql->bindValue(7, $_POST["prescripcion"]);
        $sql->bindValue(8, $_POST["sintomas"]);
        $sql->bindValue(9, $_POST["estado"]);
        $sql->bindValue(10, $_POST["id_usuario"]);
        $sql->bindValue(11, $_POST["id_cita"]);
        $sql->execute();
        //print_r($_POST);
    }

    //mostrar los datos del usuario por el id
    public function get_cita_por_id($id_cita)
    {

        $conectar = parent::conexion();

        $sql = "select * from citas where id_cita=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_cita);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //editar el estado del usuario, activar y desactiva el estado

    public function editar_estado($id_cita, $estado)
    {

        $conectar = parent::conexion();

        if ($_POST["est"] == "0") {

            $estado = 1;

        } else {

            $estado = 0;
        }

        $sql = "update citas set estado=?
            where id_cita=?	";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_cita);
        $sql->execute();

    }

    //método para eliminar un registro
    public function eliminar_cita($id_cita)
    {
        $conectar = parent::conexion();

        $sql = "delete from citas where id_cita=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_cita);
        $sql->execute();

        return $resultado = $sql->fetch();
    }

    //metodo para ver el detalle del proveedor en una compra
    public function get_detalle_citas($id_cita)
    {

        $conectar = parent::conexion();

        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha, c.medicamentos, c.prescripcion, c.sintomas, c.id_medico, c.fecha_ingreso, c.estado, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, 
                        p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion, m.identidad as identidadM, m.nombre as nombreM, m.apellido as apellidoM
           from citas c, pacientes p, medicos m    
           WHERE  c.id_paciente = p.id_paciente AND c.id_medico = m.id_medico AND c.id_cita=?";

        //echo $sql; exit();

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_cita);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    //BUSCA CITAS POR FECHA
    public function lista_busca_registros_fecha($fecha_inicial, $fecha_final)
    {

        $conectar = parent::conexion();

        $date_inicial = $_POST["fecha_inicial"];
        $date = str_replace('/', '-', $date_inicial);
        $fecha_inicial = date("Y-m-d", strtotime($date));

        $date_final = $_POST["fecha_final"];
        $date = str_replace('/', '-', $date_final);
        $fecha_final = date("Y-m-d", strtotime($date));


//        $sql = "SELECT * FROM citas WHERE fecha>=? and fecha<=? ";
        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha AS fecha_cita, c.medicamentos, c.prescripcion, c.sintomas, c.id_usuario,c.id_medico, c.estado, c.fecha_ingreso, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from citas c
           INNER JOIN pacientes p ON c.id_paciente = p.id_paciente WHERE c.fecha>=? and c.fecha<=? ORDER BY c.id_cita ASC ";


        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecha_inicial);
        $sql->bindValue(2, $fecha_final);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

    //BUSCA REGISTROS CITAS-FECHA-MES
    public function lista_busca_registros_fecha_mes($mes, $ano)
    {

        $conectar = parent::conexion();

        $mes = $_POST["mes"];
        $ano = $_POST["ano"];

        $fecha = ($ano . "-" . $mes . "%");

//        $sql = "SELECT * FROM compras WHERE fecha_compra like ? ";
        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha AS fecha_cita, c.medicamentos, c.prescripcion, c.sintomas, c.id_usuario,c.id_medico, c.estado, c.fecha_ingreso, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from citas c
           INNER JOIN pacientes p ON c.id_paciente = p.id_paciente WHERE c.fecha LIKE ? ORDER BY c.id_cita ASC ";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecha);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    }


    public function get_cita_por_id_usuario($id_usuario){

        $conectar= parent::conexion();

        $sql="select * from citas where id_usuario=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);


    }

    //metodo para consultar si la tabla tiene registros asociados
    public function get_cita_por_id_medico($id_medico)
    {

        $conectar = parent::conexion();

        $sql = "select * from citas where id_medico=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_medico);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

    //metodo para consultar si la tabla tiene registros asociados
    public function get_cita_por_medico($medico)
    {
        $conectar = parent::conexion();
        $medico = $_POST["medico"];
//        $sql = "SELECT * FROM compras WHERE fecha_compra like ? ";
        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha as fecha_cita, c.medicamentos, c.prescripcion, c.sintomas, c.id_medico, c.fecha_ingreso, c.estado, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, 
                        p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion, m.identidad as identidadM, m.nombre as nombreM, m.apellido as apellidoM
           from citas c, pacientes p, medicos m    
           WHERE  c.id_paciente = p.id_paciente AND c.id_medico = m.id_medico AND m.id_medico=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $medico);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);


    }


    //BUSCA REGISTROS CITAS-FECHA-MES
    public function busca_registros_mes($mes1, $ano1)
    {

        $conectar = parent::conexion();

        $mes = $_POST["mes1"];
        $ano = $_POST["ano1"];

        $fecha = ($ano . "-" . $mes . "%");

//        $sql = "SELECT * FROM compras WHERE fecha_compra like ? ";
        $sql = "select c.id_cita,c.id_paciente,c.lugar,c.hora,c.fecha AS fecha_cita, c.medicamentos, c.prescripcion, c.sintomas, c.id_usuario,c.id_medico, c.estado, c.fecha_ingreso, p.id_paciente, p.identidad, p.nombre, p.apellido, p.genero, p.fecha, p.tipo_sangre, p.edad, p.telefono, p.correo, p.direccion
           from citas c
           INNER JOIN pacientes p ON c.id_paciente = p.id_paciente WHERE c.fecha LIKE ? ORDER BY c.id_cita ASC ";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecha);
        $sql->execute();
        return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    }


}

?>