<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat</title>
            <?php include_once './includes/headers.html'; ?>
            <?php include_once './includes/functions.php'; ?>
        </head>
        <body class="no-sidebar" onload="<?php
        if (!nuevo()) {
            header('Location: home.php');
        }
        ?>">

            <!-- Header -->
            <div id="header">				
                <?php include_once './includes/nav.html'; ?>
            </div>
            <!-- Main -->
            <div class="wrapper style1">

                <div class="container" style="margin-left: 20%;">
                    <?php
                    if (isset($_POST['contenido']) || solicitud()) {
                        if (!solicitud()) {
                            filter_input(FILTER_SANITIZE_STRING, $_POST['contenido']);
                            $user = $_SESSION['user'];
                            $dest = $_POST['recep'];
                            $cuerpo = $_POST['contenido'];
                            $fecha = time();
                            $query = "INSERT INTO `social_flat`.`mensaje` (`id_mensaje`, `autor`, `destinatario`, `fecha`, `estado`, `cuerpo`) VALUES (NULL, '$user', '$dest', '$fecha', '0', '$cuerpo');";
                            $conexion = mysql_connect("localhost", "root", "");
                            mysql_select_db('social_flat', $conexion);
                            mysql_query($query);
                        }
                        if (isset($_GET['can'])) {
                            $user = $_SESSION['user'];
                            $conexion = mysql_connect("localhost", "root", "");
                            mysql_select_db('social_flat', $conexion);
                            mysql_query("DELETE FROM `mensaje` WHERE `autor` LIKE '$user'");
                            header('Location: reg.php');
                        }
                        ?>
                        <div class="8u info" id="content">Tu solicitud ha sido enviada y est&aacute; a la espera de respuesta. Te rogamos paciencia.</div>
                        <div class="8u info" id="content">Puedes cancelar tu solicitud haciendo click <a href='?can=nao'>aqu&iacute;</a></div>
                        <script type="text/javascript">
                            window.setTimeout(function () {window.location="reg.php";}, 5000);
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