window.addEventListener('load', function () {
    const container = document.querySelector('#peliculasWiki .col-12');

    let scrollEnabled = true;
    let page = 1;
    let btnLimpiar = document.getElementById('limpiar');
    let btnAplicar = document.getElementById('aplicar');
    let titulo = document.getElementById('titulo');
    let year = document.getElementById('year');

    btnLimpiar.addEventListener("click", limpiarFiltros);
    btnAplicar.addEventListener("click", aplicarFiltros);
    window.addEventListener('scroll', handleScroll);

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

    function cargarPeliculas() {
        let url = `http://www.omdbapi.com/?apikey=${APIKEY}&s=movie&page=${page}`;
        let parImpar = "Impar"
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
                            container.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                </table>
                            </div><br>`;
                            parImpar = "Par"
                        } else {
                            container.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                </table>
                            </div><br>`;
                            parImpar = "Impar"
                        }

                    });
                } else {
                    container.innerHTML = '<p>No se encontraron películas con esos filtros.</p>';
                }
                page++;
            })

            .catch(error => console.error('Error:', error));
    }
    function handleScroll() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            cargarPeliculas();
        }
    }

    cargarPeliculas();

    function aplicarFiltros() {
        if (todosLosCamposVacios()) {
            window.location.reload(); // Recargar la página si todos los campos están vacíos
            return;
        }
        container.innerHTML = '';
        var pagina = 1
        if (scrollEnabled) {
            window.removeEventListener('scroll', handleScroll);
            scrollEnabled = false;
        }
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
                            container.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                </table>
                            </div><br>`;
                            parImpar = "Par"
                        } else {
                            container.innerHTML += `
                            <div class="pelicula${parImpar}">
                                <table>
                                    <tr>
                                        <td rowspan="2"><a href="peliWiki.php?id=${id}"><img src="${poster}" alt="${titulo}" class="posterWiki"></a></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">${year}</td>
                                    </tr>
                                </table>
                            </div><br>`;
                            parImpar = "Impar"
                        }

                    });
                } else {
                    container.innerHTML = '<p>No se encontraron películas con esos filtros.</p>';
                }
                pagina++;
            })
            .catch(error => console.error('Error:', error));
    }
});