(function() {
    const tagsInput = document.querySelector('#tags');

    if(tagsInput) {
        let tags = [] // Almacena tags que vienen de la API
        let tagsFiltrados = [] // Almacena los tags filtrados por la busqueda
        
        const listadoTags = document.querySelector('#listado-tags');
        const contenedorTags = document.querySelector('#admin-formulario__contenedor-tags');
        const inputHidden = document.querySelector('#tags-hidden');

        let tagsSeleccionados = [];

        obtenerTags();

        // OBTENER TAGS
        async function obtenerTags() {
            const url = `/api/tags`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearTags(resultado);
        }
        function formatearTags(arrayTags = []) {
            tags = arrayTags.map( tag => {
                return {
                    name: `${tag.name.trim()}`,
                    id: `${tag.id}`
                }
            })
        }


        // FILTRAR TAGS POR BUSQUEDA
        tagsInput.addEventListener('input', buscarTags);

        function buscarTags(e) {
            const busuqeda = e.target.value;

            if(busuqeda.length >= 1) {
                const expresion = new RegExp(busuqeda, 'i');

                tagsFiltrados = tags.filter( tag => {
                    if(tag.name.toLowerCase().search(expresion) != -1) {
                        return tag;
                    }
                })

                mostrarTags();
            } else {
                tagsFiltrados = [];
                listadoTags.classList.remove('mostrar')
            }
        }


        // MOSTRAR TAGS FILTRADOS
        function mostrarTags() {
            while(listadoTags.firstChild) {
                listadoTags.removeChild(listadoTags.firstChild);
            }

            if(tagsFiltrados.length > 0) {
                listadoTags.classList.add('mostrar');
                tagsFiltrados.forEach( tag => {
                    const tagHTML = document.createElement('LI');
                    tagHTML.classList.add('listado-tags__tag');
                    tagHTML.textContent = tag.name;
                    tagHTML.dataset.tagId = tag.id;
                    tagHTML.onclick = seleccionarTag;

                    listadoTags.appendChild(tagHTML);
                })
            } else {
                console.log('golaaa')
                listadoTags.classList.add('mostrar');
                const noTags = document.createElement('LI');
                noTags.classList.add('listado-tags__tag--error');
                noTags.textContent = 'Aun no existe, Crealo';

                listadoTags.appendChild(noTags);
            }
        }


        function seleccionarTag(e) {
            const tag = e.target;

            const tagId = tag.dataset.tagId;
            const tagName = tag.textContent;

            const existe = tagsSeleccionados.some(tag => tag.id === tagId);
            if(existe) return;

            tagsSeleccionados = [...tagsSeleccionados, {
                id: tagId,
                name: tagName
            }];
            tagsInput.value = "";
            listadoTags.classList.remove('mostrar');

            sincronizarTags();

            mostrarTagsSeleccionados();
        }
        

        function sincronizarTags() {

            inputHidden.value = JSON.stringify(
                tagsSeleccionados.map(tag => tag.id)
            );
        }

        function mostrarTagsSeleccionados() {
            while(contenedorTags.firstChild) {
                contenedorTags.removeChild(contenedorTags.firstChild);
            }

            tagsSeleccionados.forEach( tagSeleccionado => {
                const tagDOM = document.createElement('LI');
                tagDOM.classList.add('admin-formulario__tag-DOM');
                tagDOM.textContent = tagSeleccionado['name'];
                tagDOM.dataset.tagId = tagSeleccionado['id'];
                tagDOM.onclick = borrarTag;

                contenedorTags.appendChild(tagDOM);
            })


        }

        function borrarTag(e) {
            // Borrar visualmente el tag
            tagsSeleccionados = (tagsSeleccionados.filter(
                tag => tag.id !== e.target.dataset.tagId
            ))

            // Borrar los id de inputHidden
            let ids = JSON.parse(inputHidden.value)
            ids = ids.filter(id => id !==  e.target.dataset.tagId)
            inputHidden.value = JSON.stringify(ids)

            mostrarTagsSeleccionados();
        }
    }


})();