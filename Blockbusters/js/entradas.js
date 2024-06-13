function cargarInfoPelicula(idPelicula) {
    let url = `http://www.omdbapi.com/?apikey=${APIKEY}&i=${idPelicula}`;
    let tdImagen = document.getElementById("tdImagenInfoPelicula")
    let tdTitulo = document.getElementById("tdTituloInfoPelicula")
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.Response === "True") {

                let imagen = document.createElement("img");
                let titulo = document.createElement("p");

                imagen.id = "imagenInfoPelicula";
                imagen.src = data.Poster;
                imagen.alt = "imagen no disponible";
                tituloTexto = document.createTextNode(data.Title);
                titulo.appendChild(tituloTexto);

                tdImagen.appendChild(imagen);
                tdTitulo.appendChild(titulo);
            }
        })

    // Se aprovecha esta función para cargar los límites de la fecha
    let hoy = new Date();
    let fechaMaxima = new Date(hoy.getTime() + 6 * 24 * 60 * 60 * 1000);

    let fechaMaximaFormato = fechaMaxima.toISOString().split('T')[0];

    let inputFecha = document.getElementById('fechaEntrada');
    inputFecha.setAttribute('min', hoy.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', fechaMaximaFormato);
}

function cargarButacas(butacas, aforo, idPelicula, idSala, fecha) {
    let butacaClass = document.getElementsByClassName('butaca');

    if (butacas.length == 0) {
        for (let i = 0; i < aforo; i++) {
            butacaClass[i].style.backgroundColor = 'rgb(7, 187, 7)';
        }
    } else if (butacas.length == 50) {
        for (let i = 0; i < butacaClass.length; i++) {
            butacaClass[i].style.backgroundColor = 'red';
        }
    } else {
        //Pintamos todas las butacas en disponibles
        for (let i = 0; i < aforo; i++) {
            butacaClass[i].style.backgroundColor = 'rgb(7, 187, 7)';
        }
        //Pintamos las butacas no dispobles
        for (let i = 0; i < butacas.length; i++) {
            let butacaOcupada = document.getElementById(butacas[i]);
            butacaOcupada.style.backgroundColor = 'red';
        }
    }
    //si el color de la butaca es el mismo que el de las disponibles le añadimos el enlace
    for (let i = 0; i < aforo; i++) {
        if (window.getComputedStyle(butacaClass[i]).getPropertyValue('background-color') === 'rgb(7, 187, 7)') {
            let a = document.createElement('a');
            a.href = "pagarEntrada.php?butaca=" + butacaClass[i].id + "&pelicula=" + idPelicula + "&sala=" + idSala + "&fecha=" + fecha;
            a.text = "o";
            a.style.textDecoration = "none";
            a.style.opacity = 0;
            a.style.fontSize = "16px";
            butacaClass[i].style.borderRadius = " 10px";
            butacaClass[i].style.padding = "0px";
            butacaClass[i].appendChild(a);
        }
    }
}