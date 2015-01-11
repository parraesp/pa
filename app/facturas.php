<?php
session_start();
if (isset($_SESSION['user'])) {
    include_once './includes/functions.php';
    conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Facturas</title>
            <?php include_once './includes/headers.html'; ?>
        </head>
        <body class="right-sidebar" onload="<?php
        if (nuevo()) {
            header('Location: reg.php');
        }
        ?>">
            <!-- Header -->
            <?php
            include_once './includes/nav.html';
            ?>

            <!-- Main -->
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_GET['fec']) && isset($_GET['pay'])) {
                                $factura = filter_input(INPUT_GET, 'fec', FILTER_SANITIZE_STRING);
                                if ($_GET['pay'] === 'N') {
                                    $bandera = 1;
                                } else {
                                    $bandera = 0;
                                }
                                $user = $_SESSION['user'];
                                mysql_query("UPDATE `factura_deud` SET `estado`='$bandera' WHERE `fecha` LIKE '$factura' AND `deudor` LIKE '$user'");

                                $var = mysql_query("SELECT * FROM `factura_deud` WHERE `fecha` LIKE '$factura' AND `estado` LIKE '0'");
                                if (mysql_num_rows($var) == 0) {
                                    mysql_query("UPDATE `factura` SET `estado`='1' WHERE `fecha` LIKE '$factura'");
                                } else {
                                    mysql_query("UPDATE `factura` SET `estado`='0' WHERE `fecha` LIKE '$factura'");
                                }
                            } else if (isset($_GET['fec']) && isset($_GET['delete'])) {
                                $user = $_SESSION['user'];
                                $fe = filter_input(INPUT_GET, 'fec', FILTER_SANITIZE_STRING);
                                $var = mysql_query("DELETE FROM `factura` WHERE `creador` LIKE '$user' AND `fecha` LIKE '$fe'");
                            }
                            if (isset($_POST['gast'])) {
                                $ban = true;
                                $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                                $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
                                $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);
                                $user = $_SESSION['user'];
                                $piso = $_SESSION['idpiso'];
                                if ($nombre === NULL || $nombre === FALSE) {
                                    ?>
                                    <div class="error">El nombre debe ser v&aacute;lido.</div>
                                    <?php
                                    $ban = false;
                                }
                                if ($valor === NULL || $valor === FALSE) {
                                    ?>
                                    <div class="error">El valor debe ser v&aacute;lido.</div>
                                    <?php
                                    $ban = false;
                                }
                                if ($fecha === NULL || $fecha === FALSE) {
                                    ?>
                                    <div class="error">La fecha debe ser v&aacute;lido.</div>
                                    <?php
                                    $ban = false;
                                }
                                if ($ban) {
                                    $query = "INSERT INTO `social_flat`.`factura` (`ID_factura`, `ID_piso`, `creador`, `valor`, `fecha`, `estado`, `nombre`) VALUES (NULL, '$piso', '$user', '$valor', '$fecha', '0', '$nombre');";
                                    $res = mysql_query($query);
                                    $var = mysql_query("SELECT `ID_factura` FROM `factura` ORDER BY `fecha` DESC LIMIT 1");
                                    $id = mysql_fetch_array($var)[0];
                                    $var2 = mysql_query("SELECT * FROM `user` WHERE `id_piso` LIKE '$piso'");

                                    while ($id2 = mysql_fetch_row($var2)) {
                                        $query = "INSERT INTO `social_flat`.`factura_deud` (`ID_factura`, `deudor`, `fecha`, `estado`) VALUES ('$id', '$id2[1]', '$fecha', '0');";
                                        mysql_query($query);
                                    }
                                    ?>
                                    <div class="success">&iexcl;Factura creada con exito!</div>
                                <?php }
                            }
                            ?>
                            <header>
                                <h2>Facturas</h2>
                            </header>
                            <a onclick="crearFactura(<?php $_SESSION['user']; ?>)" class="button">Crear Factura</a>
                            <?php
                            $estado = 0;
                            $piso = $_SESSION['idpiso'];
                            $user = $_SESSION['user'];
                            $query = "SELECT * FROM `factura` WHERE `ID_piso` LIKE '$piso' ORDER BY `fecha` DESC";
                            $res = mysql_query($query);
                            ?>
                            <table class="default"><tr><th>Nombre</th><th>Importe</th><th>Fecha</th><th>Estado</th></tr>
                                <?php
                                $total_balance = 0;
                                $pagados = mysql_query("SELECT * FROM `factura_deud` WHERE `deudor` LIKE '$user' ORDER BY `fecha` DESC");
                                if (!is_bool($res)) {
                                    while ($tmp = mysql_fetch_row($res)) {
                                        $pagado_temp = mysql_fetch_row($pagados);
                                        ?>
                                        <tr onClick="factura('<?php
                                        if ($tmp[5]) {
                                            echo 'Pagada';
                                        } else {
                                            echo 'No pagada';
                                            $total_balance-=$tmp[3];
                                        }
                                        ?>',<?php echo $tmp[4]; ?>, '<?php
                                        if ($pagado_temp[3]) {
                                            echo 'Pagada';
                                        } else {
                                            echo 'No pagada';
                                        }
                                        ?>', '<?php
                                        if ($tmp[2] == $_SESSION['user']) {
                                            echo 'true';
                                        } else {
                                            echo 'false';
                                        }
                                        ?>'
                                                                    )"><td><?php echo $tmp[6]; ?></td><td><?php echo $tmp[3]; ?></td><td><?php echo date('Y-m-d', $tmp[4]); ?></td><td><?php
                                                    if ($tmp[5]) {
                                                        echo 'Pagada';
                                                    } else {
                                                        echo 'No pagada';
                                                    }
                                                    ?></td></tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                            </table>
                        </div>
                        <div class="4u" id="sidebar">
                            <hr class="first" />
                            <section>
                                <header>
                                    <h2>Su estatus</h2>
                                    <h3><?php
                                        $resultado = mysql_query("SELECT `num_personas` FROM `piso` WHERE `ID_piso` LIKE '$piso'");
                                        $numero = mysql_fetch_row($resultado);
                                        $divisor = $numero[0];
                                        if ($divisor == 0) {
                                            $divisor = 1;
                                        }
                                        echo number_format($total_balance / $divisor, 2)
                                        ?>€</h3>
                                </header>

                            </section>
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
    header('Location: ../entrar.php?auth = f');
}
?>
