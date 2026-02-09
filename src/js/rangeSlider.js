(function() {
    const ratingInput = document.querySelector('#rating');
    if(ratingInput) {
        if(!ratingInput) return;

        const ratingValor = document.querySelector('#rating-valor');

        ratingInput.addEventListener('input', () => {
            ratingValor.textContent = ratingInput.value;
        });
    }
})();


