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

?>