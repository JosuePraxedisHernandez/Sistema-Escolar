<?php
    class Conexion{

        public static $instancia = null;
        public static function crearInstancia(){

            if (!isset(self::$instancia)) {

                $opciones[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $servidor = "localhost";
                $base = "Sistema_Escolar";
                $usuario = "root";
                $pass = "";

                self::$instancia = new PDO('mysql:host=' . $servidor . '; dbname=' . $base, $usuario, $pass, $opciones);
            }
            return self::$instancia;
        }

    }