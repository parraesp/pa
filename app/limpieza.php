<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Limpieza</title>
            <?php
            mysql_connect('localhost', 'root', '');
            mysql_select_db('social_flat');
            ?>
            <?php include_once './includes/headers.html'; ?>
            <?php include_once './includes/functions.php'; ?>
            <link rel='stylesheet' href='./js/fullcalendar/fullcalendar.css' />
            <script src='./js/fullcalendar/lib/moment.min.js'></script>
            <script src='./js/fullcalendar/fullcalendar.js'></script>
            <script src='./js/fullcalendar/lang/es.js'></script>
            <script type="text/javascript">
                var zonas = [];
                var nombres = [];
    <?php
    $idpiso = $_SESSION['idpiso'];
    $result = mysql_query("SELECT * FROM `limpieza` WHERE `ID_piso`='$idpiso'");
    if (mysql_num_rows($result) > 0) {
        $datos = mysql_fetch_row($result);
        $inicio = $datos[1];
        $fin = $datos[2];
        $frecuencia = $datos[3];
        $result = mysql_query("SELECT nombre FROM `zonas_limpieza` WHERE `ID_piso`='$idpiso'");
        while ($zona = mysql_fetch_row($result)) {
            echo "zonas[zonas.length]=" . json_encode($zona) . ";";
        }
        $result2 = mysql_query("SELECT username FROM `user` WHERE `id_piso`='$idpiso'");
        while ($nombre = mysql_fetch_row($result2)) {
            echo "nombres[nombres.length]=" . json_encode($nombre) . ";";
        }
        ?>
                    Date.prototype.addDays = function(days)
                    {
                        var dat = new Date(this.valueOf());
                        dat.setDate(dat.getDate() + parseInt(days));
                        return dat;
                    };
                    var fechaInicio = new Date("<?php echo $inicio; ?>");
                    //Establecemos la fecha final
                    var fechaFinal = new Date("<?php echo $fin; ?>");
                    var frecuencia = <?php echo $frecuencia; ?>;
                    //Restamos la fechaFinal menos fechaInicio, 
                    //esto establece la diferencia entre las fechas
                    var fechaResta = fechaFinal - fechaInicio;
                    //Transformamos el tiempo de diferencia en días.
                    fechaResta = (((fechaResta / 1000) / 60) / 60) / 24;
                    var colores = ['blue', 'green', 'red', 'purple', 'chocolate', 'cyan', 'deeppink', 'gold', 'brown', 'black'];
                    var n = 0;
                    var eventos = [];
                    for (var i = 0; i < fechaResta; i += frecuencia) {
                        var days = 1000 * 60 * 60 * 24 * i;
                        var d1 = new Date(fechaInicio.getTime() + days);
                        var d2 = fechaInicio.addDays(i + frecuencia);
                        if (nombres.length === zonas.length) {
                            n++;
                            if (n === nombres.length) {
                                n = 0;
                            }
                        }
                        var nAux = nombres[n];
                        for (var j = 0; j < zonas.length; j++) {
                            n++;
                            if (n === nombres.length) {
                                n = 0;
                            }
                            var titulo = 'Zona:' + zonas[j] + '. Limpiador: ' + nombres[n];
                            eventos[eventos.length] = {title: titulo,
                                start: d1.getFullYear() + '-' + (parseInt(d1.getMonth()) + 1) + '-' + d1.getDate(),
                                end: d2.getFullYear() + '-' + (parseInt(d2.getMonth()) + 1) + '-' + d2.getDate(),
                                color: colores[j],
                                allDay: true};
                        }
                    }
                    $(document).ready(function() {
                        $('#formularioLimpieza').hide();
                        $('#calendar').fullCalendar({
                            events: eventos
                        });

                    });
        <?php
    }
    ?>
            </script>
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
                    <div id="calendar"></div>
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
                            }if ($frecuencia === NULL || $frecuencia === FALSE) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Las frecuencia debe ser un n&uacute;mero entero.</div>.
                                <?php
                            }
                        }
                        if ($validar) {
                            $idPiso = $_SESSION['idpiso'];
                            $result = mysql_query("SELECT * FROM `limpieza` WHERE `ID_piso`='$idpiso'");
                            if (mysql_num_rows($result) == 0) {
                                $query = "INSERT INTO `social_flat`.`limpieza` (`ID_piso`, `inicio`, `fin`, `frecuencia`) VALUES ('$idPiso', '$inicio', '$fin', '$frecuencia');";
                                $res = mysql_query($query);
                                for ($i = 0; $i < $zonas; $i++) {
                                    $nombre = $zona[$i];
                                    $query = "INSERT INTO `social_flat`.`zonas_limpieza` (`ID_piso`, `nombre`, `color`) VALUES ('$idPiso', '$nombre', '$color');";
                                    $res = mysql_query($query);
                                }
                            } else {
                                $query = "UPDATE `social_flat`.`limpieza` SET inicio='$inicio',fin='$fin',frecuencia='$frecuencia' WHERE `ID_piso`='$idPiso'";
                                $res = mysql_query($query);
                                $result = mysql_query("SELECT nombre FROM `zonas_limpieza` WHERE `ID_piso`='$idpiso'");
                                while ($zonaAux = mysql_fetch_row($result)) {
                                    mysql_query("DELETE FROM `zonas_limpieza` WHERE ID_piso='$idpiso' AND nombre='$zonaAux[0]'");
                                }
                                for ($i = 0; $i < $zonas; $i++) {
                                    $nombre = $zona[$i];
                                    $query = "INSERT INTO `social_flat`.`zonas_limpieza` (`ID_piso`, `nombre`) VALUES ('$idPiso', '$nombre');";
                                    $res = mysql_query($query);
                                }
                            }
                            ?>
                            <div class="success">Turnos de limpieza guardados con &eacute;xito.</div>
                            <?php
                        }
                    }
                    ?>
                    <p onclick="mostrarFormularioLimpieza()" class="button">Editar turnos de  limpieza</p>
                    <form id = 'formularioLimpieza' action = '#' method = 'post'>
                        <p>Especifica el inicio y fin de los turnos de limpieza.</p>
                        Inicio: <input type = 'date' name = 'inicio' required="required"><br>
                        Fin: <input type = 'date' name = 'fin'><br>
                        <p>La frecuencia con la que se limpiar&aacute; el piso.</p>
                        Frecuencia: <input type = 'number' name = 'frecuencia'><br>
                        <p>N&uacute;mero de zonas a limpiar en el piso.</p>
                        Zonas: <input type = 'number' id = 'zonas' name = 'zonas' value = '0' onchange = "aniadir_zonas(this)"><br>
                        <input type='submit' value='Enviar' name='enviarLimpieza'>
                    </form>
                    <p>Si editas el calendario, debes volver a seleccionar limpieza para cargar el nuevo calendario.</p>
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