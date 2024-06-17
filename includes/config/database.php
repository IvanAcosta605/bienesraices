<?php
    function conectarDB() : mysqli {
        $db = new mysqli('localhost', 'root', '12345', 'bienesraices_crud');
        $db->set_charset('utf8');
        if(!$db){
            echo "ERROR DE CONEXION CON LA BASE DE DATOS";
            exit;
        }
        return $db;
    }