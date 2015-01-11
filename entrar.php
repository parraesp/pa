<?php session_start(); ?>
<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    conectarBD();
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $salt1 = '$%325cxwe2KK';
    $salt2 = 'asdad$&/&/&';
    $password = md5($salt1 . filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) . $salt2);
    $query = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$email' AND `password` LIKE '$password'");
    if (mysql_num_rows($query) != 0) {
        if (isset($_POST['recordar'])) {
            setcookie('recordar', $_POST['email'], time() + 30 * 3600 * 24);
            $_SESSION['user'] = $_POST['email'];
            $temp = mysql_fetch_array($query);
            $_SESSION['idpiso'] = $temp[4];
        }
        header('Location: app/home.php');
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Social Flat - Entrar</title>
        <?php include_once 'app/includes/headers.html'; ?>
    </head>
    <body class="right-sidebar">
        <div id="header">
            <nav id="nav">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="left-sidebar.html">Sobre nosotros</a></li>
                    <li><a href="registro.php">Registro</a></li>
                    <li><a href="entrar.php">Entrar</a></li>
                </ul>
            </nav>
        </div>
        <div class="wrapper style1">
            <div class="container">
                <div class="row 200%">
                    <div class="8u" id="content">
                        <?php if (isset($_COOKIE['exito']) && isset($_GET['reg'])) { ?>
                            <div class="success">&iexcl;Usuario creado con exito!</div>
                        <?php } else if (isset($_GET['auth'])) { ?>
                            <div class="warning">&iexcl;Tienes que logearte para acceder a tu cuenta!</div>
                        <?php } else if (isset($_POST['email'])) {
                            ?><div class="error">&iexcl;Combinaci&oacute;n de usuario y contrase&ntilde;a incorrecta!</div>
                            <?php
                        }
                        ?>
                        <header>
                            <h2>Entrar</h2>
                        </header>
                        <form action="#" method="post">
                            <label>E-mail </label><input type="email" name="email" required oninput="" value="<?php
                        if (isset($_COOKIE["recordar"])) {
                            echo $_COOKIE["recordar"];
                        }
                        ?>"/><br/>
                            <label>Contrase&ntilde;a </label><input type="password" name="password"  id="password" required pattern=".{8,18}" maxlength="18" title="Debe tener de 8 a 18 caracteres"/>  <br/>
                            <label>&iquest;Recordar usuario?<input type="checkbox" checked name="recordar"/></label><br/>
                            <input type="submit" value="Enviar">
                        </form>

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
        <?php include_once 'app/includes/footer.html'; ?>
    </body>
</html>