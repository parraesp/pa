<?php
session_start();
include_once 'includes/functions.php';
if (isset($_SESSION['user'])) {
    
    conectarBD();
    ?>
    <!DOCTYPE HTML>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Social Flat - Buscar piso</title>
            <?php include_once './includes/headers.html'; ?>
        </head>
        <body class="right-sidebar" onload="<?php
        if (!nuevo()) {
            header('Location: home.php');
        }
        ?>">
            <!-- Header -->
            <?php include_once './includes/nav.html'; ?>
            <?php
            include_once './includes/functions.php';
            if (solicitud()) {
                header('Location: reg.php');
            }
            ?>

            <!-- Main -->
            <div class="wrapper style1">
                <div class="container">
                    <div class="row 200%">
                        <div class="content">
                            <?php
                            if (isset($_POST['search'])) {
                                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                                $personas = filter_input(INPUT_POST, 'personas', FILTER_VALIDATE_INT);
                                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                                $ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
                                //Obtenemos primero todos los pisos y a filtrar
                                $pisos = mysql_query("SELECT * FROM `piso`;");
                                $pisos_2return = array();
                                while ($tmp = mysql_fetch_array($pisos)) {
                                    $bandera = true;
                                    if (!is_null($name) && $name !== false) {
                                        if (strtolower($name) != strtolower(substr($tmp[2], 0, strlen($name))) && strtolower($name) != strtolower(substr($tmp[2], strlen($name)))) {
                                            $bandera = false;
                                        }
                                    }
                                    if (!is_null($email) && $email !== false) {
                                        if (strtolower($email) != strtolower(substr($tmp[1], 0, strlen($email))) && strtolower($email) != strtolower(substr($tmp[1], strlen($email)))) {
                                            $bandera = false;
                                        }
                                    }
                                    if (!is_null($personas) && $personas !== false) {
                                        if ($personas != $tmp[3]) {
                                            $bandera = false;
                                        }
                                    }
                                    if (!is_null($ciudad) && $ciudad !== false) {
                                        if (strtolower($ciudad) != strtolower(substr($tmp[9], 0, strlen($ciudad))) && strtolower($ciudad) != strtolower(substr($tmp[9], strlen($ciudad)))) {
                                            $bandera = false;
                                        }
                                    }
                                    if ($bandera) {
                                        $pisos_2return[] = $tmp;
                                    }
                                }
                            } else {
                                ?><div class="info">&iexcl;Rellena todos los campos que quieras utilizar como criterio de b&uacute;queda!</div>
                                <?php
                            }
                            ?>
                            <div class="info">Recuerda que puedes <strong><a href='create.php'>crear</a></strong> tu propio piso</div>
                            <header>
                                <h2>Buscar piso</h2>
                            </header>
                            <?php if (isset($_POST['search'])) { ?>
                                <table  class="default" style="table-layout:fixed;">
                                    <legend>Pisos</legend>
                                    <tr><th>Creador</th><th>Nombre</th><th>Personas</th><th>Direcci&oacute;n</th><th>Ciudad</th></tr>
                                    <?php
                                    if (count($pisos_2return) != 0) {
                                        for ($i = 0; $i < count($pisos_2return); $i++) {
                                            ?>
                                            <tr><td onclick="SendRequest('<?php echo $pisos_2return[$i][5] ?>', '<?php echo $pisos_2return[$i][1] ?>', '<?php echo $_SESSION['user']; ?>');"><?php echo $pisos_2return[$i][1]; ?></td><td><?php echo $pisos_2return[$i][2]; ?></td><td><?php echo $pisos_2return[$i][3]; ?></td><td style="overflow: hidden; text-overflow-mode: "><?php echo $pisos_2return[$i][4]; ?></td><td><?php echo $pisos_2return[$i][9]; ?></td></tr>
                                                    <?php
                                                }
                                            }/* else{echo '<tr><td>-------Ning&uacute;n piso que coincida con los datos insertados------</td></tr>';} */
                                            ?>
                                </table>
                            <?php } ?>
                            <form action="#" method="post">
                                <label>Nombre </label><input type="text" name="name" value='<?php
                                if (isset($_POST['name'])) {
                                    echo $_POST['name'];
                                }
                                ?>' placeholder="Nombre del piso" pattern=".{5,25}" title="Debe tener de 5 a 25 caracteres"/>
                                <label>Ciudad </label><input type="text" name="ciudad" value='<?php
                                if (isset($_POST['ciudad'])) {
                                    echo $_POST['ciudad'];
                                }
                                ?>' placeholder="Ciudad en la que se encuentra el piso" pattern=".{1,35}" title="Debe tener de 1 a 25 caracteres"/>
                                <label>E-mail del creador </label><input type="text" name="email" value='<?php
                                if (isset($_POST['email'])) {
                                    echo $_POST['email'];
                                }
                                ?>' placeholder="Email del creador" oninput=""/>
                                <label>N&uacute;mero de personas:  </label><input type="number" name="personas" value='<?php
                                if (isset($_POST['personas'])) {
                                    echo $_POST['personas'];
                                }
                                ?>' placeholder="N&uacute;mero de personas" oninput=""/><br/><br/>
                                <input type="submit" name='search' value="Enviar">
                            </form>
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
