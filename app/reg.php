<?php
session_start();
if (isset($_SESSION['user'])) {
    $ban = false;

    function nuevo() {
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
    ?>
    <!DOCTYPE HTML>
    <!--
            Helios by HTML5 UP
            html5up.net | @n33co
            Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
    -->
    <html>
        <head>
            <title>Social Flat</title>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            <meta name="description" content="" />
            <meta name="keywords" content="" />
            <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
            <script src="js/jquery.min.js"></script>
            <script src="js/jquery.dropotron.min.js"></script>
            <script src="js/jquery.scrolly.min.js"></script>
            <script src="js/jquery.onvisible.min.js"></script>
            <script src="js/skel.min.js"></script>
            <script src="js/skel-layers.min.js"></script>
            <script src="js/init.js"></script>
            <noscript>
            <link rel="stylesheet" href="css/skel.css" />
            <link rel="stylesheet" href="css/style.css" />
            <link rel="stylesheet" href="css/style-desktop.css" />
            <link rel="stylesheet" href="css/style-noscript.css" />
            </noscript>
            <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
        </head>
        <body class="no-sidebar" onload="<?php if (!nuevo()) {
        header('Location: home.php');
    } ?>">

            <!-- Header -->
            <div id="header">				
                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li>
                            <a href="">Dropdown</a>
                            <ul>
                                <li><a href="#">Lorem ipsum dolor</a></li>
                                <li><a href="#">Magna phasellus</a></li>
                                <li><a href="#">Etiam dolore nisl</a></li>
                                <li>
                                    <a href="">And a submenu &hellip;</a>
                                    <ul>
                                        <li><a href="#">Lorem ipsum dolor</a></li>
                                        <li><a href="#">Phasellus consequat</a></li>
                                        <li><a href="#">Magna phasellus</a></li>
                                        <li><a href="#">Etiam dolore nisl</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Veroeros feugiat</a></li>
                            </ul>
                        </li>
                        <li><a href="left-sidebar.html">Left Sidebar</a></li>
                        <li><a href="right-sidebar.html">Right Sidebar</a></li>
                        <li><a href="no-sidebar.html">No Sidebar</a></li>
                    </ul>
                </nav>

            </div>

            <!-- Main -->
            <div class="wrapper style1">

                <div class="container" style="margin-left: 20%;">
                    <div class="8u info" id="content">Elija una de las siguientes opciones</div>

                    <div class="row">

                        <article class="4u special">
                            <a href="#" class="image featured"><img src="css/images/create.png" alt="crear piso" /></a>
                            <header>
                                <h3><a href="#">Crear piso</a></h3>
                            </header>
                        </article>
                        <article class="4u special">
                            <a href="#" class="image featured"><img src="css/images/search.png" alt="Buscar piso" /></a>
                            <header>
                                <h3><a href="#">Buscar piso</a></h3>
                            </header>
                        </article>
                    </div>
                </div>

            </div>

           <?php include_once './includes/footer.html';?>
        </body>
    </html>
    <?php
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth=auth');
}
?>