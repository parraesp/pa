<?php
session_start();
if (isset($_SESSION['user'])) {
    $ban = false;
    ?>
    <!DOCTYPE HTML>
    <html>
        <head>
            <title>Social Flat - Inicio</title>
            <?php include_once './includes/headers.html'; ?>
        </head>
        <body class="right-sidebar">
            <!-- Header -->
            <?php include_once './includes/nav.html'; ?>

            <!-- Main -->
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="8u" id="content">
                            <?php
                            if (isset($_POST['name']) && isset($_POST['personas']) && isset($_POST['direccion']) && isset($_POST['descripcion'])) {
                                $ban = true;
                                filter_input(FILTER_SANITIZE_STRING, $_POST['name']);
                                filter_input(FILTER_SANITIZE_NUMBER_INT, $_POST['personas']);
                                filter_input(FILTER_SANITIZE_STRING, $_POST['direccion']);
                                filter_input(FILTER_SANITIZE_STRING, $_POST['descripcion']);
                                if (strlen($_POST['name']) < 5 || strlen($_POST['name']) > 25) {
                                    ?>
                                    <div class="error">&iexcl;El nombre debe tener entre 5 y 25 caracteres!</div>
                                    <?php
                                    $ban = false;
                                }
                                if (!is_numeric($_POST['personas']) || !preg_match('/^\d+$/', $_POST['personas']) || $_POST['personas'] < 0) {
                                    ?>
                                    <div class="error">&iexcl;Numero de personas tiene que ser un n&uacute;mero entero positivo!</div>
                                    <?php
                                    $ban = false;
                                } if (strlen($_POST['direccion']) < 15 || strlen($_POST['direccion']) > 60) {
                                    ?>
                                    <div class="error">&iexcl;La direccii&oacute;n debe tener entre 15 y 60 caracteres!</div>
                                    <?php
                                    $ban = false;
                                }
                                if (strlen($_POST['descripcion']) < 25 || strlen($_POST['descripcion']) > 200) {
                                    ?>
                                    <div class="error">&iexcl;La descripci&oacute;n debe tener entre 25 y 200 caracteres!</div>
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
                                    // A guardar!
                                    $conexion = mysql_connect("localhost", "root", "");
                                    mysql_select_db('social_flat', $conexion);
                                    $creador = $_SESSION['user'];
                                    $nombre = $_POST['name'];
                                    $num_personas = $_POST['personas'];
                                    $direccion = $_POST['direccion'];
                                    $descripcion = $_POST['descripcion'];
                                    $longitud = explode(' ',$_POST['coords'])[0];
                                    $latitud = explode(' ',$_POST['coords'])[1];
                                    $query = mysql_query("INSERT INTO `piso`(`ID_piso`, `creador`, `nombre`, `num_personas`, `direccion`, `descripcion`, `estatus`, `latitud`, `longitud`) VALUES (NULL, '$creador', '$nombre', '$num_personas', '$direccion', '$descripcion', '1', '$longitud', '$longitud');") or die(mysql_error());
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
                                <label>Direcci&oacute;n </label><textarea  name="direccion" placeholder="Direcci&oacute;n f&iacute;sica del piso" required pattern=".{15,60}" title="Debe tener de 15 a 60 caracteres"/><?php
                                if (isset($_POST['direccion'])) {
                                    echo $_POST['direccion'];
                                }
                                ?></textarea><br/>
                                <label>Descripci&oacute;n</label><textarea  name="descripcion"
                                                                            placeholder="Descripci&oacute;n p&uacute;blica del piso" required pattern=".{25,200}" title="Debe tener de 25 a 200 caracteres" value='<?php
                                                                            if (isset($_POST['descripcion'])) {
                                                                                echo $_POST['descripcion'];
                                                                            }
                                                                            ?>'/><?php
                                                                            if (isset($_POST['descripcion'])) {
                                                                                echo $_POST['descripcion'];
                                                                            }
                                                                            ?></textarea><br/>
                                <input type="hidden" name="coords"  id="coord" value="<?php
                                if (isset($_POST['coords'])) {
                                    echo $_POST['coords'];
                                }
                                ?>"/>
                                <input type="submit" value="Enviar">
                                <form>

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
                                } else {
                                    setcookie('auth', 'auth', time() + 74);
                                    header('Location: ../entrar.php?auth=f');
                                }
                                ?>