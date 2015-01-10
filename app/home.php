<?php
session_start();
if (isset($_SESSION['user'])) {
    include_once './includes/functions.php';
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Inicio</title>
            <?php include_once './includes/headers.html'; ?>
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
                            $user = $_SESSION['user'];
                            if (isset($_GET['reject'])) {
                                $id = $_GET['reject'];
                                $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id' AND `id` LIKE '$id'");
                                if (!is_bool($var)) {
                                    if (mysql_num_rows($var) == 1) {
                                        mysql_query("UPDATE `mensaje` SET `estado`='2'  WHERE `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id'");
                                    }
                                } else {
                                    echo "FRECH";
                                }
                            } else if (isset($_GET['accept'])) {
                                $id = $_GET['accept'];
                                $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id' ");
                                if (!is_bool($var)) {
                                    if (mysql_num_rows($var) == 1) {
                                        mysql_query("UPDATE `mensaje` SET `estado`='1' WHERE `destinatario` LIKE '$user' AND `id_mensaje` LIKE '$id'") or die(mysql_error());
                                        $creador = $var['destinatario'];
                                        $datos = mysql_query("SELECT * FROM `piso` WHERE `creador` LIKE '$creador'");
                                        $data = mysql_fetch_array($datos);
                                        print_r($data);
                                        $var_temp = $var['autor'];
                                        mysql_query("UPDATE `user` SET `id_piso`='$data[0]' WHERE `email` LIKE '$var_temp'");
                                    }
                                } else {
                                    echo "FRECH";
                                }
                            }
                            $var = mysql_query("SELECT * FROM `mensaje` WHERE `estado` LIKE '0' AND `destinatario` LIKE '$user'");
                            if (mysql_num_rows($var) > 0) {
                                $mensaje = mysql_fetch_row($var);
                                ?>
                                <div class="info" onclick="mensaje('<?php echo $mensaje[1]; ?>', '<?php echo $mensaje[2]; ?>', '<?php echo $mensaje[3]; ?>', '<?php echo $mensaje[0]; ?>', '<?php echo $mensaje[5]; ?>')">&iexcl;Tienes nuevos mensajes!</div>
    <?php }
    ?>


                        </div>
                        <div class="4u" id="sidebar">
                            <hr class="first" />
                            <section>
                                <header>
                                    <h3>&iquest;Conoce las ventajas de ser miembro de Social Flat?</h3>
                                </header>
                                <p>
                                    Ser miembro de social flat es gratuito y no tiene ning&uacute;n
                                    tipo de compromiso. En la comunidad conocer&aacute; mucha gente
                                    y &iexcl;podr&aacute; llevar la gesti&oacute;n de su piso de una forma
                                    m&aacute;s c&oacute;moda!
                                </p>
                            </section>
                            <hr />  
                            <section>
                                <header>
                                    <h3><a href="#">No olvide leer las condiciones de servicio</a></h3>
                                </header>
                                <p>
                                    Son cortas y de obligatoria lectura. &iexcl;Las aceptas automaticamente al registrarte
                                    en Social Flat!      
                                </p>
                                <footer>
                                    <a class="button" onclick="terms()">Condiciones</a>
                                </footer>
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
    header('Location: ../entrar.php?auth=f');
}
?>