(function () {
    const abrirMenu = document.querySelector('.barra__mobile-button');
    const menu = document.querySelector('.barra__mobile-menu');

    // Responsive Sidebar for normal users
    if (abrirMenu) {
        abrirMenu.addEventListener('click', () => {
            // Estado del sidebar(oculto o mostrandose)
            const menuState = menu.classList.value.includes('mostrar');

            if(menuState) {
                menu.classList.remove('mostrar');
                document.body.classList.add('menu-abierto');
            } else {
                menu.classList.add('mostrar');
                document.body.classList.add('menu-abierto');
            }
        });
    }

    window.addEventListener('resize', () => {
        // Estado del boton hamburguesa
        const abrirMenuState = abrirMenu.classList.value.includes('active');

        // Si la pantalla es mayot o igual a tablet el menu mobile se oculta y el boton hamburguesa se queda en X
        if (window.innerWidth >= 768) {
            menu.classList.remove('mostrar');
            document.body.classList.remove('menu-abierto');

            if(abrirMenuState) {
                abrirMenu.classList.remove('active');
            }
        }
    });


    // Hamburger button animation
    document.querySelectorAll('.barra__mobile-button').forEach(btn => {
        btn.addEventListener('click', e => {
            btn.classList.toggle('active');
        });
    });
})();
