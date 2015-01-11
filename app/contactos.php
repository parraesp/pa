<?php
session_start();
if (isset($_SESSION['user'])) {
    include_once './includes/functions.php';
    conectarBD()
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Contactos</title>
            <?php include_once './includes/headers.html'; ?>
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
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_POST['editarContacto'])) {
                                $piso = filter_input(INPUT_POST, 'piso', FILTER_SANITIZE_STRING);
                                if (contactoSuyo($piso)) {
                                    $validar = true;
                                    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                                    $telefono = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
                                    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                                    if ($email === NULL || $email === FALSE) {
                                        $validar = FALSE;
                                        ?>
                                        <div class="error">Introduzca un email v&aacute;lido.</div>
                                        <?php
                                    }if ($nombre === NULL || $nombre === FALSE) {
                                        $validar = FALSE;
                                        ?>
                                        <div class="error">Introduzca un nombre v&aacute;lido.</div>
                                        <?php
                                    }if ($telefono === NULL || $telefono === FALSE) {
                                        $validar = FALSE;
                                        ?>
                                        <div class="error">Introduzca un tel&eacute;fono v&aacute;lido.</div>
                                        <?php
                                    }
                                    if ($validar) {
                                        mysql_query("UPDATE `contacto` SET `nombre`='$nombre',`Telefono`=$telefono,`Email`='$email' WHERE `ID_contacto` LIKE '$piso'") or die(mysql_error());
                                    }
                                }
                            }
                            if (isset($_GET['erase']) && isset($_GET['id'])) {
                                $idef = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                                if (contactoSuyo($idef)) {
                                    mysql_query("DELETE FROM `contacto` WHERE `ID_contacto` LIKE '$idef'");
                                }
                            }
                            if (isset($_GET['edit']) || isset($_GET['delete'])) {
                                $val = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_STRING);
                                if (isset($_GET['edit'])) {
                                    if (contactoSuyo($val)) {
                                        $res = mysql_query("SELECT * FROM `contacto` WHERE `ID_contacto` LIKE '$val'");
                                        $tmp = mysql_fetch_array($res);
                                        $piso = $tmp[0];
                                        $nombre = $tmp[2];
                                        $telefono = $tmp[3];
                                        $email = $tmp[4];
                                        echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() {editarContacto('$piso','$nombre','$telefono', '$email')}, false);</script>";
                                    } else {
                                        ?>
                                        <div class="error">&iexcl;No tiene permiso sobre ese objeto!</div>
                                        <?php
                                    }
                                }
                                if (isset($_GET['delete'])) {
                                    $con = filter_input(INPUT_GET, 'delete', FILTER_SANITIZE_STRING);
                                    if (contactoSuyo($con)) {
                                        echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() {if(confirm('¿Deseas borrar el contacto?')==true){window.location.href='contactos.php?erase=true&id=$con';}}, false);</script>";
                                    } else {
                                        ?>
                                        <div class="error">&iexcl;No puede borrar ese objeto!</div>
                                        <?php
                                    }
                                }
                            }
                            $piso = $_SESSION['idpiso'];
                            if (isset($_POST['contacto'])) {
                                $validar = true;
                                $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
                                $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                                $telefono = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_STRING);
                                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                                if ($email === NULL || $email === FALSE) {
                                    $validar = FALSE;
                                    ?>
                                    <div class="error">Introduzca un email v&aacute;lido.</div>
                                    <?php
                                }if ($nombre === NULL || $nombre === FALSE) {
                                    $validar = FALSE;
                                    ?>
                                    <div class="error">Introduzca un nombre v&aacute;lido.</div>
                                    <?php
                                }if ($telefono === NULL || $telefono === FALSE) {
                                    $validar = FALSE;
                                    ?>
                                    <div class="error">Introduzca un tel&eacute;fono v&aacute;lido.</div>
                                    <?php
                                }
                                if ($validar) {
                                    $sql = "INSERT INTO `contacto`(`ID_contacto`, `ID_piso`, `nombre`, `Telefono`, `Email`) VALUES (NULL, $piso,'$nombre','$telefono','$email')";
                                    mysql_query($sql) or die(mysql_error());
                                    ?>
                                    <div class="success">&iexcl;Contacto creado con exito!</div>
                                <?php }
                            }
                            ?>
                            <header>
                                <h2>Contactos</h2>
                            </header>
                            <a onclick="crearContacto('<?php $_SESSION['idpiso']; ?>')" class="button">Crear Contacto</a>
                            <?php
                            $user = $_SESSION['user'];
                            $query = "SELECT * FROM `contacto` WHERE `ID_piso` LIKE '$piso';";
                            $res = mysql_query($query);
                            ?>
                            <table class="default"><tr><th>ID</th><th>Nombre</th><th>Tel&eacute;fono</th><th>Email</th></tr>
                                        <?php
                                        if (!is_bool($res)) {
                                            while ($tmp = mysql_fetch_row($res)) {
                                                ?>
                                        <tr onClick="contacto('<?php echo $tmp[0]; ?>', '<?php echo $tmp[2]; ?>', '<?php echo $tmp[3]; ?>', '<?php echo $tmp[4]; ?>')"><td><?php echo $tmp[0]; ?></td><td><?php echo $tmp[2]; ?></td><td><?php echo $tmp[3] ?></td><td><?php echo $tmp[4] ?></td></tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

    <?php include_once './includes/footer.html'; ?>

        </body>
    </html>
    <?php
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth=f');
}
?>