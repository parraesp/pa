<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Preferencias</title>
            <?php
            mysql_connect('localhost', 'root', '');
            mysql_select_db('social_flat');
            ?>
            <?php include_once './includes/headers.html'; ?>
            <?php include_once './includes/functions.php'; ?>
        </head>
        <body class="right-sidebar" onload="<?php
        if (nuevo()) {
            header('Location: reg.php');
        }
        ?>">
            <!-- Header -->
            <?php include_once './includes/nav.html'; ?>
            <!-- Main -->

            <div class="wrapper style1">
                <div class="container">
                    <h2>Turnos de limpieza</h2>
                    <?php
                    if (isset($_POST['enviarLimpieza'])) {
                        $validar = TRUE;
                        $inicio = filter_input(INPUT_POST, 'inicio', FILTER_SANITIZE_STRING);
                        $inicioArray = explode('-', $inicio);
                        $fin = filter_input(INPUT_POST, 'fin', FILTER_SANITIZE_STRING);
                        $finArray = explode('-', $fin);
                        $frecuencia = filter_input(INPUT_POST, 'frecuencia', FILTER_VALIDATE_INT);
                        $zonas = filter_input(INPUT_POST, 'zonas', FILTER_VALIDATE_INT);
                        if ($zonas === NULL || $zonas === FALSE || $zonas < 0 || $zonas > 10) {
                            $validar = FALSE;
                            ?>
                            <div class="error">Las zonas debe ser un entero positivo</div>.
                            <?php
                        } else {
                            for ($i = 0; $i < $zonas; $i++) {
                                $zona[$i] = filter_input(INPUT_POST, 'zona' . $i, FILTER_SANITIZE_STRING);
                                if ($zona[$i] === NULL || $zona[$i] === FALSE) {
                                    $validar = FALSE;
                                    ?>
                                    <div class="error">Las zona de limpieza debe una cadena de caract&eacute;res.</div>.
                                    <?php
                                }
                            }
                            if ($inicio === NULL || $inicio === FALSE || !checkdate($inicioArray[1], $inicioArray[2], $inicioArray[0])) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Las fecha de inicio debe seguir el formato aaaa-dd-mm.</div>.
                                <?php
                            }
                            if ($fin === NULL || $fin === FALSE || !checkdate($finArray[1], $finArray[2], $finArray[0]) || $fin < $inicio) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Las fecha de fin debe debe seguir el formato aaaa-dd-mm y ser mayor que la de inicio.</div>.
                                <?php
                            }if ($frecuencia === NULL || $frecuencia === FALSE || $frecuencia < 0) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Las frecuencia debe ser un n&uacute;mero entero.</div>.
                                <?php
                            }
                        }
                        if ($validar) {
                            $idpiso = $_SESSION['idpiso'];
                            $result = mysql_query("SELECT * FROM `limpieza` WHERE `ID_piso`='$idpiso'");
                            if (mysql_num_rows($result) == 0) {
                                $query = "INSERT INTO `social_flat`.`limpieza` (`ID_piso`, `inicio`, `fin`, `frecuencia`) VALUES ('$idpiso', '$inicio', '$fin', '$frecuencia');";
                                $res = mysql_query($query);
                                for ($i = 0; $i < $zonas; $i++) {
                                    $nombre = $zona[$i];
                                    $query = "INSERT INTO `social_flat`.`zonas_limpieza` (`ID_piso`, `nombre`) VALUES ('$idpiso', '$nombre');";
                                    $res = mysql_query($query);
                                }
                            } else {
                                $query = "UPDATE `social_flat`.`limpieza` SET inicio='$inicio',fin='$fin',frecuencia='$frecuencia' WHERE `ID_piso`='$idpiso'";
                                $res = mysql_query($query);
                                $result = mysql_query("SELECT nombre FROM `zonas_limpieza` WHERE `ID_piso`='$idpiso'");
                                if ($zonas != 0) {
                                    while ($zonaAux = mysql_fetch_row($result)) {
                                        mysql_query("DELETE FROM `zonas_limpieza` WHERE ID_piso='$idpiso' AND nombre='$zonaAux[0]'");
                                    }
                                    for ($i = 0; $i < $zonas; $i++) {
                                        $nombre = $zona[$i];
                                        $query = "INSERT INTO `social_flat`.`zonas_limpieza` (`ID_piso`, `nombre`) VALUES ('$idpiso', '$nombre');";
                                        $res = mysql_query($query);
                                    }
                                }
                            }
                            ?><script type='text/javascript'> location.replace("limpieza.php");</script><?php
                        }
                    }
                    ?>
                    <p onclick="confirmDel('¿Desea eliminar los turnos de limpieza?', 'limpieza.php?borrarLimpieza')" class="button">Eliminar turnos de limpieza</p>
                    <p onclick="mostrarFormularioLimpieza()" class="button">Editar turnos de  limpieza</p>
                    <form id = 'formularioLimpieza' action = '#' method = 'post'>
                        <p>Especifica el inicio y fin de los turnos de limpieza.</p>
                        Inicio: <input type = 'date' name = 'inicio' required="required"><br>
                        Fin: <input type = 'date' name = 'fin'><br>
                        <p>La frecuencia, en d&iacute;as, con la que se limpiar&aacute; el piso.</p>
                        Frecuencia: <input type = 'number' name = 'frecuencia'><br>
                        <p>N&uacute;mero de zonas a limpiar en el piso.</p>
                        Zonas: <input type = 'number' id = 'zonas' name = 'zonas' value = '0' onchange = "aniadir_zonas(this)"><br>
                        <input type='submit' value='Enviar' name='enviarLimpieza'>
                    </form>
                    <div id="calendar"></div>
                </div>
            </div>
            <?php include_once './includes/footer.html'; ?>

        </body>
    </html>
    <?php
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth = f');
}
?>