<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Facturas</title>
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
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_POST['gast'])) {
                                filter_input(FILTER_SANITIZE_STRING, $_POST['nombre']);
                                filter_input(FILTER_VALIDATE_FLOAT, $_POST['valor']);
                                mysql_connect('localhost', 'root', '');
                                mysql_select_db('social_flat');
                                $user = $_SESSION['user'];
                                $valor = $_POST['valor'];
                                $nombre = $_POST['nombre'];
                                $fecha = $_POST['fecha'];
                                $query = "INSERT INTO `social_flat`.`factura` (`ID_factura`, `creador`, `valor`, `fecha`, `estado`, `nombre`) VALUES (NULL, '$user', '$valor', '$fecha', '0', '$nombre');";
                                $res = mysql_query($query);
                                $var = mysql_query("SELECT `ID_factura` FROM `factura` ORDER BY `fecha` DESC LIMIT 1");
                                $id = mysql_fetch_array($var)[0];
                                $piso = $_SESSION['idpiso'];
                                $var2 = mysql_query("SELECT * FROM `user` WHERE `id_piso` LIKE '$piso'");
                                
                                while($id2 = mysql_fetch_row($var2)){
                                    $query = "INSERT INTO `social_flat`.`factura_deud` (`ID_factura`, `deudor`, `fecha`, `estado`) VALUES ('$id', '$id2[1]', '$fecha', '0');";
                                    mysql_query($query);
                                }
                                
                                ?>
                                <div class="success">&iexcl;Factura creada con exito!</div>
    <?php }
    ?>
                            <header>
                                <h2>Facturas</h2>
                            </header>
                            <p onclick="crearFactura(<?php $_SESSION['user']; ?>)" class="button">Crear Factura</p>
                            <?php
                            $estado = 0;
                            mysql_connect('localhost', 'root', '');
                            mysql_select_db('social_flat');
                            $user = $_SESSION['user'];
                            $query = "SELECT * FROM `factura` WHERE `creador` LIKE '$user' ORDER BY `factura`.`fecha` DESC;";
                            $res = mysql_query($query);
                            ?>
                            <table class="default"><tr><th>Nombre</th><th>Importe</th><th>Fecha</th><th>Estado</th></tr>
                                <?php
                                while ($tmp = mysql_fetch_row($res)) {
                                    if ($tmp[1] == $user) {
                                        ?>
                                        <tr onClick="factura('<?php if ($tmp[3]) {
                                echo 'Pagada';
                            } else {
                                echo 'No pagada';
                            } ?>',<?php echo $tmp[3]; ?>)"><td><?php echo $tmp[9]; ?></td><td><?php echo $tmp[5]; ?></td><td><?php echo date('Y-m-d', $tmp[7]); ?></td><td><?php if ($tmp[9]) {
                                echo 'Pagada';
                            } else {
                                echo 'No pagada';
                            } ?></td></tr>
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
                                    <h3>0.00€</h3>
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