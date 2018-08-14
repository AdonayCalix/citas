<?php

//conexion a la base de datos

//require_once("../config/conexion.php");


class Usuarios extends Conectar
{

    public function login()
    {

        $conectar = parent::conexion();
        parent::set_names();

        if (isset($_POST["enviar"])) {

            //INICIO DE VALIDACIONES
            $password = $_POST["password"];

//            $correo = $_POST["correo"];

            $usuario = $_POST["correo"];
//
//            $cedula = $_POST["correo"];

            $estado = "1";

            if (empty($usuario) and empty($password)) {

                header("Location:" . Conectar::ruta() . "index.php?m=2");
                exit();


            }
            else {

                $sql = "select * from usuarios where usuario=? and password=? and estado=?";

                $sql = $conectar->prepare($sql);

                $sql->bindValue(1, $usuario);
//                $sql->bindValue(2, $usuario);
//                $sql->bindValue(3, $cedula);
                $sql->bindValue(2, $password);
                $sql->bindValue(3, $estado);
//                $sql->bindValue(4, $usuario);
                $sql->execute();
                $resultado = $sql->fetch();

                //si existe el registro entonces se conecta en session
                if (is_array($resultado) and count($resultado) > 0) {

                    $_SESSION["id_usuario"] = $resultado["id_usuario"];
                    $_SESSION["correo"] = $resultado["correo"];
                    $_SESSION["usuario"] = $resultado["usuario"];
                    $_SESSION["cedula"] = $resultado["cedula"];
                    $_SESSION["nombre"] = $resultado["nombres"];
                    $_SESSION["apellido"] = $resultado["apellidos"];
                    $_SESSION["imagen"] = $resultado["imagen"];

                    //PERMISOS DEL USUARIO PARA ACCEDER A LOS MODULOS
                    require_once("Usuarios.php");

                    $usuario = new Usuarios();

                    //VERIFICAMOS SI EL USUARIO TIENE PERMISOS A CIERTOS MODULOS
                    $marcados = $usuario->listar_permisos_por_usuario($resultado["id_usuario"]);

                    //print_r($marcados);

                    //declaramos el array para almacenar todos los registros marcados
                    $valores = array();

                    foreach ($marcados as $row) {

                        $valores[] = $row["id_permiso"];
                    }

                    ////Determinamos los accesos del usuario
                    in_array(1, $valores) ? $_SESSION['citas'] = 1 : $_SESSION['citas'] = 0;
                    in_array(2, $valores) ? $_SESSION['pacientes'] = 1 : $_SESSION['pacientes'] = 0;
                    in_array(3, $valores) ? $_SESSION['medicos'] = 1 : $_SESSION['medicos'] = 0;
                    in_array(4, $valores) ? $_SESSION['usuarios'] = 1 : $_SESSION['usuarios'] = 0;
                    in_array(5, $valores) ? $_SESSION['reporte_citas'] = 1 : $_SESSION['reporte_citas'] = 0;
                    in_array(6, $valores) ? $_SESSION['empresa'] = 1 : $_SESSION['empresa'] = 0;

                    header("Location:" . Conectar::ruta() . "vistas/home.php");

                    exit();


                } else {

                    //si no existe el registro aparece un mensaje
                    header("Location:" . Conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }

    //listar los usuarios
    public function get_usuarios()
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select * from usuarios";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /*poner la ruta vistas/upload*/
    public function upload_image()
    {

        if (isset($_FILES["usuario_imagen"])) {
            $extension = explode('.', $_FILES['usuario_imagen']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = '../vistas/upload/' . $new_name;
            move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $destination);
            return $new_name;
        }

    }

    //metodo para registrar usuario
    public function registrar_usuario($nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $imagen, $estado, $permisos)
    {
        $conectar = parent::conexion();

        require_once("Usuarios.php");

        $imagen_usuario = new Usuarios();

        $image = '';
        if ($_FILES["usuario_imagen"]["name"] != '') {
            $image = $imagen_usuario->upload_image();
        }

        $sql = "insert into usuarios 
             values(null,?,?,?,?,?,?,?,?,?,?,?,?,now());";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellido"]);
        $sql->bindValue(3, $_POST["cedula"]);
        $sql->bindValue(4, $_POST["telefono"]);
        $sql->bindValue(5, $_POST["email"]);
        $sql->bindValue(6, $_POST["direccion"]);
        $sql->bindValue(7, $_POST["cargo"]);
        $sql->bindValue(8, $_POST["usuario"]);
        $sql->bindValue(9, $_POST["password1"]);
        $sql->bindValue(10, $_POST["password2"]);
        $sql->bindValue(11, $image);
        $sql->bindValue(12, $_POST["estado"]);
        $sql->execute();

        //obtenemos el valor del id del usuario
        $id_usuario = $conectar->lastInsertId();

        //almacena todos los checkbox que han sido marcados
        $permisos = $_POST["permiso"];

        // print_r($_POST);

        $num_elementos = 0;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "insert into usuario_permiso
                values(null,?,?)";

            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->bindValue(1, $id_usuario);
            $sql_detalle->bindValue(2, $permisos[$num_elementos]);
            $sql_detalle->execute();

            //recorremos los permisos con este contador
            $num_elementos = $num_elementos + 1;
        }
    }

    //metodo para editar usuario
    public function editar_usuario($id_usuario, $nombre, $apellido, $cedula, $telefono, $email, $direccion, $cargo, $usuario, $password1, $password2, $imagen, $estado)
    {
        $conectar = parent::conexion();

        require_once("Usuarios.php");

        $imagen_usuario = new Usuarios();

        $imagen = '';

        if ($_FILES["usuario_imagen"]["name"] != '') {
            $imagen = $imagen_usuario->upload_image();
        } else {

            $imagen = $_POST["hidden_usuario_imagen"];
        }

        $sql = "update usuarios set 

              nombres=?,
              apellidos=?,
              cedula=?,
              telefono=?,
              correo=?,
              direccion=?,
              cargo=?,
              usuario=?,
              password=?,
              password2=?,
              imagen=?,
              estado = ?

              where 
              id_usuario=?



             ";

        //echo $sql;

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["apellido"]);
        $sql->bindValue(3, $_POST["cedula"]);
        $sql->bindValue(4, $_POST["telefono"]);
        $sql->bindValue(5, $_POST["email"]);
        $sql->bindValue(6, $_POST["direccion"]);
        $sql->bindValue(7, $_POST["cargo"]);
        $sql->bindValue(8, $_POST["usuario"]);
        $sql->bindValue(9, $_POST["password1"]);
        $sql->bindValue(10, $_POST["password2"]);
        $sql->bindValue(11, $imagen);
        $sql->bindValue(12, $_POST["estado"]);
        $sql->bindValue(13, $_POST["id_usuario"]);
        $sql->execute();

        //print_r($_POST);

        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sql_delete = "delete from usuario_permiso where id_usuario=?";
        $sql_delete = $conectar->prepare($sql_delete);
        $sql_delete->bindValue(1, $_POST["id_usuario"]);
        $sql_delete->execute();

        $permisos = $_POST["permiso"];

        // print_r($_POST);

        $num_elementos = 0;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "insert into usuario_permiso
                            values(null,?,?)";

            $sql_detalle = $conectar->prepare($sql_detalle);
            $sql_detalle->bindValue(1, $_POST["id_usuario"]);
            $sql_detalle->bindValue(2, $permisos[$num_elementos]);
            $sql_detalle->execute();
            //recorremos los permisos con este contador
            $num_elementos = $num_elementos + 1;
        }
    }

    //mostrar los datos del usuario por el id
    public function get_usuario_por_id($id_usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "select * from usuarios where id_usuario=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    public function editar_estado($id_usuario, $estado)
    {
        $conectar = parent::conexion();

        if ($_POST["est"] == "0") {

            $estado = 1;

        } else {

            $estado = 0;
        }

        $sql = "update usuarios set 
            
            estado=?

            where 
            id_usuario=?


   	    	";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_usuario);
        $sql->execute();

    }

    //valida la identidad y el correo del usuario
    public function get_cedula_correo_del_usuario($cedula, $email)
    {
        $conectar = parent::conexion();

        $sql = "select * from usuarios where cedula=? or correo=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $cedula);
        $sql->bindValue(2, $email);
        $sql->execute();

        return $resultado = $sql->fetchAll();

    }

    //método para eliminar un registro
    public function eliminar_usuario($id_usuario)
    {

        $conectar = parent::conexion();

        $sql = "delete from usuarios where id_usuario=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        return $resultado = $sql->fetch();
    }

    public function permisos()
    {

        $conectar = parent::conexion();

        $sql = "select * from permisos;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();


    }

    public function listar_permisos_por_usuario($id_usuario)
    {

        $conectar = parent::conexion();

        $sql = "select * from usuario_permiso where id_usuario=?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }


    public function get_usuario_permiso_por_id_usuario($id_usuario)
    {

        $conectar = parent::conexion();

        $sql = "select * from usuario_permiso where id_usuario=?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


    }

}


?>