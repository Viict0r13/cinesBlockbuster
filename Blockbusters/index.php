<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
    <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
</head>

<body>
    <?php
    include ("conexion/conexion.php");

    /*MOSTRAR PELICULAS ACTIVAS*/
    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
    /* create a prepared statement */
    $stmt = mysqli_prepare($c, "SELECT IDAPI FROM PELICULAS WHERE ESTADO = 'A'");

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $idPelicula);

    /* fetch value */
    mysqli_stmt_store_result($stmt);

    $ids = array();
    $posicion = 0;

    while ($stmt->fetch()) {

        $ids[$posicion] = $idPelicula;
        $posicion++;
    }

    /* close statement */
    mysqli_stmt_close($stmt);
    $datos_json = json_encode($ids);
    echo "<script src='js/index.js'></script>";
    echo "<script>mostrarActivas(" . $datos_json . ");</script>";

    ?>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="#" class="activo" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="a">Perfil</a></div>
        </div>
        <div class="row">
            <div class="col-m-3">

            </div>
            <div class="col-m-3" id="peliculasIndex">
                <div id="activas" class="peliculas">
                    <h3>EN CARTELERA</h3>
                </div>
                <br>
                <br>
                <br>
                <?php
                if (isset($_POST['btnEntrada'])) {
                    session_start();
                    if (empty($_SESSION["rol"])) {
                        header("Location: perfil.php");
                        exit();
                    } else {
                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        /* create a prepared statement */
                        $selectSala = "SELECT ID, AFORO FROM SALAS WHERE IDPELICULA = ?";
                        $stmt = mysqli_prepare($c, $selectSala);

                        mysqli_stmt_bind_param($stmt, "s", $_POST['btnEntrada']);

                        /* execute query */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $idSala, $aforo);

                        /* fetch values */
                        mysqli_stmt_fetch($stmt);

                        /* close statement */
                        mysqli_stmt_close($stmt);
                        $c->close();


                        header("Location: entradas.php?pelicula=" . $_POST['btnEntrada'] . "&sala=" . $idSala . "&aforo=" . $aforo);
                        exit();
                    }
                }
                ?>
            </div>
            <div clas="col-m-3">

            </div>
        </div>
    </div>
</body>
<br>
<footer>
    <p>Este sitio web utiliza cookies propias exclusivamente para el funcionamiento correcto de este, ningún tipo de información ajena a la página será almacenda o solicitada. Copyright CinesBlockBuster© 2024 .</p>
</footer>

</html>