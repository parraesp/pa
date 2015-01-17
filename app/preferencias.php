<?php
session_start();
if (isset($_SESSION['user'])) {
include_once './includes/functions.php'; 
            conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Social Flat - Preferencias</title>
            <?php include_once './includes/headers.html'; ?>

            <script type="text/javascript">
                <!--
                        $(document).ready(function() {
    <?php if (isset($_GET['piso']) || isset($_GET['borrarPiso'])) { ?>
                        $('#datosUsuario').hide();
    <?php } else { ?>
                        $('#datosPiso').hide();
    <?php } ?>
                });
    //-->
            </script>
        </head>
        <body class="no-sidebar">
            <?php include_once './includes/nav.html'; ?>
            <div class="wrapper style1">
                <div class="container">
                    <h2>Preferencias</h2>
                    <?php
                    $email = $_SESSION['user'];
                    $idpiso = $_SESSION['idpiso'];
                    $sinPiso = false;
                    if ($idpiso == '-1') {
                        $sinPiso = true;
                    }
                    if (isset($_GET['borrarPiso'])) {
                        mysql_query("UPDATE `u776346137_socia`.`user` SET id_piso='-1' WHERE `email`='$email'");
                        $_SESSION['idpiso'] = '-1';
                        $result = mysql_query("SELECT email FROM `user` WHERE `id_piso`='$idpiso'");
                        $nuevo = mysql_fetch_array($result);
                        if ($nuevo) {
                            $nuevoEmail = $nuevo['email'];
                            mysql_query("UPDATE `u776346137_socia`.`piso` SET creador='$nuevoEmail' WHERE `ID_piso`='$idpiso'");
                        } else {
                            mysql_query("DELETE FROM `piso` WHERE ID_piso='$idpiso'");
                        }
                        ?><script type='text/javascript'> location.replace('preferencias.php');</script><?php
                    }
                    if (isset($_GET['borrarUsuario'])) {
                        mysql_query("DELETE FROM `user` WHERE email='$email'");
                        $result = mysql_query("SELECT email FROM `user` WHERE `id_piso`='$idpiso'");
                        $nuevo = mysql_fetch_array($result);
                        if ($nuevo) {
                            $nuevoEmail = $nuevo['email'];
                            mysql_query("UPDATE `u776346137_socia`.`piso` SET creador='$nuevoEmail' WHERE `ID_piso`='$idpiso'");
                        } else {
                            mysql_query("DELETE FROM `piso` WHERE ID_piso='$idpiso'");
                        }
                        session_destroy();
                        ?><script type='text/javascript'> location.replace('preferencias.php');</script><?php
                    }
                    if (isset($_POST['editarPiso'])) {
                        $salt1 = '$%325cxwe2KK';
                        $salt2 = 'asdad$&/&/&';
                        $confPassword = md5($salt1 . filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) . $salt2);
                        $result = mysql_query("SELECT password FROM `user` WHERE `email`='$email'");
                        $password = mysql_fetch_array($result);
                        if ($confPassword === $password[0]) {
                            $validar = true;
                            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                            $num = filter_input(INPUT_POST, 'num', FILTER_VALIDATE_INT);
                            $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
                            $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
                            if ($nombre === NULL || $nombre === FALSE || strlen($nombre) > 25) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Hay que especificar una nombre para el piso y debe ser menor de 25 caracteres.</div>
                                <?php
                            }
                            if ($num === NULL || $num === FALSE || $num < 0) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Hay entero positivo para el n&uacute;mero de personas.</div>
                                <?php
                            }
                            if ($direccion === NULL || $direccion === FALSE || strlen($direccion) > 60) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Hay que especificar una direcci&oacute;n y debe ser menor de 60 caracteres.</div>
                                <?php
                            }
                            if ($descripcion === NULL || $descripcion === FALSE || strlen($descripcion) > 200) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Hay que especificar una descripci&oacute;n y debe ser menor de 200 caracteres.</div>
                                <?php
                            }
                            if ($validar) {
                                mysql_query("UPDATE `u776346137_socia`.`piso` SET nombre='$nombre',num_personas='$num',direccion='$direccion',descripcion='$descripcion' WHERE `ID_piso`='$idpiso'");
                                ?>
                                <div class="success">Piso modificado con &eacute;xito.</div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="error">La contrase&ntilde;a no es v&aacute;lida.</div>
                            <?php
                        }
                    }
                    if (isset($_POST['editarNombre'])) {
                        $salt1 = '$%325cxwe2KK';
                        $salt2 = 'asdad$&/&/&';
                        $confPassword = md5($salt1 . filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) . $salt2);
                        $result = mysql_query("SELECT password FROM `user` WHERE `email`='$email'");
                        $password = mysql_fetch_array($result);
                        if ($confPassword === $password[0]) {
                            $username = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                            if ($username === NULL || $username === FALSE || strlen($username) > 25 || strlen($username) < 5) {
                                $validar = FALSE;
                                ?>
                                <div class="error">Hay que especificar una nombre entre 5 y 25 caracteres.</div>
                                <?php
                            } else {
                                mysql_query("UPDATE `u776346137_socia`.`user` SET username='$username' WHERE `email`='$email'");
                                ?>
                                <div class="success">Nombre modificado con &eacute;xito.</div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="error">La contrase&ntilde;a no es v&aacute;lida.</div>
                            <?php
                        }
                    }
                    if (isset($_POST['cambiarPass'])) {
                        $salt1 = '$%325cxwe2KK';
                        $salt2 = 'asdad$&/&/&';
                        $confPassword = md5($salt1 . filter_input(INPUT_POST, 'passAnt', FILTER_SANITIZE_STRING) . $salt2);
                        $result = mysql_query("SELECT password FROM `user` WHERE `email`='$email'");
                        $password = mysql_fetch_array($result);
                        if ($confPassword === $password[0]) {
                            $newPass = md5($salt1 . filter_input(INPUT_POST, 'newPass', FILTER_SANITIZE_STRING) . $salt2);
                            $newPass2 = md5($salt1 . filter_input(INPUT_POST, 'confPass', FILTER_SANITIZE_STRING) . $salt2);
                            if ($newPass === $newPass2) {
                                mysql_query("UPDATE `u776346137_socia`.`user` SET password='$newPass' WHERE `email`='$email'");
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
                    $username = mysql_fetch_array($result);
                    if (!$sinPiso) {
                        $result2 = mysql_query("SELECT creador,nombre,num_personas,direccion,descripcion FROM `piso` WHERE `ID_piso`='$idpiso'");
                        $piso = mysql_fetch_assoc($result2);
                        $creador = $piso['creador'];
                        $nombrePiso = $piso['nombre'];
                        $direccion = $piso['direccion'];
                        $descripcion = $piso['descripcion'];
                        $num_personas = $piso['num_personas'];
                    }
                    ?>
                    <a onclick="mostrarCuenta()" class="button">Mi cuenta</a>
                    <a onclick="mostrarPiso()" class="button">Mi piso</a>
                    <div id="datosUsuario">
                        <p><strong>Nombre:</strong> <?php echo "$username[0]"; ?></p>
                        <p><strong>Email:</strong> <?php echo "$email"; ?></p>
                        <ul>
                            <li><a onclick="editarNombre()">Editar nombre</a></li>
                            <li><a onclick="cambiarContrasenia()">Cambiar contrase&ntilde;a</a></li>
                            <li><a onclick="confirmDel('¿Desea borrar su cuenta de forma definitiva?', 'preferencias.php?borrarUsuario')">Borrar Cuenta</a></li>
                        </ul>
                    </div>
                    <?php if (!$sinPiso) { ?>
                        <div id="datosPiso">
                            <p><strong>Nombre del piso:</strong> <?php echo "$nombrePiso"; ?></p>
                            <p><strong>N&uacute;mero de personas:</strong> <?php echo "$num_personas"; ?></p>
                            <p><strong>Direcci&oacute;n:</strong> <?php echo "$direccion"; ?></p>
                            <p><strong>Descripci&oacute;n:</strong> <?php echo "$descripcion"; ?></p>
                            <ul>
                                <?php if ($creador === $email) { ?>
                                    <li><a onclick="editarPiso(<?php echo"'$nombrePiso'"; ?>,<?php echo"'$num_personas'"; ?>
                                                    ,<?php echo"'$direccion'"; ?>,<?php echo"'$descripcion'"; ?>)">Editar piso</a></li>
                                    <?php } ?>
                                <li><a onclick="confirmDel('¿Desea salirse del piso?', 'preferencias.php?borrarPiso')">Salirse del piso</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <p>&Uacute;nete a <a href="reg.php">un piso.</a></p>
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
