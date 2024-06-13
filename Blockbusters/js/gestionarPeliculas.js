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
                            divPeliculasFiltradas.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                    <form action="#" method="post">
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar1" name ="activar1" value = "${id}">Activar en sala 1</button></td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar2" name ="activar2" value = "${id}">Activar en sala 2</button></td>
                                    </tr>
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar3" name ="activar3" value = "${id}">Activar en sala 3</button></td>
                                    </tr>
                                    </form>
                                </table>
                            </div><br>`;
                            parImpar = "Par"
                        } else {
                            divPeliculasFiltradas.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                        <form action="#" method="post">
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar1" name ="activar1" value = "${id}">Activar en sala 1</button></td>
                                    </tr>
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar2" name ="activar2" value = "${id}">Activar en sala 2</button></td>
                                    </tr>
                                    <tr>
                                        <td class="btnActivar"><button type="submit" id="activar3" name ="activar3" value = "${id}">Activar en sala 3</button></td>
                                    </tr>
                                    </form>
                                </table>
                            </div><br>`;
                            parImpar = "Impar"
                        }
                    });
                } else {
                    divPeliculasFiltradas.innerHTML = '<p>No se encontraron películas con esos filtros.</p>';
                }
                pagina++;
            })
            .catch(error => console.error('Error:', error));
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
            btnPelicula.id = "btnQuitar";
            btnPelicula.name = "btnQuitar";
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