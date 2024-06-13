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
    <script type="text/javascript" src="js/gestionarPeliculas.js"></script>
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
        <h1 class="titulo">GESTIÓN DE PELICULAS</h1>
        <br>
        <div class="row" id="peliculasBD">
            <div class="col-md-12" id="peliculasActivas" class="divGestionarPeliculas" class="peliculaImpar">
                <h3>ACTIVAS</h3>
                <?php
                include ("conexion/conexion.php");

                /*OCULTAR PELICULAS EN BD*/
                $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                /* create a prepared statement */
                $stmt = mysqli_prepare($c, "SELECT IDPELICULA, ID FROM SALAS WHERE IDPELICULA IS NOT NULL AND IDPELICULA <> '' ORDER BY ID");

                /* execute query */
                mysqli_stmt_execute($stmt);

                /* bind result variables */
                mysqli_stmt_bind_result($stmt, $idPelicula, $sala);

                /* fetch value */
                mysqli_stmt_store_result($stmt);

                $ids = array();
                $salas = array();
                $posicion = 0;

                while ($stmt->fetch()) {

                    $ids[$posicion] = $idPelicula;
                    $salas[$posicion] = $sala;
                    $posicion++;
                }

                /* close statement */
                mysqli_stmt_close($stmt);
                $datos_json = json_encode($ids);
                $datos_json2 = json_encode($salas);
                echo "<script>mostrarActivas(" . $datos_json . "," . $datos_json2 . ");</script>";

                if (isset($_POST["btnQuitar1"])) {
                    $quitarActiva = "UPDATE PELICULAS SET ESTADO = 'I' WHERE IDAPI = ?";

                    $idApi = $_POST["btnQuitar1"];

                    $tipos = "s";

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $stmt = $c->prepare($quitarActiva);
                    $stmt->bind_param($tipos, $idApi);
                    if ($stmt->execute()) {


                        $quitarActivaSala = "UPDATE SALAS SET IDPELICULA = NULL WHERE IDPELICULA = ?";

                        $stmt2 = $c->prepare($quitarActivaSala);
                        $stmt2->bind_param($tipos, $idApi);
                        $stmt2->execute();
                        echo "<script>alert('Película desactivada');</script>";
                        header("Location: gestionarPeliculas.php");
                        return;
                    }
                }
                if (isset($_POST["btnQuitar2"])) {
                    $quitarActiva = "UPDATE PELICULAS SET ESTADO = 'I' WHERE IDAPI = ?";

                    $idApi = $_POST["btnQuitar2"];

                    $tipos = "s";

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $stmt = $c->prepare($quitarActiva);
                    $stmt->bind_param($tipos, $idApi);
                    if ($stmt->execute()) {


                        $quitarActivaSala = "UPDATE SALAS SET IDPELICULA = NULL WHERE IDPELICULA = ?";

                        $stmt2 = $c->prepare($quitarActivaSala);
                        $stmt2->bind_param($tipos, $idApi);
                        $stmt2->execute();
                        echo "<script>alert('Película desactivada');</script>";
                        header("Location: gestionarPeliculas.php");
                        return;
                    }
                }
                if (isset($_POST["btnQuitar3"])) {
                    $quitarActiva = "UPDATE PELICULAS SET ESTADO = 'I' WHERE IDAPI = ?";

                    $idApi = $_POST["btnQuitar3"];

                    $tipos = "s";

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $stmt = $c->prepare($quitarActiva);
                    $stmt->bind_param($tipos, $idApi);
                    if ($stmt->execute()) {


                        $quitarActivaSala = "UPDATE SALAS SET IDPELICULA = NULL WHERE IDPELICULA = ?";

                        $stmt2 = $c->prepare($quitarActivaSala);
                        $stmt2->bind_param($tipos, $idApi);
                        $stmt2->execute();
                        echo "<script>alert('Película desactivada');</script>";
                        header("Location: gestionarPeliculas.php");
                        return;
                    }
                }
                ?>
                <br>
                <br>
            </div>
            <div class="col-md-12" id="peliculasInactivas">
                <h3>OTRAS</h3>
                <br>
                <?php
                include ("conexion/conexion.php");

                /*OCULTAR PELICULAS EN BD*/
                $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                /* create a prepared statement */
                $stmt = mysqli_prepare($c, "SELECT IDAPI FROM PELICULAS WHERE ESTADO != 'A'");

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
                echo "<script>mostrarInactivas(" . $datos_json . ");</script>";

                if (isset($_POST["btnReactivar1"])) {
                    $idApi = $_POST["btnReactivar1"];

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $idPeliBD = "";

                    $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 1");

                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $idPeliBD);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_fetch($stmt);

                    if (!empty($idPeliBD)) {
                        echo "<script>alert('La sala 1 ya tiene una película en proyección')</script>";
                        exit;
                    } else {
                        $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                        $tipos = "s";

                        $stmt = $c->prepare($reactivar);
                        $stmt->bind_param($tipos, $idApi);
                        if ($stmt->execute()) {
                            $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 1";
                            $tipos = "s";
                            $stmt = $c->prepare($updateSala);
                            $stmt->bind_param($tipos, $idApi);
                            $stmt->execute();
                            echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                            header("Location: gestionarPeliculas.php");
                            $stmt->close();
                            $c->close();
                            return;
                        }

                        $stmt->close();

                    }

                    $c->close();

                }
                if (isset($_POST["btnReactivar2"])) {
                    $idApi = $_POST["btnReactivar2"];

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $idPeliBD = "";

                    $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 2");

                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $idPeliBD);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_fetch($stmt);

                    if (!empty($idPeliBD)) {
                        echo "<script>alert('La sala 2 ya tiene una película en proyección')</script>";
                        exit;
                    } else {
                        $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                        $tipos = "s";

                        $stmt = $c->prepare($reactivar);
                        $stmt->bind_param($tipos, $idApi);
                        if ($stmt->execute()) {
                            $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 2";
                            $tipos = "s";
                            $stmt = $c->prepare($updateSala);
                            $stmt->bind_param($tipos, $idApi);
                            $stmt->execute();
                            echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                            header("Location: gestionarPeliculas.php");
                            $stmt->close();
                            $c->close();
                            return;
                        }

                        $stmt->close();

                    }

                    $c->close();

                }
                if (isset($_POST["btnReactivar3"])) {
                    $idApi = $_POST["btnReactivar3"];

                    $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                    $idPeliBD = "";

                    $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 3");

                    /* execute query */
                    mysqli_stmt_execute($stmt);

                    /* bind result variables */
                    mysqli_stmt_bind_result($stmt, $idPeliBD);

                    /* fetch value */
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_fetch($stmt);

                    if (!empty($idPeliBD)) {
                        echo "<script>alert('La sala 1 ya tiene una película en proyección')</script>";
                        exit;
                    } else {
                        $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                        $tipos = "s";

                        $stmt = $c->prepare($reactivar);
                        $stmt->bind_param($tipos, $idApi);
                        if ($stmt->execute()) {
                            $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 3";
                            $tipos = "s";
                            $stmt = $c->prepare($updateSala);
                            $stmt->bind_param($tipos, $idApi);
                            $stmt->execute();
                            echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                            header("Location: gestionarPeliculas.php");
                            $stmt->close();
                            $c->close();
                            return;
                        }

                        $stmt->close();

                    }

                    $c->close();

                }
                ?>
            </div>
        </div>
        <div class="row" id="peliculasApi">
            <div class="row">
                <div class="col-12" id="divFiltros">
                    <h3>API</h3>
                    <form id="formFiltros">
                        <title class="tituloForm">Filtrar películas</title>
                        <input type="text" id="titulo" placeholder="Título">
                        <input type="number" id="year" placeholder="Año">
                        <br>
                        <br>
                        <button type="button" id="btnAplicarFiltros" name="btnAplicarFiltros">Aplicar Filtros</button>
                        <button type="button" id="btnLimpiar" name="btnLimpiar">Limpiar Filtros</button>

                    </form>
                </div>
                <div class="col-12" id="divPeliculasFiltradas">
                    <?php
                    if (isset($_POST["activar1"])) {
                        $idApi = $_POST["activar1"];
                        $conn = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar la conexión
                        if ($conn->connect_error) {
                            die("Error de conexión: " . $conn->connect_error);
                        }

                        $idPeliBD = "";

                        $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 1");

                        /* execute query */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $idPeliBD);

                        /* fetch value */
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_fetch($stmt);

                        if (!empty($idPeliBD)) {
                            echo "<script>alert('La sala 1 ya tiene una película en proyección')</script>";
                            exit;
                        }

                        $sql_select = "SELECT IDAPI FROM PELICULAS WHERE IDAPI = ?";

                        if ($stmt_select = $conn->prepare($sql_select)) {
                            // Vincular el parámetro y comprobar si hay errores
                            $stmt_select->bind_param("s", $idApi);
                            $stmt_select->execute();
                            $stmt_select->store_result();

                            if ($stmt_select->num_rows > 0) {
                                // Si la película ya existe, realizar un UPDATE
                                $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                                $tipos = "s";

                                $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                                $stmt = $c->prepare($reactivar);
                                $stmt->bind_param($tipos, $idApi);
                                if ($stmt->execute()) {
                                    $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 1";
                                    $tipos = "s";
                                    $stmt = $c->prepare($updateSala);
                                    $stmt->bind_param($tipos, $idApi);
                                    $stmt->execute();
                                    echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                                    header("Location: gestionarPeliculas.php");
                                    return;
                                }
                            } else {

                                // Preparar la consulta SQL con marcadores de posición (?)
                                $sql = "INSERT INTO PELICULAS (IDAPI, ESTADO) VALUES (?, ?)";

                                // Preparar la declaración SQL y comprobar si hay errores
                                if ($stmt = $conn->prepare($sql)) {
                                    // Vincular parámetros y comprobar si hay errores
                                    $estado = "A";
                                    $stmt->bind_param("ss", $idApi, $estado); // 
                                    if ($stmt->execute()) {
                                        $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 1";
                                        $tipos = "s";
                                        $stmt = $c->prepare($updateSala);
                                        $stmt->bind_param($tipos, $idApi);
                                        $stmt->execute();
                                        echo "<script>alert('Película añadida correctamente, la página será recargada')</script>";
                                        // Cerrar la conexión
                                        $conn->close();
                                        header("Location: gestionarPeliculas.php");
                                    } else {
                                        $conn->close();
                                        echo "<script>alert('Algo salió mal')</script>";
                                    }
                                }

                            }
                        }
                    }
                    if (isset($_POST["activar2"])) {
                        $idApi = $_POST["activar2"];
                        $conn = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar la conexión
                        if ($conn->connect_error) {
                            die("Error de conexión: " . $conn->connect_error);
                        }

                        $idPeliBD = "";

                        $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 2");

                        /* execute query */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $idPeliBD);

                        /* fetch value */
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_fetch($stmt);

                        if (!empty($idPeliBD)) {
                            echo "<script>alert('La sala 2 ya tiene una película en proyección')</script>";
                            exit;
                        }

                        $sql_select = "SELECT IDAPI FROM PELICULAS WHERE IDAPI = ?";

                        if ($stmt_select = $conn->prepare($sql_select)) {
                            // Vincular el parámetro y comprobar si hay errores
                            $stmt_select->bind_param("s", $idApi);
                            $stmt_select->execute();
                            $stmt_select->store_result();

                            if ($stmt_select->num_rows > 0) {
                                // Si la película ya existe, realizar un UPDATE
                                $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                                $tipos = "s";

                                $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                                $stmt = $c->prepare($reactivar);
                                $stmt->bind_param($tipos, $idApi);
                                if ($stmt->execute()) {
                                    $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 2";
                                    $tipos = "s";
                                    $stmt = $c->prepare($updateSala);
                                    $stmt->bind_param($tipos, $idApi);
                                    $stmt->execute();
                                    echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                                    header("Location: gestionarPeliculas.php");
                                    return;
                                }
                            } else {

                                // Preparar la consulta SQL con marcadores de posición (?)
                                $sql = "INSERT INTO PELICULAS (IDAPI, ESTADO) VALUES (?, ?)";

                                // Preparar la declaración SQL y comprobar si hay errores
                                if ($stmt = $conn->prepare($sql)) {
                                    // Vincular parámetros y comprobar si hay errores
                                    $estado = "A";
                                    $stmt->bind_param("ss", $idApi, $estado); // 
                                    if ($stmt->execute()) {
                                        $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 2";
                                        $tipos = "s";
                                        $stmt = $c->prepare($updateSala);
                                        $stmt->bind_param($tipos, $idApi);
                                        $stmt->execute();
                                        echo "<script>alert('Película añadida correctamente, la página será recargada')</script>";
                                        // Cerrar la conexión
                                        $conn->close();
                                        header("Location: gestionarPeliculas.php");
                                    } else {
                                        $conn->close();
                                        echo "<script>alert('Algo salió mal')</script>";
                                    }
                                }

                            }
                        }
                    }
                    if (isset($_POST["activar3"])) {
                        $idApi = $_POST["activar3"];
                        $conn = new mysqli($servidor, $usuario, $contraseña, $basededatos);

                        // Verificar la conexión
                        if ($conn->connect_error) {
                            die("Error de conexión: " . $conn->connect_error);
                        }

                        $idPeliBD = "";

                        $stmt = mysqli_prepare($c, "SELECT IDPELICULA FROM SALAS WHERE ID = 3");

                        /* execute query */
                        mysqli_stmt_execute($stmt);

                        /* bind result variables */
                        mysqli_stmt_bind_result($stmt, $idPeliBD);

                        /* fetch value */
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_fetch($stmt);

                        if (!empty($idPeliBD)) {
                            echo "<script>alert('La sala 3 ya tiene una película en proyección')</script>";
                            exit;
                        }

                        $sql_select = "SELECT IDAPI FROM PELICULAS WHERE IDAPI = ?";

                        if ($stmt_select = $conn->prepare($sql_select)) {
                            // Vincular el parámetro y comprobar si hay errores
                            $stmt_select->bind_param("s", $idApi);
                            $stmt_select->execute();
                            $stmt_select->store_result();

                            if ($stmt_select->num_rows > 0) {
                                // Si la película ya existe, realizar un UPDATE
                                $reactivar = "UPDATE PELICULAS SET ESTADO = 'A' WHERE IDAPI = ?";
                                $tipos = "s";

                                $c = new mysqli($servidor, $usuario, $contraseña, $basededatos);
                                $stmt = $c->prepare($reactivar);
                                $stmt->bind_param($tipos, $idApi);
                                if ($stmt->execute()) {
                                    $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 3";
                                    $tipos = "s";
                                    $stmt = $c->prepare($updateSala);
                                    $stmt->bind_param($tipos, $idApi);
                                    $stmt->execute();
                                    echo "<script>alert('Película reactivada correctamente, la página será recargada')</script>";
                                    header("Location: gestionarPeliculas.php");
                                    return;
                                }
                            } else {

                                // Preparar la consulta SQL con marcadores de posición (?)
                                $sql = "INSERT INTO PELICULAS (IDAPI, ESTADO) VALUES (?, ?)";

                                // Preparar la declaración SQL y comprobar si hay errores
                                if ($stmt = $conn->prepare($sql)) {
                                    // Vincular parámetros y comprobar si hay errores
                                    $estado = "A";
                                    $stmt->bind_param("ss", $idApi, $estado); // 
                                    if ($stmt->execute()) {
                                        $updateSala = "UPDATE SALAS SET IDPELICULA = ? WHERE ID = 3";
                                        $tipos = "s";
                                        $stmt = $c->prepare($updateSala);
                                        $stmt->bind_param($tipos, $idApi);
                                        $stmt->execute();
                                        echo "<script>alert('Película añadida correctamente, la página será recargada')</script>";
                                        // Cerrar la conexión
                                        $conn->close();
                                        header("Location: gestionarPeliculas.php");
                                    } else {
                                        $conn->close();
                                        echo "<script>alert('Algo salió mal')</script>";
                                    }
                                }

                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <br>
            <br>
        </div>
    </div>
</body>

</html>