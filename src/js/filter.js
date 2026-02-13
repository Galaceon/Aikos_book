(function() {

    const filtrosEstado = {
        tag: null,
        author: null
    };

    const wrappers = document.querySelectorAll('.barra__filtros-wrapper');

    if (!wrappers.length) return;

    let filtrosCargados = false;

    wrappers.forEach(wrapper => {

        const filtrosBtn = wrapper.querySelector('.barra__filtros-btn');
        const filtrosContenedor = wrapper.querySelector('.filtros-contenedor');
        const filtros = wrapper.querySelectorAll('.filtro');
        const aplicarBtn = wrapper.querySelector('.filtros__aplicar');

        // Toggle contenedor principal
        filtrosBtn.addEventListener('click', (e) => {
            e.stopPropagation();

            filtrosBtn.classList.toggle('abierto');
            filtrosContenedor.classList.toggle('mostrar');

            if (!filtrosCargados) {
                cargarFiltros();
                filtrosCargados = true;
            }
        });

        // Abrir filtros individuales
        filtros.forEach(filtro => {
            filtro.addEventListener('click', (e) => {
                e.stopPropagation();

                const estaAbierto = filtro.classList.contains('abierto');

                filtros.forEach(f => f.classList.remove('abierto'));

                if (!estaAbierto) {
                    filtro.classList.add('abierto');
                }
            });
        });

        // Botón aplicar
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

    });

    // Cerrar todo si se hace click fuera
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.barra__filtros-wrapper')) {
            wrappers.forEach(wrapper => {
                const btn = wrapper.querySelector('.barra__filtros-btn');
                const cont = wrapper.querySelector('.filtros-contenedor');

                if (btn) btn.classList.remove('abierto');
                if (cont) cont.classList.remove('mostrar');
                wrapper.querySelectorAll('.filtro').forEach(f => {
                    f.classList.remove('abierto');
                });
            });
        }
    });

    // Cargar datos
    async function cargarFiltros() {
        const [tagsRes, authorsRes] = await Promise.all([
            fetch('/api/tags/all'),
            fetch('/api/authors/all')
        ]);

        const tags = await tagsRes.json();
        const authors = await authorsRes.json();

        renderListado('.js-filtro-tags', tags, 'tag');
        renderListado('.js-filtro-authors', authors, 'author');
    }

    function renderListado(selector, items, tipo) {
        const uls = document.querySelectorAll(selector);

        uls.forEach(ul => {
            ul.innerHTML = '';

            items.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('filtro__item');
                li.textContent = item.name;
                li.dataset.slug = item.slug;

                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    seleccionarFiltro(tipo, item);
                });

                ul.appendChild(li);
            });
        });
    }

    function seleccionarFiltro(tipo, item) {
        filtrosEstado[tipo] = item.slug;

        const uls = document.querySelectorAll(`.js-filtro-${tipo}s`);

        uls.forEach(ul => {
            ul.querySelectorAll('.filtro__item').forEach(li => {
                li.classList.remove('activo');
            });

            const liActivo = ul.querySelector(`[data-slug="${item.slug}"]`);
            if (liActivo) liActivo.classList.add('activo');

            const filtro = ul.closest('.filtro');
            const header = filtro.querySelector('.filtro__header');
            header.textContent = item.name;
        });
    }

})();