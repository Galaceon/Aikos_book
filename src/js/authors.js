(function() {
    const authorsInput = document.querySelector('#authors');

    if(authorsInput) {
        
        let authors = [] // Almacena authors que vienen de la API
        let authorsFiltrados = [] // Almacena los authors filtrados por la busqueda
        
        const listadoAuthors = document.querySelector('#listado-authors');
        const contenedorAuthors = document.querySelector('#admin-formulario__contenedor-authors');
        const inputHidden = document.querySelector('#authors-hidden');
        const addAuthorButton = document.querySelector('#btn-crear-author');
        addAuthorButton.addEventListener('click', crearAuthor);

        let authorsSeleccionados = [];

        obtenerAuthors();

        // OBTENER authors
        async function obtenerAuthors() {
            const url = `/api/authors`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            console.log('yea');

            formatearAuthors(resultado);
        }
        function formatearAuthors(arrayAuthors = []) {
            authors = arrayAuthors.map( author => {
                return {
                    name: `${author.name.trim()}`,
                    id: `${author.id}`
                }
            })
        }


        // FILTRAR authorS POR BUSQUEDA
        authorsInput.addEventListener('input', buscarAuthors);

        function buscarAuthors(e) {
            const busqueda = e.target.value;

            if(busqueda.length >= 1) {
                const expresion = new RegExp(busqueda, 'i');

                authorsFiltrados = authors.filter( author => {
                    if(author.name.toLowerCase().search(expresion) != -1) {
                        return author;
                    }
                })

                mostrarAuthors();
            } else {
                authorsFiltrados = [];
                listadoAuthors.classList.remove('mostrar')
            }
        }


        // MOSTRAR AUTORES FILTRADOS
        function mostrarAuthors() {
            while(listadoAuthors.firstChild) {
                listadoAuthors.removeChild(listadoAuthors.firstChild);
            }

            if(authorsFiltrados.length > 0) {
                listadoAuthors.classList.add('mostrar');
                authorsFiltrados.forEach( author => {
                    const authorHTML = document.createElement('LI');
                    authorHTML.classList.add('listado-filtros__filtro');
                    authorHTML.textContent = author.name;
                    authorHTML.dataset.authorId = author.id;
                    authorHTML.onclick = seleccionarAuthor;

                    listadoAuthors.appendChild(authorHTML);
                })
            } else {
                listadoAuthors.classList.add('mostrar');
                const noAuthors = document.createElement('LI');
                noAuthors.classList.add('listado-filtros__filtro--error');
                noAuthors.textContent = 'Aun no existe, crealo: +';

                listadoAuthors.appendChild(noAuthors);
            }
        }


        function seleccionarAuthor(e) {
            const author = e.target;

            const authorId = author.dataset.authorId;
            const authorName = author.textContent;

            const existe = authorsSeleccionados.some(author => author.id === authorId);
            if(existe) return;

            authorsSeleccionados = [...authorsSeleccionados, {
                id: authorId,
                name: authorName
            }];
            authorsInput.value = "";
            listadoAuthors.classList.remove('mostrar');

            sincronizarAuthors();

            mostrarAuthorsSeleccionados();
        }
        

        function sincronizarAuthors() {

            inputHidden.value = JSON.stringify(
                authorsSeleccionados.map(author => author.id)
            );
        }

        function mostrarAuthorsSeleccionados() {
            while(contenedorAuthors.firstChild) {
                contenedorAuthors.removeChild(contenedorAuthors.firstChild);
            }

            authorsSeleccionados.forEach( authorSeleccionado => {
                const authorDOM = document.createElement('LI');
                authorDOM.classList.add('admin-formulario__filtro-DOM');
                authorDOM.textContent = authorSeleccionado['name'];
                authorDOM.dataset.authorId = authorSeleccionado['id'];
                authorDOM.onclick = borrarAuthor;

                contenedorAuthors.appendChild(authorDOM);
            })


        }

        function borrarAuthor(e) {
            // Borrar visualmente el author
            authorsSeleccionados = (authorsSeleccionados.filter(
                author => author.id !== e.target.dataset.authorId
            ))

            // Borrar los id de inputHidden
            let ids = JSON.parse(inputHidden.value)
            ids = ids.filter(id => id !==  e.target.dataset.authorId)
            inputHidden.value = JSON.stringify(ids)

            mostrarAuthorsSeleccionados();
        }

        async function crearAuthor() {
            const name = authorsInput.value.trim();
            if(name === '') return;

            const datos = new FormData();
            datos.append('name', name);

            try {
                const url = '/api/authors/create';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const nuevoAuthor = await respuesta.json();
                
                if(nuevoAuthor.tipo === 'error') {
                    mostrarAlerta(nuevoAuthor.mensaje, nuevoAuthor.tipo, document.querySelector('.admin-formulario__campo'));
                } else {
                    // Añadir al sistema actual
                    authors = [...authors, nuevoAuthor];
                    authorsSeleccionados = [...authorsSeleccionados, nuevoAuthor];

                    sincronizarAuthors();
                    mostrarAuthorsSeleccionados();

                    listadoAuthors.classList.remove('mostrar')
                    authorsInput.value = '';
                } 
            } catch (error) {
                console.log(error);
            }
        }

        function mostrarAlerta(mensaje, tipo, referencia, animacion = false) {
            // Previene la creación de varias alertas
            const alertaPrevia = document.querySelector('.alerta');
            if(alertaPrevia) {
                alertaPrevia.remove();
            }

            const alerta = document.createElement('DIV');
            alerta.classList.add(`alerta__${tipo}`);
            alerta.classList.add('alerta');
            if(animacion) { // Si se requiere animación, agrega clase de animación según el tipo(éxito o error)
                alerta.classList.add(`animacion-${tipo}`) 
            }
            alerta.textContent = mensaje;

            // Colocar aleta debajo de la referencia
            referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);
            
            // Eliminar la alerta tras 3 segundos
            setTimeout(() => {
                alerta.remove();
            }, 3000)
        }
    }

})();