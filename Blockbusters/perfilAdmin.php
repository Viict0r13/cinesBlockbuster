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
    <script type="text/javascript" src="js/perfilAdmin.js"></script>
</head>

<body>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="#" class="activo" class="a">Perfil</a></div>
        </div>
        <div class="row" id="divAdmin">
            <h3>Administración</h3>
            <br>
            <div id="botones">
                <form action="#" method="post">
                    <button id="btnPeliculas" name="btnPeliculas" type="submit">Gestionar películas</button>
                    <button id="btnUsuarios" name="btnUsuarios" type="submit">Gestionar usuarios</button>
                    <button id="btnEntradas" name="btnEntradas" type="submit">Gestionar entradas</button>
                    <button id="btnSalas" name="btnSalas" type="submit">Gestionar salas</button>
                    <button id="btnSalir" name="btnSalir" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    session_start();
    include ("conexion/conexion.php");
    if ($_SESSION["rol"] != "A") {
        header("Location: index.php");
    }
    if (isset($_POST["btnSalir"])) {
        session_unset();
        header("Location: index.php");
    }
    if (isset($_POST["btnPeliculas"])) {
        header("Location: gestionarPeliculas.php");
    }
    if (isset($_POST["btnUsuarios"])) {
        header("Location: gestionarUsuarios.php");
    }
    if (isset($_POST["btnSalas"])) {
        header("Location: gestionarSalas.php");
    }
    if (isset($_POST["btnEntradas"])) {
        header("Location: gestionarEntradas.php");
    }
    ?>
</body>
</html>