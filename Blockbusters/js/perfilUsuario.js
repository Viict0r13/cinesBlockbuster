function mostrarTituloPelicula(idPelicula) {
    let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${idPelicula}`;
    let p = document.createElement('p')
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.Response === "True") {
                let titulo = data.Title;
                p.textContent = titulo;
                document.getElementById(idPelicula).appendChild(p);
            }
        })
}
