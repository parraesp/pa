<?php
session_start();
if (isset($_SESSION['user'])) {
    include_once './includes/functions.php';
    conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat</title>
            <?php include_once './includes/headers.html'; ?>

        </head>
        <body class="no-sidebar" onload="<?php
        if (!nuevo()) {
            header('Location: home.php');
        }
        ?>">

            <!-- Header -->
                <?php include_once './includes/nav.html'; ?>
            <!-- Main -->
            <div class="wrapper style1">

                <div class="container" style="margin-left: 20%;">
                    <?php
                    if (isset($_POST['contenido']) || solicitud()) {
                        if (!solicitud()) {
                            $ban = true;
                            $user = $_SESSION['user'];
                            $dest = filter_input(INPUT_POST, 'recep', FILTER_SANITIZE_STRING);
                            $cuerpo = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_STRING);
                            $fecha = time();
                            if ($dest === NULL || $dest === FALSE) {
                                ?>
                                <div class="error">El destinatario debe ser v&aacute;lido.</div>
                                <?php
                                $ban = false;
                            }
                            if ($cuerpo === NULL || $cuerpo === FALSE) {
                                ?>
                                <div class="error">El contenido debe ser v&aacute;lido.</div>
                                <?php
                                $ban = false;
                            }
                            if ($ban) {
                                $query = "INSERT INTO `u776346137_socia`.`mensaje` (`id_mensaje`, `autor`, `destinatario`, `fecha`, `estado`, `cuerpo`) VALUES (NULL, '$user', '$dest', '$fecha', '0', '$cuerpo');";
                                mysql_query($query);
                            }
                        }
                        if (isset($_GET['can'])) {
                            $user = $_SESSION['user'];
                            mysql_query("DELETE FROM `mensaje` WHERE `autor` LIKE '$user'");
                            header('Location: reg.php');
                        }
                        ?>
                        <div class="8u info" id="content">Tu solicitud ha sido enviada y est&aacute; a la espera de respuesta. Te rogamos paciencia.</div>
                        <div class="8u info" id="content">Puedes cancelar tu solicitud haciendo click <a href='?can=nao'>aqu&iacute;</a></div>
                        <script type="text/javascript">
                            window.setTimeout(function() {
                                window.location = "reg.php";
                            }, 5000);
                        </script>
    <?php } else if (!isset($_POST['contenido'])) { ?>
                        <div class="8u info" id="content">Elija una de las siguientes opciones</div>
                        <div class="row">

                            <article class="4u special">
                                <a href="create.php" class="image featured"><img src="css/images/create.png" alt="crear piso" /></a>
                                <header>
                                    <h3><a href="create.php">Crear piso</a></h3>
                                </header>
                            </article>
                            <article class="4u special">
                                <a href="search.php" class="image featured"><img src="css/images/search.png" alt="Buscar piso" /></a>
                                <header>
                                    <h3><a href="search.php">Buscar piso</a></h3>
                                </header>
                            </article>

                        </div>
    <?php } ?>
                </div>

            </div>

    <?php include_once './includes/footer.html'; ?>
        </body>
    </html>
    <?php
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth=auth');
}
?>
