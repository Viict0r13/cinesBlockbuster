document.addEventListener('DOMContentLoaded', function () {
    let btnLimpiar = document.getElementById('btnLimpiar');
    let btnAplicar = document.getElementById('btnAplicarFiltros');
    let titulo = document.getElementById('titulo');
    let year = document.getElementById('year');

    btnLimpiar.addEventListener("click", limpiarFiltros);
    btnAplicar.addEventListener("click", aplicarFiltros);

    titulo.addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            aplicarFiltros();
        }
    });
    year.addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            aplicarFiltros();
        }
    });

    function limpiarFiltros() {
        titulo.value = "";
        year.value = "";
    }
    function todosLosCamposVacios() {
        return titulo.value.trim() === "" &&
            year.value.trim() === "";
    }

    function aplicarFiltros() {
        if (todosLosCamposVacios()) {
            window.location.reload(); // Recargar la página si todos los campos están vacíos
            return;
        }
        var divPeliculasFiltradas = document.getElementById("divPeliculasFiltradas");

        divPeliculasFiltradas.innerHTML = '<br>';
        var pagina = 1
        let url = `http://www.omdbapi.com/?apikey=${APIKEY}&type=movie&page=${pagina}`;
        let parImpar = "Impar"
        let filtros = ``
        // Construir la URL con los parámetros de filtro
        if (titulo.value.trim() !== "") {
            filtros += `&s=${titulo.value}`;
        }
        if (year.value.trim() !== "") {
            filtros += `&y=${year.value}`;
        }

        divPeliculasFiltradas.innerHTML += '<form action="#" method="post">'


        url += filtros
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.Response === "True") {
                    data.Search.forEach(pelicula => {
                        let titulo = pelicula.Title;
                        let poster = pelicula.Poster;
                        let year = pelicula.Year;
                        let id = pelicula.imdbID;
                        if (parImpar === "Impar") {
                            let divImpar = document.createElement('div');
                            divImpar.className = 'pelicula' + parImpar;
                            let tablaImpar = document.createElement('table');
                            let trTitulo = document.createElement('tr');
                            let trYear = document.createElement('tr');
                            let tr1 = document.createElement('tr');
                            let tr2 = document.createElement('tr');
                            let tr3 = document.createElement('tr');
                            let tdImagen = document.createElement('td');
                            let tdTitulo = document.createElement('td');
                            let tdYear = document.createElement('td');
                            let td1 = document.createElement('td');
                            td1.className = "btnActivar";
                            let td2 = document.createElement('td');
                            td2.className = "btnActivar";
                            let td3 = document.createElement('td');
                            td3.className = "btnActivar";



                            let imagen = document.createElement('img');
                            imagen.src = poster;
                            imagen.alt = titulo;
                            imagen.className = "posterWiki";

                            let a = document.createElement('a');
                            a.href = "peliWiki.php?id=" + id;
                            a.appendChild(imagen);

                            let form = document.createElement('form');
                            form.action = "#"
                            form.method = "post"

                            let activar1 = document.createElement('button');
                            activar1.type = "submit";
                            activar1.id = "activar1";
                            activar1.className = "activar1";
                            activar1.name = "activar1";
                            activar1.value = id;
                            activar1.textContent = "Activar en sala 1";

                            let activar2 = document.createElement('button');
                            activar2.type = "submit";
                            activar2.id = "activar2";
                            activar2.classname = "activar2";
                            activar2.name = "activar2";
                            activar2.value = id;
                            activar2.textContent = "Activar en sala 2";

                            let activar3 = document.createElement('button');
                            activar3.type = "submit";
                            activar3.id = "activar3";
                            activar3.className = "activar3";
                            activar3.name = "activar3";
                            activar3.value = id;
                            activar3.textContent = "Activar en sala 3";

                            td1.appendChild(activar1);
                            td2.appendChild(activar2);
                            td3.appendChild(activar3);

                            tr1.appendChild(td1);
                            tr2.appendChild(td2);
                            tr3.appendChild(td3);

                            tdYear.className = "yearWiki";
                            tdYear.textContent = year;
                            trYear.appendChild(tdYear);

                            tdTitulo.classame = "tituloWiki";
                            tdTitulo.textContent = titulo;

                            tdImagen.rowSpan = 2;
                            tdImagen.appendChild(a);
                            trTitulo.appendChild(tdImagen);
                            trTitulo.appendChild(tdTitulo);
                            tablaImpar.appendChild(trTitulo)
                            tablaImpar.appendChild(trYear)
                            tablaImpar.appendChild(tr1)
                            tablaImpar.appendChild(tr2)
                            tablaImpar.appendChild(tr3)
                            form.appendChild(tablaImpar)
                            divImpar.appendChild(form)
                            divImpar.innerHTML+="<br>";
                            divPeliculasFiltradas.appendChild(divImpar);
                            parImpar = "Par"
                        } else {
                            let divPar = document.createElement('div');
                            divPar.className = 'pelicula' + parImpar;
                            let tablaPar = document.createElement('table');
                            let trTitulo = document.createElement('tr');
                            let trYear = document.createElement('tr');
                            let tr1 = document.createElement('tr');
                            let tr2 = document.createElement('tr');
                            let tr3 = document.createElement('tr');
                            let tdImagen = document.createElement('td');
                            let tdTitulo = document.createElement('td');
                            let tdYear = document.createElement('td');
                            let td1 = document.createElement('td');
                            td1.className = "btnActivar";
                            let td2 = document.createElement('td');
                            td2.className = "btnActivar";
                            let td3 = document.createElement('td');
                            td3.className = "btnActivar";



                            let imagen = document.createElement('img');
                            imagen.src = poster;
                            imagen.alt = titulo;
                            imagen.className = "posterWiki";

                            let a = document.createElement('a');
                            a.href = "peliWiki.php?id=" + id;
                            a.appendChild(imagen);

                            let form = document.createElement('form');
                            form.action = "#"
                            form.method = "post"

                            let activar1 = document.createElement('button');
                            activar1.type = "submit";
                            activar1.id = "activar1";
                            activar1.className = "activar1";
                            activar1.name = "activar1";
                            activar1.value = id;
                            activar1.textContent = "Activar en sala 1";

                            let activar2 = document.createElement('button');
                            activar2.type = "submit";
                            activar2.id = "activar2";
                            activar2.classname = "activar2";
                            activar2.name = "activar2";
                            activar2.value = id;
                            activar2.textContent = "Activar en sala 2";

                            let activar3 = document.createElement('button');
                            activar3.type = "submit";
                            activar3.id = "activar3";
                            activar3.className = "activar3";
                            activar3.name = "activar3";
                            activar3.value = id;
                            activar3.textContent = "Activar en sala 3";

                            td1.appendChild(activar1);
                            td2.appendChild(activar2);
                            td3.appendChild(activar3);

                            tr1.appendChild(td1);
                            tr2.appendChild(td2);
                            tr3.appendChild(td3);

                            tdYear.className = "yearWiki";
                            tdYear.textContent = year;
                            trYear.appendChild(tdYear);

                            tdTitulo.classame = "tituloWiki";
                            tdTitulo.textContent = titulo;

                            tdImagen.rowSpan = 2;
                            tdImagen.appendChild(a);
                            trTitulo.appendChild(tdImagen);
                            trTitulo.appendChild(tdTitulo);
                            tablaPar.appendChild(trTitulo)
                            tablaPar.appendChild(trYear)
                            tablaPar.appendChild(tr1)
                            tablaPar.appendChild(tr2)
                            tablaPar.appendChild(tr3)
                            form.appendChild(tablaPar)
                            divPar.appendChild(form)
                            divPeliculasFiltradas.appendChild(divPar);
                            divPar.innerHTML+="<br>";
                            parImpar = "Impar"
                        }
                    });
                } else {
                    divPeliculasFiltradas.innerHTML = '<p>No se encontraron películas con esos filtros.</p>';
                }
                pagina++;
            })
            .catch(error => console.error('Error:', error));

        divPeliculasFiltradas.innerHTML += '</form">'
    }

});

