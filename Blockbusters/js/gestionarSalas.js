function mostrarTituloPelicula(idPelicula, idInput) {
    let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${idPelicula}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.Response === "True") {
                let titulo = data.Title;
                document.getElementById(idInput).value = titulo;
            }
        })
}
