<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.1">
    <title>CineWiki</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
     <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/cineWiki.js"></script>
</head>

<body>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="a">Inicio</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="#" class="activo" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="a">Perfil</a></div>
        </div>
        <div class="row">
            <div class="col-12" id="divFiltros">
                <form id="formFiltros">
                    <title class="tituloForm">Filtrar películas</title>
                    <input type="text" id="titulo" placeholder="Título">
                    <input type="number" id="year" placeholder="Año">
                    <br>
                    <br>
                    <button type="button" id="aplicar">Aplicar Filtros</button>
                    <button type="button" id="limpiar">Limpiar Filtros</button>
                </form>

            </div>
        </div>
        <br>
        <br>
        <div class="row" id="peliculasWiki">
            <div class="col-12">

            </div>
        </div>
    </div>
</body>
</html>