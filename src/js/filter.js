(function() {
    const filtrosEstado = {
        tag: null,
        author: null
    };

    const filtrosBtn = document.querySelector('#filtros-button');
    const filtrosContenedor = document.querySelector('.filtros-contenedor');

    if(filtrosBtn) {
        if(!filtrosBtn) return;

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.barra__filtros-wrapper')) {
                filtrosBtn.classList.remove('abierto');
                filtrosContenedor.classList.remove('mostrar');
            }
        });

        filtrosBtn.addEventListener('click', () => {
            filtrosBtn.classList.toggle('abierto');
            filtrosContenedor.classList.toggle('mostrar');

            if (!filtrosCargados) {
                cargarFiltros();
                filtrosCargados = true;
            }
        });


        let filtrosCargados = false;

        async function cargarFiltros() {
            const [tagsRes, authorsRes] = await Promise.all([
                fetch('/api/public/tags'),
                fetch('/api/public/authors')
            ]);

            const tags = await tagsRes.json();
            const authors = await authorsRes.json();

            renderListado(
                document.querySelector('.js-filtro-tags'), tags, 'tag'
            );

            renderListado(
                document.querySelector('.js-filtro-authors'), authors, 'author'
            );
        }

        function renderListado(ul, items, tipo) {
            ul.innerHTML = '';

            items.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('filtro__item');
                li.textContent = item.name;
                li.dataset.slug = item.slug;

                li.addEventListener('click', () => {
                    seleccionarFiltro(tipo, item, ul);
                });

                ul.appendChild(li);
            });
        }

        function seleccionarFiltro(tipo, item, ul) {
            // Guardar estado
            filtrosEstado[tipo] = item.slug;

            // UI: marcar activo
            ul.querySelectorAll('.filtro__item').forEach(li => {
                li.classList.remove('activo');
            });

            const liActivo = ul.querySelector(`[data-slug="${item.slug}"]`);
            liActivo.classList.add('activo');

            // Cambiar texto del botón
            const filtro = ul.closest('.filtro');
            const header = filtro.querySelector('.filtro__header');
            header.textContent = item.name;
        }

        const aplicarBtn = document.querySelector('.filtros__aplicar');

        aplicarBtn.addEventListener('click', () => {
            const params = new URLSearchParams();

            if (filtrosEstado.tag) {
                params.append('tag', filtrosEstado.tag);
            }

            if (filtrosEstado.author) {
                params.append('author', filtrosEstado.author);
            }

            window.location.href = `/?${params.toString()}`;
        });

    }
})();