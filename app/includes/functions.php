﻿<?php
if(isset($_GET['exit'])){
        session_destroy();
        header("Location: ../entrar.php");
}

function conectarBD() {
    $conexion = mysql_connect("localhost", "u776346137_socia", "12345678");
    mysql_select_db('u776346137_socia', $conexion);
}

function nuevo() {
    $ban = false;
    $us = $_SESSION['user'];
    $query = "SELECT * FROM `piso` WHERE `creador` LIKE '$us';";
    $conexion = mysql_connect("localhost", "u776346137_socia", "12345678");
    mysql_select_db('u776346137_socia', $conexion);
    $q = mysql_query($query);
    if (mysql_num_rows($q) == 0) {
        $query = "SELECT * FROM `user` WHERE `email` LIKE '$us' AND `id_piso`!= '-1';";
        $q = mysql_query($query);
    }
    if (mysql_num_rows($q) == 0) {
        $ban = true;
    }
    return $ban;
}

function solicitud() {
    $ban = false;
    $us = $_SESSION['user'];
    $query = "SELECT * FROM `mensaje` WHERE `autor` LIKE '$us' AND `estado` LIKE '0';";
    $conexion = mysql_connect("localhost", "u776346137_socia", "12345678");
    mysql_select_db('u776346137_socia', $conexion);
    $q = mysql_query($query);
    if (mysql_num_rows($q) == 1) {
        $ban = true;
    }
    return $ban;
}

function contactoSuyo($contacto) {
    $ban = false;
    $us = $_SESSION['idpiso'];
    $query = "SELECT * FROM `contacto` WHERE `ID_piso` LIKE '$us' AND `ID_contacto` LIKE '$contacto'";
    $conexion = mysql_connect("localhost", "u776346137_socia", "12345678");
    mysql_select_db('u776346137_socia', $conexion);
    $q = mysql_query($query);
    if (mysql_num_rows($q) == 1) {
        $ban = true;
    }
    return $ban;
}

function borrarLimpieza($idpiso) {
    mysql_query("DELETE FROM `zonas_limpieza` WHERE ID_piso='$idpiso'");
    mysql_query("DELETE FROM `limpieza` WHERE ID_piso='$idpiso'");
}

?>
