<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
    <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/entradas.js"></script>
</head>

<body>
    <?php
    session_start();
    if (empty($_SESSION["rol"]) || !isset($_GET['pelicula']) || !isset($_GET['sala']) || !isset($_GET['aforo'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="activo" class="a">Inicio</a>
            </div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="a">Perfil</a></div>
        </div>
        <div class="row">
            <div class="col-m-12" id="divLeyenda">
                <table id="tablaLeyenda">
                    <tr>
                        <td id="leyendaNoDisponible"></td>
                        <td>
                            <p>No disponible</p>
                        </td>
                    </tr>
                    <tr>
                        <td id="leyendaOcupada"></td>
                        <td>
                            <p>Ocupada</p>
                        </td>
                    </tr>
                    <tr>
                        <td id="leyendaLibre"></td>
                        <td>
                            <p>Libre</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-m-12" id="divInfo">
                <table id="tablaInfoPelicula">
                    <tr>
                        <td id="tdImagenInfoPelicula"></td>
                        <td id="tdTituloInfoPelicula"></td>
                    </tr>
                    <tr>
                        <form action="#" method="post">
                            <td>
                                <input type="date" id="fechaEntrada" name="fechaEntrada" required
                                    value="<?php echo isset($_POST['fechaEntrada']) ? $_POST['fechaEntrada'] : ''; ?>">
                            </td>
                            <td>
                                <input type="submit" id="enviarFecha" name="enviarFecha" required>
                            </td>
                        </form>

                        <?php
                        $idPelicula = $_GET['pelicula'];
                        echo "<script>cargarInfoPelicula('" . $idPelicula . "')</script>";
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div id="divEntradas" class="col-m-3">
                <h3>Elige una fecha y luego haz click encima de la butaca que deseas reservar</h3>
                <table id="tablaEntradas">
                    <tr>
                        <td colspan="10" id="tdPantalla">
                            <p>PANTALLA</p>
                        </td>
                    </tr>
                    <tr id="fila1" class="fila">
                        <td id="1-1" class="butaca"></td>
                        <td id="1-2" class="butaca"></td>
                        <td id="1-3" class="butaca"></td>
                        <td id="1-4" class="butaca"></td>
                        <td id="1-5" class="butaca"></td>
                        <td id="1-6" class="butaca"></td>
                        <td id="1-7" class="butaca"></td>
                        <td id="1-8" class="butaca"></td>
                        <td id="1-9" class="butaca"></td>
                        <td id="1-10" class="butaca"></td>
                    </tr>
                    <tr id="fila2" class="fila">
                        <td id="2-1" class="butaca"></td>
                        <td id="2-2" class="butaca"></td>
                        <td id="2-3" class="butaca"></td>
                        <td id="2-4" class="butaca"></td>
                        <td id="2-5" class="butaca"></td>
                        <td id="2-6" class="butaca"></td>
                        <td id="2-7" class="butaca"></td>
                        <td id="2-8" class="butaca"></td>
                        <td id="2-9" class="butaca"></td>
                        <td id="2-10" class="butaca"></td>
                    </tr>
                    <tr id="fila3" class="fila">
                        <td id="3-1" class="butaca"></td>
                        <td id="3-2" class="butaca"></td>
                        <td id="3-3" class="butaca"></td>
                        <td id="3-4" class="butaca"></td>
                        <td id="3-5" class="butaca"></td>
                        <td id="3-6" class="butaca"></td>
                        <td id="3-7" class="butaca"></td>
                        <td id="3-8" class="butaca"></td>
                        <td id="3-9" class="butaca"></td>
                        <td id="3-10" class="butaca"></td>
                    </tr>
                    <tr id="fila4" class="fila">
                        <td id="4-1" class="butaca"></td>
                        <td id="4-2" class="butaca"></td>
                        <td id="4-3" class="butaca"></td>
                        <td id="4-4" class="butaca"></td>
                        <td id="4-5" class="butaca"></td>
                        <td id="4-6" class="butaca"></td>
                        <td id="4-7" class="butaca"></td>
                        <td id="4-8" class="butaca"></td>
                        <td id="4-9" class="butaca"></td>
                        <td id="4-10" class="butaca"></td>
                    </tr>
                    <tr id="fila5" class="fila">
                        <td id="5-1" class="butaca"></td>
                        <td id="5-2" class="butaca"></td>
                        <td id="5-3" class="butaca"></td>
                        <td id="5-4" class="butaca"></td>
                        <td id="5-5" class="butaca"></td>
                        <td id="5-6" class="butaca"></td>
                        <td id="5-7" class="butaca"></td>
                        <td id="5-8" class="butaca"></td>
                        <td id="5-9" class="butaca"></td>
                        <td id="5-10" class="butaca"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
<?php
if (isset($_POST['enviarFecha'])) {
    include ("conexion/conexion.php");
    $fecha = $_POST['fechaEntrada'];
    $idPelicula = $_GET['pelicula'];
    $idSala = intval($_GET['sala']);
    $aforo = intval($_GET['aforo']);
    $selectButacas = "SELECT BUTACA FROM ENTRADAS WHERE IDAPIPELICULA = ? AND IDSALA = ? AND FECHA = ?";

    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

    /* create a prepared statement */
    $stmt = mysqli_prepare($c, $selectButacas);

    mysqli_stmt_bind_param($stmt, "sis", $idPelicula, $idSala, $fecha);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $butaca);

    /* fetch values */
    $butacas = array(); // Array para almacenar las butacas
    while (mysqli_stmt_fetch($stmt)) {
        $butacas[] = $butaca; // Agrega cada butaca al array
    }

    $datos_json = json_encode($butacas);

    /* close statement */
    mysqli_stmt_close($stmt);
    $c->close();

    echo "<script>cargarButacas(" . $datos_json . "," . $aforo . ",'" . $idPelicula . "'," . $idSala . ",'" . $fecha . "')</script>";
}
?>

</html>