(function() {
    const ratingInput = document.querySelector('#rating');
    if(ratingInput) {
        const ratingValor = document.querySelector('#rating-valor');

        ratingInput.addEventListener('input', () => {
            ratingValor.textContent = ratingInput.value;
        });
    }
})();


