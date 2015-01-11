<?php
session_start();
include_once 'includes/functions.php';
if (isset($_SESSION['user'])) {
    conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Social Flat - Inicio</title>
            <?php include_once './includes/headers.html';
            ?>
        </head>
        <body class="right-sidebar" onload="<?php
        if (!nuevo()) {
            header('Location: home.php');
        }
        ?>">
            <!-- Header -->
            <?php include_once './includes/nav.html'; ?>
            <?php
            if (solicitud()) {
                header('Location: reg.php');
            }
            ?>

            <!-- Main -->
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_POST['crearPiso'])) {
                                $ban = true;
                                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                                $num_personas = filter_input(INPUT_POST, 'personas', FILTER_VALIDATE_INT);
                                $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
                                $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
                                if ($name === NULL || $name === FALSE || strlen($name) < 5 || strlen($name) > 25) {
                                    ?>
                                    <div class="error">&iexcl;El nombre debe tener entre 5 y 25 caracteres!</div>
                                    <?php
                                    $ban = false;
                                }
                                if ($num_personas === NULL || $num_personas === FALSE || $num_personas < 0) {
                                    ?>
                                    <div class="error">&iexcl;N&uacute;mero de personas tiene que ser un n&uacute;mero entero positivo!</div>
                                    <?php
                                    $ban = false;
                                } if ($direccion === NULL || $direccion === FALSE || strlen($direccion) > 60) {
                                    ?>
                                    <div class="error">&iexcl;La direccii&oacute;n debe tener como mucho 60 caracteres!</div>
                                    <?php
                                    $ban = false;
                                }
                                if ($descripcion === NULL || $descripcion === FALSE || strlen($descripcion) > 200) {
                                    ?>
                                    <div class="error">&iexcl;La descripci&oacute;n debe tener como mucho 200 caracteres!</div>
                                    <?php
                                    $ban = false;
                                }
                                if (!isset($_POST['coords']) || is_null($_POST['coords']) || $_POST['coords'] == '') {
                                    ?>
                                    <div class="error">&iexcl;Activa la geolocalizaci&oacute;n!</div>
                                    <?php
                                    echo "<script>getLocation();</script>";
                                    $ban = false;
                                }
                                if ($ban) {
                                    $creador = $_SESSION['user'];
                                    $coordenadas = explode(' ', $_POST['coords']);
                                    $longitud = $coordenadas[0];
                                    $latitud = $coordenadas[1];
                                    $xml = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?latlng=" . $longitud . "," . $latitud . "&sensor=true");
                                    $ciudad = $xml->result[0]->address_component[2]->long_name[0]->__toString();
                                    $query = mysql_query("INSERT INTO `piso`(`ID_piso`, `creador`, `nombre`, `num_personas`, `direccion`, `descripcion`, `estatus`, `latitud`, `longitud`, `ciudad`) VALUES (NULL, '$creador', '$nombre', '$num_personas', '$direccion', '$descripcion', '1', '$longitud', '$latitud', '$ciudad');") or die(mysql_error());
                                    $num = mysql_query("SELECT `ID_piso` FROM `piso` ORDER BY `ID_piso` DESC LIMIT 1;");
                                    $val = mysql_fetch_array($num);
                                    mysql_query("UPDATE `user` SET `id_piso`='$val[0]' WHERE `email` LIKE '$creador'");
                                    $_SESSION['idpiso'] = $val[0];
                                    $user = $_SESSION['user'];
                                    $datos_contacto = mysql_query("SELECT * FROM `user` WHERE `email` LIKE '$user'");
                                    $res_datos_contacto = mysql_fetch_row($datos_contacto);
                                    mysql_query("INSERT INTO `contacto`(`ID_contacto`, `ID_piso`, `nombre`, `Telefono`, `Email`) VALUES (NULL, $val[0],'$res_datos_contacto[2]','-','$user')");
                                    setcookie('exito', 'exito', time() + 8);
                                    header('Location: home.php?cre=suc');
                                }
                            } else {
                                ?><div class="info">&iexcl;Todos los campos del formulario son obligatorios!</div>
                                <div class="warning"><strong>INFO: </strong> Activa la geolocalizaci&oacute;n o no podr&aacute;s registrarte</div>
                                <?php
                            }
                            if (!isset($_POST['coords']) || is_null($_POST['coords']) || $_POST['coords'] == '') {
                                echo "<script>getLocation();</script>";
                            }
                            ?>
                            <header>
                                <h2>Crear piso</h2>
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
                                ?>' placeholder="Nombre del piso" required pattern=".{5,25}" title="Debe tener de 5 a 25 caracteres"/><br/>
                                <label>N&uacute;mero de personas:  </label><input type="number" name="personas" value='<?php
                                if (isset($_POST['personas'])) {
                                    echo $_POST['personas'];
                                }
                                ?>' placeholder="N&uacute;mero de personas" required oninput=""/><br/>
                                <label>Direcci&oacute;n </label><textarea  name="direccion" placeholder="Direcci&oacute;n f&iacute;sica del piso"><?php
                                    if (isset($_POST['direccion'])) {
                                        echo $_POST['direccion'];
                                    }
                                    ?></textarea><br/>
                                <label>Descripci&oacute;n</label><textarea  name="descripcion"
                                                                            placeholder="Descripci&oacute;n p&uacute;blica del piso"><?php
                                                                                if (isset($_POST['descripcion'])) {
                                                                                    echo $_POST['descripcion'];
                                                                                }
                                                                                ?></textarea><br/>
                                <input type="hidden" name="coords"  id="coord" value="<?php
                                if (isset($_POST['coords'])) {
                                    echo $_POST['coords'];
                                }
                                ?>"/>
                                <input type="submit" name="crearPiso" value="Enviar">
                            </form>
                        </div>
                        <div class="4u" id="sidebar">
                            <hr class="first" />
                            <section>
                                <header>
                                    <h3>&iquest;Qu&eacute; datos son importantes?</h3>
                                </header>
                                <p>
                                    Una vez rellenado el formulario y que tengas tu piso
                                    podr&aacute;s a&ntilde;adir m&aacute;s datos como contactos
                                    de interes del piso, una descripci&oacute;n del piso que ser&aacute;
                                    vista cuando se busque el piso, etc.
                                </p>
                            </section>
                            <hr />  
                            <section>
                                <header>
                                    <h3><strong>ATENCI&Oacute;N</strong></h3>
                                </header>
                                <p>
                                    &iexcl;Es fundamental permitir el acceso a la geolocalizaci&oacute;n
                                    a Social Flat para detectar donde est&aacute; el piso!
                                </p>    
                            </section>
                        </div>
                    </div>
                </div>

            </div>

            <?php include_once './includes/footer.html'; ?>

        </body>
    </html>
    <?php
} else if (!nuevo()) {
    header('Location: home.php');
} else {
    setcookie('auth', 'auth', time() + 7);
    header('Location: ../entrar.php?auth=f');
}
?>
