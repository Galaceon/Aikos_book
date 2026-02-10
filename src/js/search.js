(function() {
    const buscadorInput = document.querySelector('#buscador');

    if(buscadorInput) {
        if(!buscadorInput) return;

        let reviews = []
        let reviewsFiltradas = []

        const listadoReviews = document.querySelector('#listado-reviews');

        document.addEventListener('click', e => {
            if (!listadoReviews.contains(e.target) && e.target !== buscadorInput) {
                listadoReviews.classList.remove('mostrar');
            }
        });

        // OBTENER REVIEWS
        let timeout;

        buscadorInput.addEventListener('input', buscarReviews);

        function buscarReviews(e) {
            clearTimeout(timeout);

            const busqueda = e.target.value.trim();

            if (busqueda.length < 1) {
                listadoReviews.classList.remove('mostrar');
                return;
            }

            timeout = setTimeout(async () => {
                const url = `/api/search?search=${encodeURIComponent(busqueda)}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                reviewsFiltradas = resultado.map(review => ({
                    id: review.id,
                    title: review.title,
                    slug: review.slug
                }));

                mostrarReviews();
            }, 300)
        }

        // MOSTRAR REVIEWS FILTRADAS
        function mostrarReviews() {
            while(listadoReviews.firstChild) {
                listadoReviews.removeChild(listadoReviews.firstChild);
            }

            console.log(reviewsFiltradas);

            if(reviewsFiltradas.length > 0) {
                listadoReviews.classList.add('mostrar');
                reviewsFiltradas.forEach( review => {
                    const reviewHTML = document.createElement('LI');
                    reviewHTML.classList.add('listado-filtros__filtro');
                    reviewHTML.textContent = review.title;
                    reviewHTML.dataset.reviewSlug = review.slug;
                    reviewHTML.onclick = seleccionarReview;
                    
                    listadoReviews.appendChild(reviewHTML);
                })
            } else {
                listadoReviews.classList.add('mostrar');
                const noReviews = document.createElement('LI');
                noReviews.classList.add('listado-filtros__filtro--error');
                noReviews.textContent = 'Aún no he leido ese libro';

                listadoReviews.appendChild(noReviews);
            }
        }

        function seleccionarReview(e) {
            const slug = e.currentTarget.dataset.reviewSlug;
            window.location.href = `/review?slug=${slug}`;
        }
    }
})();