(function () {
    const buscadores = document.querySelectorAll('.js-buscador');

    if (!buscadores.length) return;

    let timeout;

    buscadores.forEach(input => {
        input.addEventListener('input', e => buscarReviews(e, input));
    });

    document.addEventListener('click', e => {
        buscadores.forEach(input => {
            const contenedor = input.closest('.barra__buscador');
            const listado = contenedor.querySelector('.js-listado-reviews');

            if (
                listado &&
                !contenedor.contains(e.target)
            ) {
                listado.classList.remove('mostrar');
            }
        });
    });

    function buscarReviews(e, input) {
        clearTimeout(timeout);

        const busqueda = e.target.value.trim();
        const contenedor = input.closest('.barra__buscador');
        const listado = contenedor.querySelector('.js-listado-reviews');

        if (!listado) return;

        if (busqueda.length < 1) {
            listado.classList.remove('mostrar');
            listado.innerHTML = '';
            return;
        }

        timeout = setTimeout(async () => {
            const url = `/api/search?search=${encodeURIComponent(busqueda)}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            mostrarReviews(resultado, listado);
        }, 300);
    }

    function mostrarReviews(reviews, listado) {
        listado.innerHTML = '';

        if (reviews.length > 0) {
            listado.classList.add('mostrar');

            reviews.forEach(review => {
                const li = document.createElement('LI');
                li.classList.add('listado-filtros__filtro');
                li.textContent = review.title;
                li.dataset.reviewSlug = review.slug;
                li.addEventListener('click', () => {
                    window.location.href = `/review?slug=${review.slug}`;
                });

                listado.appendChild(li);
            });
        } else {
            listado.classList.add('mostrar');

            const li = document.createElement('LI');
            li.classList.add('listado-filtros__filtro--error');
            li.textContent = 'Aún no he leído ese libro';

            listado.appendChild(li);
        }
    }
})();