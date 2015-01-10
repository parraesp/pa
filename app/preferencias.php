<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Preferencias</title>
            <?php
            mysql_connect('localhost', 'root', '');
            mysql_select_db('social_flat');
            ?>
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
                    <h2>Preferencias</h2>
                    <?php
                    $email = $_SESSION['user'];
                    $idpiso = $_SESSION['idpiso'];
                    if (isset($_POST['editarNombre'])) {
                        $salt1 = '$%325cxwe2KK';
                        $salt2 = 'asdad$&/&/&';
                        $confPassword = md5($salt1 . $_POST['password'] . $salt2);
                        $result = mysql_query("SELECT password FROM `user` WHERE `email`='$email'");
                        $password = mysql_fetch_array($result)[0];
                        if ($confPassword === $password) {
                            $username = $_POST['nombre'];
                            mysql_query("UPDATE `social_flat`.`user` SET username='$username' WHERE `email`='$email'");
                            ?>
                            <div class="success">Nombre modificado con &eacute;xito.</div>
                            <?php
                        } else {
                            ?>
                            <div class="error">La contrase&ntilde;a no es v&aacute;lida.</div>
                            <?php
                        }
                    }
                    if (isset($_POST['cambiarPass'])) {
                        $salt1 = '$%325cxwe2KK';
                        $salt2 = 'asdad$&/&/&';
                        $confPassword = md5($salt1 . $_POST['passAnt'] . $salt2);
                        $result = mysql_query("SELECT password FROM `user` WHERE `email`='$email'");
                        $password = mysql_fetch_array($result)[0];
                        if ($confPassword === $password) {
                            $newPass = md5($salt1 . $_POST['newPass'] . $salt2);
                            $newPass2 = md5($salt1 . $_POST['confPass'] . $salt2);
                            if ($newPass === $newPass2) {
                                mysql_query("UPDATE `social_flat`.`user` SET password='$newPass' WHERE `email`='$email'");
                                ?>
                                <div class="success">Contrase&ntilde;a modificada con &eacute;xito.</div>
                                <?php
                            } else {
                                ?>
                                <div class="error">Las contrase&ntilde;as no coinciden.</div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="error">La contrase&ntilde;a no es v&aacute;lida.</div>
                            <?php
                        }
                    }
                    $result = mysql_query("SELECT username FROM `user` WHERE `email`='$email'");
                    $username = mysql_fetch_array($result)[0];
                    $result2 = mysql_query("SELECT creador,nombre,num_personas,direccion,descripcion FROM `piso` WHERE `ID_piso`='$idpiso'");
                    $piso = mysql_fetch_array($result2);
                    ?>
                    <a onclick="mostrarCuenta()" class="button">Mi cuenta</a>
                    <a onclick="mostrarPiso()" class="button">Mi piso</a>
                    <div id="datosUsuario">
                        <p><strong>Nombre:</strong> <?php echo "$username"; ?><p>
                        <p><strong>Email:</strong> <?php echo "$email"; ?><p>
                            <a onclick="editarNombre()" >Editar nombre</a>
                            <a onclick="cambiarContrasenia()" >Cambiar contrase&ntilde;a</a>
                    </div>
                    <?php if ($piso['creador'] === $email) { ?>
                        <div id="datosPiso">
                            <p><strong>Nombre:</strong> <?php echo "$username"; ?><p>
                            <p><strong>Email:</strong> <?php echo "$email"; ?><p>
                                <a onclick="editarNombre()" >Editar nombre</a>
                                <a onclick="cambiarContrasenia()" >Cambiar contrase&ntilde;a</a>
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
        header('Location: ../entrar.php?auth = f');
    }
    ?>