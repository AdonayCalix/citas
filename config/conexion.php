<?php

session_start();

class Conectar
{

    protected $dbh;

    protected function conexion()
    {


        try {

            $conectar = $this->dbh = new PDO("mysql:host=167.99.152.149;dbname=citasmedicas", "root", "w1234567890d");

            return $conectar;

        } catch (Exception $e) {

            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();

        }

    }

    public function ruta()
    {

        return "http://167.99.152.149/citas/";
    }


}//cierre de llave conectar

?>