function mostrarActivas(listaIdsActivas, salas) {
    for (let i = 0; i < listaIdsActivas.length; i++) {
        let id = listaIdsActivas[i]
        let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${id}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {

                if (data.Response === "True") {
                    let nuevaPelicula = {
                        id: data.imdbID,
                        titulo: data.Title,
                        año: data.Year,
                        imagen: data.Poster,
                        tema: data.Plot
                    }
                    crearTabla("activas", nuevaPelicula, salas[i])
                }
            })
    }
}

function mostrarInactivas(listaIdsInactivas) {
    for (let i = 0; i < listaIdsInactivas.length; i++) {
        let id = listaIdsInactivas[i]
        let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${id}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.Response === "True") {
                    let nuevaPelicula = {
                        id: data.imdbID,
                        titulo: data.Title,
                        año: data.Year,
                        imagen: data.Poster,
                        tema: data.Plot
                    }
                    crearTabla("inactivas", nuevaPelicula)
                }
            })
    }
}

function crearTabla(tipo, pelicula, sala) {
    // Crear la tabla
    let tabla = document.createElement('table');
    tabla.className = tipo; // Agregar la clase 'activas' a la tabla

    // Crear filas y celdas de datos
    for (let i = 0; i < 3; i++) {
        // Crear una fila
        let fila = document.createElement('tr');

        // Crear la celda de imagen si es la primera fila
        if (i === 0) {
            let celdaCaratula = document.createElement('td');
            celdaCaratula.setAttribute('rowspan', '5'); // Agregar el atributo rowspan
            celdaCaratula.className = 'caratula'; // Agregar la clase 'caratula' a la celda

            let a = document.createElement('a')
            a.href = 'peliWiki.php?id=' + pelicula.id;
            let imagen = document.createElement('img')
            imagen.src = pelicula.imagen
            imagen.alt = pelicula.titulo
            imagen.className = "posterWiki"
            a.appendChild(imagen)
            celdaCaratula.appendChild(a)
            fila.appendChild(celdaCaratula); // Agregar la celda a la fila
        }

        // Crear las celdas de contenido
        let celdaContenido = document.createElement('td');
        if (i === 0) {
            celdaContenido.textContent = pelicula.titulo; // Contenido de la celda de título
        } else if (i === 1) {
            celdaContenido.textContent = pelicula.año; // Contenido de la celda de año
        } else if (i === 2) {
            celdaContenido.textContent = pelicula.tema; // Contenido de la celda de tema
        }
        fila.appendChild(celdaContenido); // Agregar la celda a la fila
        // Agregar la fila a la tabla
        tabla.appendChild(fila);
        if (i === 2 && tipo === "activas") {
            let filaBtn = document.createElement('tr');
            let celdaBtn = document.createElement('td');
            let frmBtn = document.createElement('form');
            frmBtn.action = "#"
            frmBtn.method = "post"
            let btnPelicula = document.createElement('button');
            btnPelicula.id = "btnQuitar" + sala;
            btnPelicula.name = "btnQuitar" + sala;
            btnPelicula.value = pelicula.id;
            btnPelicula.type = "submit";
            btnPelicula.textContent = "Quitar de la sala " + sala;
            frmBtn.appendChild(btnPelicula);
            celdaBtn.appendChild(frmBtn);
            filaBtn.appendChild(celdaBtn);
            tabla.appendChild(filaBtn);

            sala++;
        }
        if (i === 2 && tipo === "inactivas") {
            let filaBtn = document.createElement('tr');
            let celdaBtn = document.createElement('td');
            let frmBtn = document.createElement('form');
            frmBtn.action = "#"
            frmBtn.method = "post"
            let btnPelicula1 = document.createElement('button');
            let btnPelicula2 = document.createElement('button');
            let btnPelicula3 = document.createElement('button');

            btnPelicula1.id = "btnReactivar1";
            btnPelicula1.name = "btnReactivar1";
            btnPelicula1.value = pelicula.id;
            btnPelicula1.type = "submit";
            btnPelicula1.textContent = "Reactivar en sala 1"
            frmBtn.appendChild(btnPelicula1);

            btnPelicula2.id = "btnReactivar2";
            btnPelicula2.name = "btnReactivar2";
            btnPelicula2.value = pelicula.id;
            btnPelicula2.type = "submit";
            btnPelicula2.textContent = "Reactivar en sala 2"
            frmBtn.appendChild(btnPelicula2);

            btnPelicula3.id = "btnReactivar3";
            btnPelicula3.name = "btnReactivar3";
            btnPelicula3.value = pelicula.id;
            btnPelicula3.type = "submit";
            btnPelicula3.textContent = "Reactivar en sala 3"
            frmBtn.appendChild(btnPelicula3);

            celdaBtn.appendChild(frmBtn);
            filaBtn.appendChild(celdaBtn);
            tabla.appendChild(filaBtn);
        }
    }

    // Agregar la tabla al cuerpo del documento
    if (tipo == "activas") {
        var div = document.getElementById("peliculasActivas")
    } else {
        var div = document.getElementById("peliculasInactivas")
    }

    div.appendChild(tabla);
    div.style.alignItems = "center";
}