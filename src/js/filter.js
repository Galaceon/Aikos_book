(function() {
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
        });
    }
})();