function mostrarTituloPelicula(idPelicula) {
    let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${idPelicula}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.Response === "True") {
                let titulo = data.Title;
                document.getElementById(idPelicula).value = titulo;
            }
        })
}
