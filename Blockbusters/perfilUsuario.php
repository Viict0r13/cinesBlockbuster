<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
    <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/perfilUsuario.js"></script>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION["rol"] != "U") {
        header("Location: index.php");
    }
    include ("conexion/conexion.php");
    ?>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="activo" class="a">Perfil</a>
            </div>
        </div>
        <div class="row">
            <div class="col-6" id="divEntradasPerfil">
                <h3>Mis entradas</h3>
                <br>
                <table id="tablaEntradasUsuario">
                    <tr id="trCabecera">
                        <td>ID</td>
                        <td>PELÍCULA</td>
                        <td>SALA</td>
                        <td>BUTACA</td>
                        <td>FECHA</td>
                    </tr>
                    <?php
                    $select = "SELECT ID, IDAPIPELICULA, IDSALA, BUTACA, FECHA FROM ENTRADAS WHERE CORREO = ? ORDER BY FECHA DESC";
                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $stmt = mysqli_prepare($c, $select);
                    $stmt->bind_param("s", $_SESSION['correo']);
                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $id, $idPelicula, $sala, $butaca, $fecha);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);

                    while ($stmt->fetch()) {
                        $fecha = new DateTime($fecha);
                        echo "
                        <tr>
                            <td>" . $id . "</td>
                            <td id ='" . $idPelicula . "'></td>
                            <td>" . $sala . "</td>
                            <td>" . $butaca . "</td>
                            <td>" . $fecha->format('d/m/Y') . "</td>
                        </tr>";

                        echo "<script>mostrarTituloPelicula('" . $idPelicula . "')</script>";
                    }
                    ?>
                </table>

            </div>
            <div class="col-6" id="divCambiarCorreo">
                <h3>Gestionar credenciales</h3>
                <br>
                <form id="formCorreoUsuario" action="#" method="post">
                    <button type="submit" id="btnCorreoUsuario" name="btnCorreoUsuario">Modificar correo</button>
                    <button type="submit" id="btnClaveUsuario" name="btnClaveUsuario">Modificar contraseña</button>
                    <button type="submit" id="btnEliminarUsuario" name="btnEliminarUsuario">Eliminar usuario</button>
                    <br>
                    <br>
                    <button type="submit" id="btnSesionUsuario" name="btnSesionUsuario">Cerrar sesión</button>
                    <br>
                    <br>
                    <?php
                    if (isset($_POST["btnCorreoUsuario"])) {
                        echo '
                                <form method="post" action="#">
                                    <label for="correoOriginal">Correo original</label>
                                    <input type="text" id="correoOriginal" class="correoUsuario" name="correoOriginal" readonly value="' . $_SESSION['correo'] . '">
                                    <br>
                                    <br>
                                    <label for="correoNuevo">Nuevo correo</label>
                                    <input type="email" id="correoNuevo" class="correoUsuario" name="correoNuevo">
                                    <br>
                                    <br>
                                    <button type="submit" name="btnCambiarCorreo">Confirmar</button>
                                </form>
                        ';
                    }
                    if (isset($_POST["btnClaveUsuario"])) {
                        echo '
                                <form method="post" action="#">
                                    <label for="clave1">Contraseña</label>
                                    <input type="text" id="clave1" name="clave1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número." />
                                    <br>
                                    <br>
                                    <label for="clave2">Confirmar contraseña</label>
                                    <input type="text" id="clave2" name="clave2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número." />
                                    <br>
                                    <br>
                                    <button type="submit" name="btnCambiarClave">Confirmar</button>
                                </form>
                        ';
                    }
                    if (isset($_POST["btnEliminarUsuario"])) {
                        echo '
                                <form method="post" action="#">
                                    <label for="clave1">Contraseña</label>
                                    <input type="password" id="claveUsuario" name="claveUsuario"/>
                                    <br>
                                    <br>
                                    <button type="submit" name="btnEliminarDefinitivamente">Confirmar</button>
                                </form>
                        ';
                    }
                    if (isset($_POST["btnSesionUsuario"])) {
                        session_unset();
                        header("Location: index.php");
                    }
                    if (isset($_POST["btnEliminarDefinitivamente"])) {
                        if (empty($_POST['claveUsuario'])) return;
                        
                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                        $correoEliminar = $_SESSION['correo'];
                        $clave = $_POST['claveUsuario'];


                        // Verificar clave
                        $checkQuery = "SELECT COUNT(*) FROM USUARIOS WHERE CORREO = ? AND CLAVE = ?";
                        $stmt = $c->prepare($checkQuery);
                        $stmt->bind_param("ss", $correoEliminar, $clave);
                        $stmt->execute();
                        $stmt->bind_result($count);
                        $stmt->fetch();
                        $stmt->close();
                        if ($count === 0) {
                            echo '<br> <br></brt><h5 style="color:red; text-align:center">Contraseña incorrecta</h5>';
                            $c->close();
                            return;
                        }

                        $delete = "DELETE FROM USUARIOS WHERE CORREO = ?";
                        $stmt = $c->prepare($delete);
                        $stmt->bind_param("s", $correoEliminar);

                        if ($stmt->execute()) {
                            $stmt->close();
                            session_unset();

                            // Esperar 1 segundo antes de redirigir para asegurar que se muestra el mensaje
                            echo "<script>
                                alert('Usuario eliminado con éxito');
                                setTimeout(function() {
                                    window.location.href = 'index.php';
                                }, 1000); </script>";

                            return;

                        } else {
                            echo "<script>alert('Error al eliminar el usuario');</script>";
                        }

                    }
                    if (isset($_POST["btnCambiarCorreo"])) {
                        $nuevoCorreo = $_POST["correoNuevo"];

                        if (empty($nuevoCorreo)) {
                            return;
                        }

                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar si el correo original existe en la base de datos
                        $checkQuery = "SELECT COUNT(*) FROM USUARIOS WHERE CORREO = ?";
                        $stmt = $c->prepare($checkQuery);
                        $stmt->bind_param("s", $nuevoCorreo);
                        $stmt->execute();
                        $stmt->bind_result($count);
                        $stmt->fetch();
                        $stmt->close();

                        if ($count < 0) {
                            echo '<br> <br></brt><h5 style="color:red; text-align:center">El correo proporcionado ya está en uso por otro usuario</h5>';
                            // Cerrar la sentencia y la conexión
                    
                            $c->close();
                            return;
                        }

                        $antiguoCorreo = $_POST["correoOriginal"];
                        $tipos = "ss";

                        $update = "UPDATE USUARIOS SET CORREO = ? WHERE CORREO = ?";

                        $stmt = $c->prepare($update);
                        $stmt->bind_param($tipos, $nuevoCorreo, $antiguoCorreo);
                        if ($stmt->execute()) {
                            echo "<script>alert('Usuario modificado con éxito');</script>";
                            $_SESSION['correo'] = $nuevoCorreo;
                        }

                        // Cerrar la sentencia y la conexión
                        $stmt->close();
                        $c->close();
                    }
                    if (isset($_POST["btnCambiarClave"])) {
                        $clave1 = $_POST["clave1"];
                        $clave2 = $_POST["clave2"];

                        if (empty($clave1) || empty($clave2)) {
                            return;
                        }
                        if ($clave1 != $clave2) {
                            echo '<br> <br></brt><h5 style="color:red; text-align:center">Las claves proporcionadas no coinciden</h5>';
                            return;
                        }

                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar si el correo original existe en la base de datos
                        $checkQuery = "SELECT COUNT(*) FROM USUARIOS WHERE CORREO = ?";
                        $stmt = $c->prepare($checkQuery);
                        $stmt->bind_param("s", $nuevoCorreo);
                        $stmt->execute();
                        $stmt->bind_result($count);
                        $stmt->fetch();

                        if ($count < 0) {
                            echo '<br> <br></brt><h5 style="color:red; text-align:center">El correo proporcionado ya está en uso por otro usuario</h5>';
                            // Cerrar la sentencia y la conexión
                            $stmt->close();
                            $c->close();
                            return;
                        }

                        $antiguoCorreo = $_POST["correoOriginal"];
                        $tipos = "ss";

                        $update = "UPDATE USUARIOS SET CORREO = ? WHERE CORREO = ?";

                        $stmt = $c->prepare($update);
                        $stmt->bind_param($tipos, $nuevoCorreo, $antiguoCorreo);
                        if ($stmt->execute()) {
                            echo "<script>alert('Usuario modificado con éxito');</script>";
                        }

                        // Cerrar la sentencia y la conexión
                        $stmt->close();
                        $c->close();
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>