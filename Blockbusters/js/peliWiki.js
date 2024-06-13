window.addEventListener('load', function () {
    const container = document.querySelector('#peliculasWiki .col-12');
    // Obtener la URL actual
    var urlString = window.location.href;

    // Crear un objeto URL con la URL actual
    var url = new URL(urlString);

    // Obtener los parámetros de la URL
    var params = new URLSearchParams(url.search);

    // Obtener el valor del parámetro "id"
    var id = params.get('id');

    function cargarPeliculas() {
        let urlApi = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${id}`;

        fetch(urlApi)
            .then(response => response.json())
            .then(data => {
                if (data.Response === "True") {
                        let titulo = data.Title;
                        let poster = data.Poster;
                        let lanzamiento = data.Released;
                        let duracion = data.Runtime
                        let genero = data.Genre
                        let director = data.Director
                        let escritor = data.Writer
                        let reparto = data.Actors
                        let trama = data.Plot
                        let valoracion = data.Ratings[0]
                        let puntuacion = valoracion.Value
                        let critico = valoracion.Source
                            container.innerHTML += `
                            <div id="peliculasWiki" class="peliculaPar">
                                <table>
                                    <tr>
                                        <td rowspan="2"><img src="${poster}" alt="${titulo}" class="posterPeli"></td>
                                        <td class="tituloWiki">${titulo}</td>
                                    </tr>
                                    <tr>
                                        <td class="yearWiki">Lanzamiento: ${lanzamiento}</td>
                                    </tr>
                                </table>
                                <p>Duración: ${duracion}</p>
                                <p>Género: ${genero}</p>
                                <p>Director: ${director}</p>
                                <p>Escritor: ${escritor}</p>
                                <p>Reparto: ${reparto}</p>
                                <p>Argumento: ${trama}</p>
                                <p>Valoración: ${puntuacion} según ${critico}</p>
                            </div><br>`;
                } else {
                    container.innerHTML = '<p>No se encontraron películas con esos filtros.</p>';
                }
                page++;
            })

            .catch(error => console.error('Error:', error));
    }

    cargarPeliculas();

});