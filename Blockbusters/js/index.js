var pelicula = {
    id: "",
    titulo: "",
    año: "",
    tema: "",
    director: "",
    protagonista: "",
    imagen: "",
    duracion: "",
}

function mostrarActivas(datos_json) {
    for (let i = 0; i < datos_json.length; i++) {
        let id = datos_json[i]
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

                    crearTabla("activas", nuevaPelicula)
                }
            })
    }
}

function mostrarProximas(datos_json) {
    for (let i = 0; i < datos_json.length; i++) {
        let id = datos_json[i]
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

                    crearTabla("proximas", nuevaPelicula)
                }
            })
    }
}

function crearTabla(tipo, pelicula) {
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
            let btnEntrada = document.createElement('button');
            btnEntrada.id = "btnEntrada";
            btnEntrada.name = "btnEntrada";
            btnEntrada.value = pelicula.id;
            btnEntrada.type = "submit";
            btnEntrada.textContent = "Ver entradas"
            frmBtn.appendChild(btnEntrada);
            celdaBtn.appendChild(frmBtn);
            filaBtn.appendChild(celdaBtn);
            tabla.appendChild(filaBtn);
        }
    }

    // Agregar la tabla al cuerpo del documento
    let div = document.getElementById(tipo)
    div.appendChild(tabla);
    div.style.alignItems = "center";
}
