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
    <script type="text/javascript" src="js/perfil.js"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["rol"]) && !empty($_SESSION["rol"]) && $_SESSION["rol"] === "A") {
        header("Location: perfilAdmin.php");
        exit();
    } elseif (isset($_SESSION["rol"]) && !empty($_SESSION["rol"]) && $_SESSION["rol"] === "U") {
        header("Location: perfilUsuario.php");
        exit();
    }
    ?>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="#" class="activo" class="a">Perfil</a></div>
        </div>
        <div class="row" id="formulariosInicio">
            <div class="col-md-6" id="divFormularioInicio">
                <h3>Inicio de sesión</h3>
                <br>
                <form id="formInicio" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <title class="tituloForm">Inicio de sesión</title>
                    <input type="email" class="correo" placeholder="Correo electrónico" id="correoInicio"
                        name="correoInicio" required>
                    <br>
                    <br>
                    <input type="password" class="passwd" placeholder="Contraseña" id="passwdInicio" name="passwdInicio"
                        required>
                    <br>
                    <br>
                    <br>
                    <br>
                    <input type="submit" text="Enviar" class="enviar" id="btnInicio" name="btnInicio">
                    <input type="text" name="ocultoInicio" class="oculto">
                    <?php
                    include ("conexion/conexion.php");
                    if (isset($_POST["btnInicio"])) {
                        $oculto = $_POST["ocultoInicio"];
                        $correo = $_POST["correoInicio"];
                        $passwd = trim($_POST["passwdInicio"]);
                        $rol = "";
                        if (!empty($oculto)) {
                            header("Location: index.php");
                        } else {
                            $conn = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            $sql = "SELECT CLAVE, ROL FROM USUARIOS WHERE CORREO = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $correo);
                            $stmt->execute();
                            $stmt->bind_result($hash, $rol);
                            $stmt->fetch();

                            if ($rol != "" && password_verify($passwd, $hash)) {
                                $_SESSION["correo"] = $correo;
                                $_SESSION["rol"] = $rol;
                                if ($rol === "A") {
                                    header("Location: perfilAdmin.php");
                                } else {
                                    header("Location: perfilUsuario.php");
                                }
                            } else {
                                echo "<script>alert('Correo y/o contraseña incorrecto/s')</script>";
                            }
                            $stmt->close();
                            $conn->close();
                        }
                    }
                    ?>
                </form>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-6" id="divFormularioRegistro">
                <h3>Regístrame</h3>
                <br>
                <form id="formRegistro" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <title class="tituloForm">Regístrame</title>
                    <input type="email" class="correo" placeholder="Correo electrónico" id="correoRegistro"
                        name="correoRegistro" required>
                    <br>
                    <br>
                    <input type="text" class="passwd" placeholder="Contraseña" id="passwdRegistro" name="passwdRegistro"
                        name="passwdRegistro2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número."
                        required />
                    <br>
                    <br>
                    <input type="text" class="passwd" placeholder="Confirmar contraseña" id="passwdRegistro2"
                        name="passwdRegistro2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número."
                        required />




                    <br>
                    <br>
                    <input type="submit" text="Enviar" class="enviar" id="btnRegistro" name="btnRegistro">
                    <input type="text" name="ocultoRegistro" class="oculto">
                    <?php
                    include ("conexion/conexion.php");
                    if (isset($_POST["btnRegistro"])) {
                        $oculto = $_POST["ocultoRegistro"];
                        $correo = $_POST["correoRegistro"];
                        $passwd = trim($_POST["passwdRegistro"]);
                        $passwd2 = trim($_POST["passwdRegistro2"]);

                        if (!empty($oculto)) {
                            header("Location: index.php");
                        }

                        if ($passwd !== $passwd2) {
                            echo '<br> <br></brt><h5 style="color:red; text-align:center">Las contraseñas no coinciden</h5>';
                            return;
                        }

                        $hash = password_hash($passwd, PASSWORD_BCRYPT);


                        $insert = "INSERT INTO USUARIOS (CORREO, CLAVE, ROL) VALUES (?, ?, ?)";
                        $rol = 'U';

                        // Crear la conexión
                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar la conexión
                        if ($c->connect_error) {
                            die("Error de conexión: " . $c->connect_error);
                        }

                        // Preparar la declaración
                        $stmt = $c->prepare($insert);
                        if ($stmt === false) {
                            die("Error al preparar la declaración: " . $c->error);
                        }

                        // Vincular parámetros
                        $tipos = "sss";  // Tres parámetros de tipo string
                        $stmt->bind_param($tipos, $correo, $hash, $rol);

                        // Ejecutar la declaración
                        if ($stmt->execute()) {
                            echo "<script>alert('Usuario insertado con éxito');</script>";
                            session_unset();
                            session_start();
                            $_SESSION["correo"] = $correo;
                            $_SESSION["rol"] = $rol;
                            header("Location: perfilUsuario.php");
                        } else {
                            echo "Error al insertar el usuario: " . $stmt->error;
                        }

                        // Cerrar la declaración y la conexión
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