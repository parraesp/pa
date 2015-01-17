<?php
include_once 'app/includes/functions.php';
conectarBD();
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Social Flat - Registro</title>
        <?php include_once 'app/includes/headers.html'; ?>
    </head>
    <body class="right-sidebar">

        <!-- Header -->
        <div id="header">
            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="sobre_nosotros.html">Sobre nosotros</a></li>
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
                        if (isset($_POST['enviarRegistro'])) {
                            $validar = true;
                            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                            $passwordRepeat = filter_input(INPUT_POST, 'password_repeat', FILTER_SANITIZE_STRING);
                            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                            $salt1 = '$%325cxwe2KK';
                            $salt2 = 'asdad$&/&/&';
                            $query = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email'");
                            if ($email === NULL || $email === FALSE) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Introduzca un email v&aacute;lido.</div>
                                <?php
                            }
                            if ($password === NULL || $password === FALSE) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Introduzca una contrase&ntilde;a.</div>
                                <?php
                            }
                            if ($passwordRepeat === NULL || $passwordRepeat === FALSE || $password != $passwordRepeat) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Las contrase&ntilde;as deben coincidir.</div>
                                <?php
                            }
                            if ($name === NULL || $name === FALSE || strlen($name) < 5 || strlen($name) > 25) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Introduzca un nombre entre 5 y 25 caracteres.</div>
                                <?php
                            }
                            if ($validar) {
                                if (mysql_num_rows($query) == 0) {
                                    $password = md5($salt1 . $password . $salt2);
                                    mysql_query("INSERT INTO `u776346137_socia`.`user` (`ID_user`, `email`, `username`, `password`, `id_piso`) VALUES (NULL, '$email', '$name', '$password', -1);");
                                    setcookie('exito', 'exito', time() + 8);
                                    header('Location: entrar.php?reg=suc');
                                } else {
                                    ?>
                                    <div class="error">&iexcl;Ese correo ya est&aacute; registrado!</div>
                                    <?php
                                }
                            }
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
                            <label>Nombre </label><input type="text" name="name" value='<?php
                            if (isset($_POST['name'])) {
                                echo $_POST['name'];
                            }
                            ?>' placeholder="Nombre a mostrar" required pattern=".{5,25}" title="Debe tener de 5 a 25 caracteres"/><br/>
                            <label>E-mail </label><input type="email" name="email" value='<?php
                            if (isset($_POST['email'])) {
                                echo $_POST['email'];
                            }
                            ?>' placeholder="Ser&aacute; tu usuario" required oninput=""/><br/>
                            <label>Contrase&ntilde;a </label><input type="password" name="password"  id="password" placeholder="Tu contrase&ntilde;a" oninput="check2(this)" required pattern=".{8,18}" maxlength="18" title="Debe tener de 8 a 18 caracteres"/>  <br/>
                            <label>Repita su contrase&ntilde;a </label><input type="password" name="password_repeat" placeholder="Rep&iacute;tela" required="required" oninput="check(this)" maxlength="18"/>  <br/>
                            <input type="submit" name="enviarRegistro" value="Enviar">
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
            <!-- Contact -->
            <section class="contact">
                <ul class="icons">
                    <li>
                        <a href="https://twitter.com/Social_Flat" class="icon fa-twitter">
                            <span class="label">
                                Twitter
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/pages/Social-Flat/1017974724883225?ref=bookmarks" class="icon fa-facebook">
                            <span class="label">
                                Facebook
                            </span>
                        </a>
                    </li>

                </ul>
            </section>
            <!-- Copyright -->
            <div class="copyright">
                <ul class="menu">
                    <li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                </ul>
            </div>
        </div>
    </body>
</html>
