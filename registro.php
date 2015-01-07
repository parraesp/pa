<!DOCTYPE HTML>
<?php
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])) {
    filter_input(FILTER_SANITIZE_STRING, $_POST['name']);
    filter_input(FILTER_SANITIZE_STRING, $_POST['password']);
    filter_input(FILTER_SANITIZE_STRING, $_POST['password_repeat']);
    filter_input(FILTER_SANITIZE_EMAIL, $_POST['email']);
    filter_input(FILTER_VALIDATE_EMAIL, $_POST['email']);
    $email = $_POST['email'];
    $name = $_POST['name'];
    $salt1 = '$%325cxwe2KK';
    $salt2 = 'asdad$&/&/&';
    $conexion = mysql_connect("localhost", "root", "");
    mysql_select_db('social_flat', $conexion);
    $query = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email'");
    if (mysql_num_rows($query) == 0) {
        $password = md5($salt1 . $_POST['password'] . $salt2);
        mysql_query("INSERT INTO `social_flat`.`user` (`ID_user`, `email`, `username`, `password`, `id_piso`) VALUES (NULL, '$email', '$name', '$password', -1);");
        setcookie('exito', 'exito', time() + 8);
        header('Location: entrar.php?reg=suc');
    }
}
?>
<html>
    <head>
        <title>Social Flat - Registro</title>
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
        <script src="js/forms.js" type="text/javascript"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        <link rel="stylesheet" href="css/style-noscript.css" />
        </noscript>
        <!-- Uso de shadowbox--->
        <link rel="stylesheet" type="text/css" href="css/shadowbox.css">
        <script type="text/javascript" src="js/sb/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>
    </head>
    <body class="right-sidebar">

        <!-- Header -->
        <div id="header">
            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="left-sidebar.html">Sobre nosotros</a></li>
                    <li><a href="registro.php">Registro</a></li>
                    <li><a href="entrar.php">Entrar</a></li>
                </ul>
            </nav>

        </div>

        <!-- Main -->
        <div class="wrapper style1">
            <div class="container">
                <div class="row 200%">
                    <div class="8u" id="content">
                        <?php
                        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])) {
                            ?>
                            <div class="error">&iexcl;Ese correo ya est&aacute; registrado!</div>
                            <?php
                        } else {
                            ?><div class="info">&iexcl;Todos los campos del formulario son obligatorios!</div>
                            <?php
                        }
                        ?>
                        <header>
                            <h2>Registro</h2>
                            <p>
                                Complete correctamente el siguiente formulario para empezar a usar Social Flat
                            </p>
                        </header>
                        <form action="#" method="post">
                            <?php ?>
                            <label>Nombre </label><input type="text" name="name" value='<?php if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            } ?>' placeholder="Nombre a mostrar" required pattern=".{5,25}" title="Debe tener de 5 a 25 caracteres"/><br/>
                            <label>E-mail </label><input type="email" name="email" value='<?php if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            } ?>' placeholder="Ser&aacute; tu usuario" required oninput=""/><br/>
                            <label>Contrase&ntilde;a </label><input type="password" name="password"  id="password" placeholder="Tu contrase&ntilde;a" oninput="check2(this)" required pattern=".{8,18}" maxlength="18" title="Debe tener de 8 a 18 caracteres"/>  <br/>
                            <label>Repita su contrase&ntilde;a </label><input type="password" name="password_repeat" placeholder="Rep&iacute;tela" required="required" oninput="check(this)" maxlength="18"/>  <br/>
                            <input type="submit" value="Enviar">
                            </form>

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

                                <!-- Footer -->
                                <div id="footer">
                                    <div class="container">
                                        <div class="row">

                                            <!-- Tweets -->
                                            <section class="4u">
                                                <header>
                                                    <h2 class="icon fa-twitter circled"><span class="label">Tweets</span></h2>
                                                </header>
                                                <ul class="divided">
                                                    <li>
                                                        <article class="tweet">
                                                            Amet nullam fringilla nibh nulla convallis tique ante sociis accumsan.
                                                            <span class="timestamp">5 minutes ago</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="tweet">
                                                            Hendrerit rutrum quisque.
                                                            <span class="timestamp">30 minutes ago</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="tweet">
                                                            Curabitur donec nulla massa laoreet nibh. Lorem praesent montes.
                                                            <span class="timestamp">3 hours ago</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="tweet">
                                                            Lacus natoque cras rhoncus curae dignissim ultricies. Convallis orci aliquet.
                                                            <span class="timestamp">5 hours ago</span>
                                                        </article>
                                                    </li>
                                                </ul>
                                            </section>

                                            <!-- Posts -->
                                            <section class="4u">
                                                <header>
                                                    <h2 class="icon fa-file circled"><span class="label">Posts</span></h2>
                                                </header>
                                                <ul class="divided">
                                                    <li>
                                                        <article class="post stub">
                                                            <header>
                                                                <h3><a href="#">Nisl fermentum integer</a></h3>
                                                            </header>
                                                            <span class="timestamp">3 hours ago</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="post stub">
                                                            <header>
                                                                <h3><a href="#">Phasellus portitor lorem</a></h3>
                                                            </header>
                                                            <span class="timestamp">6 hours ago</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="post stub">
                                                            <header>
                                                                <h3><a href="#">Magna tempus consequat</a></h3>
                                                            </header>
                                                            <span class="timestamp">Yesterday</span>
                                                        </article>
                                                    </li>
                                                    <li>
                                                        <article class="post stub">
                                                            <header>
                                                                <h3><a href="#">Feugiat lorem ipsum</a></h3>
                                                            </header>
                                                            <span class="timestamp">2 days ago</span>
                                                        </article>
                                                    </li>
                                                </ul>
                                            </section>

                                            <!-- Photos -->
                                            <section class="4u">
                                                <header>
                                                    <h2 class="icon fa-camera circled"><span class="label">Photos</span></h2>
                                                </header>
                                                <div class="row 25% no-collapse">
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic10.jpg" alt="" /></a>
                                                    </div>
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic11.jpg" alt="" /></a>
                                                    </div>
                                                </div>
                                                <div class="row 25% no-collapse">
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic12.jpg" alt="" /></a>
                                                    </div>
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic13.jpg" alt="" /></a>
                                                    </div>
                                                </div>
                                                <div class="row 25% no-collapse">
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic14.jpg" alt="" /></a>
                                                    </div>
                                                    <div class="6u">
                                                        <a href="#" class="image fit"><img src="images/pic15.jpg" alt="" /></a>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="12u">

                                                <!-- Contact -->
                                                <section class="contact">
                                                    <header>
                                                        <h3>Nisl turpis nascetur interdum?</h3>
                                                    </header>
                                                    <p>Urna nisl non quis interdum mus ornare ridiculus egestas ridiculus lobortis vivamus tempor aliquet.</p>
                                                    <ul class="icons">
                                                        <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                                                        <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                                                        <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                                                        <li><a href="#" class="icon fa-pinterest"><span class="label">Pinterest</span></a></li>
                                                        <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
                                                        <li><a href="#" class="icon fa-linkedin"><span class="label">Linkedin</span></a></li>
                                                    </ul>
                                                </section>

                                                <!-- Copyright -->
                                                <div class="copyright">
                                                    <ul class="menu">
                                                        <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                </body>
                                </html>