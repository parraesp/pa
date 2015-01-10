<?php

function nuevo() {
    $ban = false;
    $us = $_SESSION['user'];
    $query = "SELECT * FROM `piso` WHERE `creador` LIKE '$us';";
    $conexion = mysql_connect("localhost", "root", "");
    mysql_select_db('social_flat', $conexion);
    $q = mysql_query($query);
    if (mysql_num_rows($q) == 0) {
        $ban = true;
    }
    return $ban;
}

function solicitud() {
    $ban = false;
    $us = $_SESSION['user'];
    $query = "SELECT * FROM `mensaje` WHERE `autor` LIKE '$us' AND `estado`<3;";
    $conexion = mysql_connect("localhost", "root", "");
    mysql_select_db('social_flat', $conexion);
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
    $conexion = mysql_connect("localhost", "root", "");
    mysql_select_db('social_flat', $conexion);
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
