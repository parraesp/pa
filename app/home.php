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
    <html>
        <head>
            <title>Social Flat - Inicio</title>
    <?php include_once './includes/headers.html'; ?>
        </head>
        <body class="right-sidebar" onload="<?php if (nuevo()) {
        header('Location: reg.php');
    } ?>">

            <!-- Header -->
    <?php include_once './includes/nav.html'; ?>

            <!-- Main -->
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php if (isset($_COOKIE['exito']) && isset($_GET['cre'])) { ?>
                            <div class="success">&iexcl;Usuario creado con exito!</div>
                        <?php }
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
                                <input type="submit" value="Enviar">
                                <form>

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
                                    setcookie('auth', 'auth', time() + 74);
                                    header('Location: ../entrar.php?auth=f');
                                }
                                ?>