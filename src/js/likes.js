(function() {
    document.addEventListener('click', async e => {
        const likeBtn = e.target.closest('.review__like-button');
        if(!likeBtn) return;

        const reviewId = likeBtn.dataset.reviewId;

        const formData = new FormData();
        formData.append('review_id', reviewId);

        const response = await fetch('/api/likes', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if(data['tipo'] === 'error') { 
            mostrarAlerta(data['mensaje'], data['tipo'], document.querySelector(`.review__title[data-review-id="${data.id}"]`))
            return;
        };

        likeBtn.classList.toggle('liked', data.liked);
        likeBtn.querySelector('.material-symbols-outlined').textContent =
            data.liked ? 'favorite' : 'favorite_border';

        likeBtn.querySelector('.review__like-count').textContent = data.total;
    });


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
        }, 4000)
    }
})();