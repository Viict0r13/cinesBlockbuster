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
    <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/gestionarSalas.js"></script>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION["rol"] != "A") {
        header("Location: index.php");
    }
    ?>


    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="activo" class="a">Perfil</a>
            </div>
        </div>
        <h1 class="titulo">GESTIÓN DE SALAS</h1>
        <h3>Si no quiere modificar algún campo, déjelo vacío.</h3>
        <br>
        <div class="row">
            <div class="col-md-12" id="peliculasActivas" class="divGestionarSalas" class="peliculaImpar">
                <table id='tablaSalas'>
                    <tr>
                        <td>
                            <h5>SALA</h5>
                        </td>
                        <td>
                            <h5>AFORO ACTUAL</h5>
                        </td>
                        <td>
                            <h5>NUEVO AFORO</h5>
                        </td>
                        <td>
                            <h5>PELÍCULA ACTUAL</h5>
                        </td>
                        <td>
                            <h5>ELIMINAR PELÍCULA</h5>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                    $select = "SELECT AFORO, IDPELICULA FROM SALAS";
                    $aforo = 0;
                    $idPelicula = "";

                    include ("conexion/conexion.php");

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $stmt = mysqli_prepare($c, $select);

                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $aforo, $idPelicula);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);

                    $sala = 1;
                    while ($stmt->fetch()) {

                        echo "<tr>
                        <form id='frmSalas' action ='#' method = 'post'>
                        <td><input type='text' name='sala' value='" . $sala . "' readonly></td>
                        <td><input type='text' name='aforo' value='" . $aforo . "' readonly></td>
                        <td><input type='number' name='nuevoAforo'></td>
                        <td><input type='text' id='" . $sala . "' name='tituloPelicula' readonly></td>
                        <td><input type='checkbox' name='eliminarPelicula'></td>
                        <td><button type='submit' id='modificarSala' name='modificarSala' value='" . $idPelicula . "'>Modificar</button></td>
                        </form>
                    </tr>";

                        echo "<script>mostrarTituloPelicula('" . $idPelicula . "','" . $sala . "')</script>";
                        $sala++;
                    }
                    "</table>";

                    if (isset($_POST['modificarSala'])) {
                        $nuevoAforo = $_POST['nuevoAforo'];
                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        if (!empty($nuevoAforo) || isset($_POST['eliminarPelicula'])) {
                            $sala = $_POST['sala'];
                            $update = "UPDATE SALAS SET ";

                            $parametros = [];
                            $tipos = "";

                            if (!empty($nuevoAforo)) {
                                if ($nuevoAforo == 0 || $nuevoAforo % 10 != 0 || $nuevoAforo > 50) {
                                    echo "<script>alert('El aforo no puede ser distinto a 10, 20, 30, 40 o 50');</script>";
                                    return;
                                }
                                $update .= "AFORO = ?, ";
                                $tipos .= "i";
                                $numNuevoAforo = intval($nuevoAforo);
                                $parametros[] = &$numNuevoAforo;
                            }
                            if (isset($_POST['eliminarPelicula'])) {
                                $eliminarPelicula = $_POST['eliminarPelicula'];
                                $update .= "IDPELICULA = ?, ";
                                $tipos .= "s";
                                $sinPelicula = null;
                                $parametros[] = &$sinPelicula;

                                $desactivarPelicula = "UPDATE PELICULAS SET ESTADO = 'I' WHERE IDAPI = ?";

                                $stmt = $c->prepare($desactivarPelicula);
                                $stmt->bind_param('s', $idPelicula);
                                $stmt->execute();
                            }

                            // Eliminar la coma final si existe
                            $update = rtrim($update, ', ');

                            $update .= " WHERE ID = ? ";

                            $tipos .= "i";
                            $numSala = intval($sala);
                            $parametros[] = &$numSala;

                            $stmt = $c->prepare($update);
                            $stmt->bind_param($tipos, ...$parametros);
                            if ($stmt->execute()) {
                                echo "<script>alert('Sala modificada con éxito');</script>";
                            }

                            // Cerrar la sentencia y la conexión
                            $stmt->close();
                            $c->close();
                            header("Location: gestionarSalas.php");
                            return;
                        }

                    }
                    ?>
            </div>
        </div>
</body>

</html>