<?php
session_start();
if (isset($_SESSION['user'])) {
    include_once './includes/functions.php';
    conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Social Flat - Inicio</title>
            <?php include_once './includes/headers.html'; ?>
            <script type="text/javascript">
                <!--
                var zonas = [];
                var nombres = [];
    <?php
    if (isset($_SESSION['idpiso'])) {
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
                            $('#calendar').fullCalendar({
                                events: eventos,
                                aspectRatio: 1
                            });
                        });
            <?php
        }
    }
    ?>
        //-->
            </script>
        </head>
        <body class="right-sidebar" onload="<?php
        if (nuevo()) {
            header('Location: reg.php');
        }
        ?>">
                  <?php include_once './includes/nav.html'; ?>
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <h2>Inicio</h2>
                            <?php
                            $user = $_SESSION['user'];
                            if (isset($_GET['reject'])) {
                                $id = filter_input(INPUT_GET, 'reject', FILTER_SANITIZE_STRING);
                                $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id'");
                                if (!is_bool($var)) {
                                    if (mysql_num_rows($var) == 1) {
                                        mysql_query("UPDATE `mensaje` SET `estado`='2'  WHERE `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id'");
                                    }
                                }
                            } else if (isset($_GET['accept'])) {
                                $id = filter_input(INPUT_GET, 'accept', FILTER_SANITIZE_STRING);
                                $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id' ");
                                if (!is_bool($var)) {
                                    if (mysql_num_rows($var) == 1) {
                                        mysql_query("UPDATE `mensaje` SET `estado`='1' WHERE `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id'") or die(mysql_error());
                                        $datos = mysql_query("SELECT * FROM `piso` WHERE `creador` LIKE '$user'");
                                        $data = mysql_fetch_array($datos);
                                        $var_temp = mysql_fetch_array($var);
                                        mysql_query("UPDATE `user` SET `id_piso`='$data[0]' WHERE `email` LIKE '$var_temp[1]'");

                                        // Metemos los contactos en el piso
                                        $datos_contacto = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$var_temp[1]'");
                                        $res_datos_contacto = mysql_fetch_row($datos_contacto);
                                        mysql_query("INSERT INTO `contacto`(`ID_contacto`, `ID_piso`, `nombre`, `Telefono`, `Email`) VALUES (NULL, $data[0],'$res_datos_contacto[2]','-','$res_datos_contacto[1]')");
                                    }
                                }
                            }
                            $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user'");
                            if (mysql_num_rows($var) > 0) {
                                $mensaje = mysql_fetch_row($var);
                                ?>
                                <div class="info" onclick="mensaje('<?php echo $mensaje[1]; ?>', '<?php echo $mensaje[2]; ?>', '<?php echo $mensaje[3]; ?>', '<?php echo $mensaje[0]; ?>', '<?php echo $mensaje[5]; ?>')">&iexcl;Tienes nuevos mensajes!</div>
                                <?php
                            }
                            ?>
                            <a href="facturas.php"><div class="info">Tu balance asciende a <?php
                                    $piso = $_SESSION['idpiso'];
                                    $query = "SELECT * FROM `factura` WHERE `ID_piso` LIKE '$piso' ORDER BY `fecha` DESC";
                                    $res = mysql_query($query);
                                    $total_balance = 0;
                                    $pagados = mysql_query("SELECT * FROM `factura_deud` WHERE `deudor` LIKE '$user' ORDER BY `fecha` DESC");
                                    if (!is_bool($res)) {
                                        while ($tmp = mysql_fetch_row($res)) {
                                            $pagado_temp = mysql_fetch_row($pagados);
                                            if (!$tmp[5]) {
                                                $total_balance-=$tmp[3];
                                            }
                                        }
                                    }
                                    $resultado = mysql_query("SELECT COUNT(*) FROM `user` WHERE `id_piso` LIKE '$piso'");
                                    $numero = mysql_fetch_row($resultado);
                                    $divisor = $numero[0];
                                    if ($divisor == 0) {
                                        $divisor = 1;
                                    }
                                    echo number_format($total_balance / $divisor, 2);
                                    ?> €</div></a>
                            <hr/>
                            <?php
                            $companeros = mysql_query("SELECT * FROM `user` WHERE `ID_piso` LIKE '$piso'");
                            $result2 = mysql_query("SELECT creador FROM `piso` WHERE `ID_piso`='$piso'");
                            $creador = mysql_fetch_assoc($result2);
                            if (isset($_GET['borrarUsuario'])) {
                                $id = filter_input(INPUT_GET, 'borrarUsuario', FILTER_SANITIZE_STRING);
                                $resultAux = mysql_query("SELECT id_piso FROM `user` WHERE `ID_user`='$id'");
                                $idpisoAux = mysql_fetch_assoc($resultAux);
                                if ($idpisoAux['id_piso'] == $piso && $creador['creador'] = $user) {
                                    mysql_query("UPDATE `u776346137_socia`.`user` SET id_piso='-1' WHERE `ID_user`='$id'");
                                }
                            }
                            ?>
                            <table class="default">
                                <tr>
                                    <th>Miembro</th><th>&iquest;Expulsar?</th>
                                </tr>
                                <?php
                                while ($companeros_array = mysql_fetch_assoc($companeros)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $companeros_array['username'] ?></td>
                                        <?php if ($creador === $user && $companeros_array['email'] != $user) { ?>
                                            <td><a onclick="confirmDel('¿Desea expulsarlo del piso?', 'home.php?borrarUsuario=<?php echo $companeros_array['ID_user'] ?>')">Expulsar compa&ntilde;ero</a></td>
                                        <?php } ?>                                    
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>


                        </div>
                        <div class="4u" id="sidebar">
                            <hr class="first" />
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

            </div>

            <?php include_once './includes/footer.html'; ?>

        </body>
    </html>
    <?php
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth=f');
}
?>
