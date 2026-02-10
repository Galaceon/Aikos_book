(function() {
    const tagsInput = document.querySelector('#tags');

    if(tagsInput) {
        if(!tagsInput) return;

        let tags = [] // Almacena tags que vienen de la API
        let tagsFiltrados = [] // Almacena los tags filtrados por la busqueda
        
        const listadoTags = document.querySelector('#listado-tags');
        const contenedorTags = document.querySelector('#admin-formulario__contenedor-tags');
        const inputHidden = document.querySelector('#tags-hidden');
        const addTagButton = document.querySelector('#btn-crear-tag');
        addTagButton.addEventListener('click', crearTag);

        let tagsSeleccionados = [];

        if (window.tagsReview && window.tagsReview.length > 0) {
            tagsSeleccionados = window.tagsReview.map(tag => ({
                id: tag.id,
                name: tag.name
            }));

            sincronizarTags();
            mostrarTagsSeleccionados();
        }

        // OBTENER TAGS
        tagsInput.addEventListener('input', buscarTags);

        async function buscarTags(e) {
            const busqueda = e.target.value.trim();

            if (busqueda.length < 1) {
                listadoTags.classList.remove('mostrar');
                return;
            }

            const url = `/api/tags?search=${encodeURIComponent(busqueda)}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            tagsFiltrados = resultado.map(tag => ({
                id: tag.id,
                name: tag.name
            }));

            mostrarTags();
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
                    tagHTML.classList.add('listado-filtros__filtro');
                    tagHTML.textContent = tag.name;
                    tagHTML.dataset.tagId = tag.id;
                    tagHTML.onclick = seleccionarTag;

                    listadoTags.appendChild(tagHTML);
                })
            } else {
                listadoTags.classList.add('mostrar');
                const noTags = document.createElement('LI');
                noTags.classList.add('listado-filtros__filtro--error');
                noTags.textContent = 'Aun no existe, crealo: +';

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
                tagDOM.classList.add('admin-formulario__filtro-DOM');
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

        async function crearTag() {
            const name = tagsInput.value.trim();
            if(name === '') return;

            const datos = new FormData();
            datos.append('name', name);

            try {
                const url = '/api/tags/create';
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const nuevoTag = await respuesta.json();

                if(nuevoTag.tipo === 'error') {
                    mostrarAlerta(nuevoTag.mensaje, nuevoTag.tipo, document.querySelector('.admin-formulario__campo'));
                } else {
                    // Añadir al sistema actual
                    tags = [...tags, nuevoTag];
                    tagsSeleccionados = [...tagsSeleccionados, nuevoTag];

                    sincronizarTags();
                    mostrarTagsSeleccionados();

                    listadoTags.classList.remove('mostrar')
                    tagsInput.value = '';
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