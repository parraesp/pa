<?php
session_start();
if (isset($_SESSION['user'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Contactos</title>
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
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_POST['editarContacto'])) {
                                if (contactoSuyo($_POST['piso'])) {
                                    $piso = $_POST['piso'];
                                    $nombre = $_POST['nombre'];
                                    $telefono = $_POST['tel'];
                                    $email = $_POST['email'];
                                    mysql_query("UPDATE `contacto` SET `nombre`='$nombre',`Telefono`=$telefono,`Email`='$email' WHERE `ID_contacto` LIKE '$piso'") or die(mysql_error());
                                }
                            }
                            if(isset($_GET['erase']) && $_GET['id']){
                                if(contactoSuyo($_GET['id'])){
                                    $idef = $_GET['id'];
                                    mysql_query("DELETE FROM `contacto` WHERE `ID_contacto` LIKE '$idef'");
                                }
                            }
                            if (isset($_GET['edit']) || isset($_GET['delete'])) {

                                if (isset($_GET['edit'])) {
                                    if (contactoSuyo($_GET['edit'])) {
                                        $val = $_GET['edit'];
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
                                    if (contactoSuyo($_GET['delete'])) {
                                        $con = $_GET['delete'];
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
                                filter_input(FILTER_SANITIZE_STRING, $_POST['nombre']);
                                mysql_connect('localhost', 'root', '');
                                mysql_select_db('social_flat');
                                $user = $_SESSION['user'];
                                $nombre = $_POST['nombre'];
                                $telefono = $_POST['tel'];
                                $email = $_POST['email'];
                                $sql = "INSERT INTO `contacto`(`ID_contacto`, `ID_piso`, `nombre`, `Telefono`, `Email`) VALUES (NULL, $piso,'$nombre','$telefono','$email')";
                                mysql_query($sql) or die(mysql_error());
                                ?>
                                <div class="success">&iexcl;Contacto creado con exito!</div>
                            <?php }
                            ?>
                            <header>
                                <h2>Contactos</h2>
                            </header>
                            <p onclick="crearContacto('<?php $_SESSION['idpiso']; ?>')" class="button">Crear Contacto</p>
                            <?php
                            mysql_connect('localhost', 'root', '');
                            mysql_select_db('social_flat');
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
    header('Location: ../entrar.php?auth = f');
}
?>