<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    filter_input(FILTER_SANITIZE_STRING, $_POST['password']);
    filter_input(FILTER_SANITIZE_EMAIL, $_POST['email']);
    filter_input(FILTER_VALIDATE_EMAIL, $_POST['email']);
    $email = $_POST['email'];
    $salt1 = '$%325cxwe2KK';
    $salt2 = 'asdad$&/&/&';
    $password = md5($salt1 . $_POST['password'] . $salt2);
    $conexion = mysql_connect("localhost", "root", "");
    mysql_select_db('social_flat', $conexion);
    $query = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email' AND `password` LIKE '$password'");
    if (mysql_num_rows($query) != 0) {
        if (isset($_POST['recordar'])) {
            setcookie('recordar', $_POST['email'], time() + 30 * 3600 * 24);
        }
        header('Location: APP');
    }
}
?>
<html>
    <head>
        <title>Social Flat - Entrar</title>
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
        <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
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
                        <?php if(isset($_COOKIE['exito']) && isset($_GET['reg'])){ ?>
                        <div class="success">&iexcl;Usuario creado con exito!</div>
                    <?php }?>
                        <header>
                            <h2>Entrar</h2>
                        </header>
                        <form action="#" method="post">
                            <label>E-mail </label><input type="email" name="email" required oninput="" value="<?php if(isset($_COOKIE["recordar"])){echo $_COOKIE["recordar"];} ?>"/><br/>
                            <label>Contrase&ntilde;a </label><input type="password" name="password"  id="password" required pattern=".{8,18}" maxlength="18" title="Debe tener de 8 a 18 caracteres"/>  <br/>
                            <label>&iquest;Recordar usuario?<input type="checkbox" checked name="recordar"/></label><br/>
                            <input type="submit" value="Enviar">
                            <form>

                                </div>
                                <div class="4u" id="sidebar">
                                    <hr class="first" />
                                    <section>
                                        <header>
                                            <h3>&iquest;No tienes cuenta en Social Flat?</h3>
                                        </header>
                                        <p>
                                            Ser miembro de social flat es gratuito y no tiene ning&uacute;n
                                            tipo de compromiso. En la comunidad conocer&aacute; mucha gente
                                            y &iexcl;podr&aacute; llevar la gesti&oacute;n de su piso de una forma
                                            m&aacute;s c&oacute;moda! Registrate haciendo click arriba en &quot;Registro&quot;
                                        </p>
                                    </section>
                                    <hr />  
                                    <section>
                                        <header>
                                            <h3><a href="#">&iquest;Necesitas ayuda?</a></h3>
                                        </header>
                                        <p>
                                            M&aacute;ndanos un ticket o un correo electr&oacute;nico lo antes posible
                                        </p>
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
