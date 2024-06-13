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
    <script type="text/javascript" src="js/gestionarEntradas.js"></script>
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
        <h1 class="titulo">GESTIÓN DE ENTRADAS</h1>
        <br>
        <div class="row">
            <div class="col-md-12" id="peliculasActivas" class="divGestionarSalas" class="peliculaImpar">

                <form id="buscarUsuarios" class="frmUsuarios" action="#" method="post">
                    <input type="text" name="entrada" id="entrada" placeholder="ID Entrada" />
                    <button type="submit" name="buscar" id="buscar">Consultar</button>
                </form>
                <br>
                <table id='tablaSalas'>
                    <tr>
                        <td>
                            <h5>ID</h5>
                        </td>
                        <td>
                            <h5>CORREO</h5>
                        </td>
                        <td>
                            <h5>PELÍCULA</h5>
                        </td>
                        <td>
                            <h5>SALA</h5>
                        </td>
                        <td>
                            <h5>BUTACA</h5>
                        </td>
                        <td>
                            <h5>FECHA</h5>
                        </td>
                        <td></td>
                    </tr>

                    <?php
                    include ("conexion/conexion.php");

                    if ($_SESSION["rol"] != "A") {
                        header("Location: index.php");
                    }
                    if (isset($_POST["buscar"])) {

                        $entrada = $_POST["entrada"];

                        if (empty($correo) && empty($entrada)) {
                            return;
                        }

                        $select = "SELECT ID, IDAPIPELICULA, IDSALA, CORREO, BUTACA, FECHA FROM ENTRADAS WHERE ID = ? AND VALIDADA = 0";

                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                        $stmt = mysqli_prepare($c, $select);
                        $stmt->bind_param("s", $entrada);
                        /* execute query */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $id, $idPelicula, $sala, $correo, $butaca, $fecha);

                        /* fetch value */
                        mysqli_stmt_store_result($stmt);

                        while ($stmt->fetch()) {

                            echo "<tr>
                        <form id='frmEntradas' action ='#' method = 'post'>
                        <td><input type='text' name='id' value='" . $id . "' readonly></td>
                        <td><input type='text' name='correo' value='" . $correo . "' readonly></td>
                        <td><input type='text' id='" . $idPelicula . "' name='tituloPelicula' readonly></td>
                        <td><input type='text' name='sala' value='" . $sala . "' readonly></td>
                        <td><input type='text' name='butaca' value='" . $butaca . "' readonly></td>
                        <td><input type='text' name='fecha' value='" . $fecha . "' readonly></td>
                        <td><button type='submit' id='validarEntrada' name='validarEntrada' value='" . $id . "'>Validar</button></td>
                        </form>
                        </tr>";

                            echo "<script>mostrarTituloPelicula('" . $idPelicula . "','" . $sala . "')</script>";
                            $sala++;
                        }
                        "</table>";
                    }
                    if (isset($_POST['validarEntrada'])) {
                        $idEntrada = $_POST['validarEntrada'];
                        $update = "UPDATE ENTRADAS SET VALIDADA = 1 WHERE ID = ? ";

                        $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                        $stmt = $c->prepare($update);
                        $stmt->bind_param("s", $idEntrada);
                        if ($stmt->execute()) {
                            echo "<script>
                                alert('Entrada validada con éxito');
                                window.location.href = 'gestionarEntradas.php';
                            </script>";
                        }

                        // Cerrar la sentencia y la conexión
                        $stmt->close();
                        $c->close();
                        return;

                    }
                    ?>
            </div>
        </div>
</body>

</html>