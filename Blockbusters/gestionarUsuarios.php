<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
    <script type="text/javascript" src="js/gestionarPeliculas.js"></script>
    <script type="text/javascript" src="js/conexion.js"></script>
</head>

<body>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="activo" class="a">Perfil</a>
            </div>
        </div>

        <h1 class="titulo">GESTIÓN DE USUARIOS</h1>
        <br>
        <div class="row" id="formBuscar">
            <form id="buscarUsuarios" class="frmUsuarios" action="#" method="post">
                <input type="text" name="correo" id="correo" placeholder="Correo electrónico" />
                <button type="submit" name="buscar" id="buscar">Consultar</button>

                <?php
                session_start();
                include ("conexion/conexion.php");

                if ($_SESSION["rol"] != "A") {
                    header("Location: index.php");
                }
                if (isset($_POST["buscar"])) {

                    $correo = $_POST["correo"];

                    if ($correo === "") {
                        return;
                    }

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    /* create a prepared statement */
                    $stmt = mysqli_prepare($c, "SELECT CLAVE, ROL FROM USUARIOS WHERE CORREO = ?");

                    if (!mysqli_stmt_bind_param($stmt, "s", $correo)) {
                        mysqli_stmt_error($stmt);
                    }


                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $clave, $rol);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);

                    if (!$stmt->fetch()) {
                        $correo = "";
                        echo '<br> <br></brt><h5 style="color:red; text-align:center">El correo proporcionado no existe</h5>';
                    }
                    /* close statement */
                    mysqli_stmt_close($stmt);
                    $c->close();
                }
                ?>
            </form>
        </div>
        <br>
        <h3>Si no quiere modificar algún campo, déjelo vacío.</h3>
        <div class="row">
            <form id="modificarUsario" class="frmUsuarios" action="#" method="post">
                <input type="text" name="correoOriginal" id="correoOriginal" placeholder="Correo electrónico" readonly
                    value="<?php if (isset($correo))
                        echo htmlspecialchars($correo); ?>" />
                <input type="email" name="correoNuevo" id="correoNuevo" placeholder="Nuevo correo electrónico" />
                <input type="text" name="contra" id="contra" placeholder="Nueva contraseña"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número." />
                <select id="rol" name="rol">
                    <option value="">---</option>
                    <option value="A">Administrador</option>
                    <option value="U">Usuario</option>
                </select><br><br>
                <button type="submit" name="modificar" id="modificar">Modificar</button>
                <button type="submit" name="eliminar" id="eliminar">Eliminar</button>
                <br>
                <br>
            </form>
        </div>

        <?php
        if (isset($_POST["modificar"])) {
            $antiguoCorreo = $_POST["correoOriginal"];

            if (empty($antiguoCorreo)) {
                return;
            }

            $nuevoCorreo = $_POST["correoNuevo"];
            $nuevaContra = $_POST["contra"];
            $nuevoRol = $_POST["rol"];

            if (empty($nuevoCorreo) && empty($nuevaContra) && empty($nuevoRol)) {
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


            $update = "UPDATE USUARIOS SET ";
            $parametros = [];
            $tipos = "";

            if (!empty($nuevoCorreo)) {
                $update .= "CORREO = ?, ";
                $tipos .= "s";
                $parametros[] = &$nuevoCorreo;
            }
            if (!empty($nuevaContra)) {
                $update .= "CLAVE = ?, ";
                $tipos .= "s";
                $parametros[] = &$nuevaContra;
            }
            if (!empty($nuevoRol)) {
                $update .= "ROL = ? ";
                $tipos .= "s";
                $parametros[] = &$nuevoRol;
            }

            // Eliminar la coma final si existe
            $update = rtrim($update, ', ');

            $update .= " WHERE CORREO = ? ";

            $tipos .= "s";
            $parametros[] = &$antiguoCorreo;

            $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
            $stmt = $c->prepare($update);
            $stmt->bind_param($tipos, ...$parametros);
            if ($stmt->execute()) {
                echo "<script>alert('Usuario modificado con éxito');</script>";
            }

            // Cerrar la sentencia y la conexión
            $stmt->close();
            $c->close();
        }
        if (isset($_POST['eliminar'])) {
            $antiguoCorreo = $_POST["correoOriginal"];

            if (empty($antiguoCorreo)) {
                return;
            }
            $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

            $delete = "DELETE FROM USUARIOS WHERE CORREO = ?";
            $stmt = $c->prepare($delete);
            $stmt->bind_param("s", $antiguoCorreo);

            if ($stmt->execute()) {
                $stmt->close();
                session_unset();

                // Esperar 1 segundo antes de redirigir para asegurar que se muestra el mensaje
                echo "<script>alert('Usuario eliminado con éxito'); </script>";

                return;
            }
        }
        ?>
</body>

</html>