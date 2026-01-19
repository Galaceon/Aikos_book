(function () {
    const abrirMenu = document.querySelector('.barra__mobile-button');
    const menu = document.querySelector('.barra__mobile-menu');

    if (abrirMenu) {
        abrirMenu.addEventListener('click', () => {
            const menuState = menu.classList.contains('mostrar');

            if (menuState) {
                menu.classList.remove('mostrar');
                document.body.classList.remove('menu-abierto');
            } else {
                menu.classList.add('mostrar');
                document.body.classList.add('menu-abierto');
            }

            abrirMenu.classList.toggle('active');
        });
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            menu.classList.remove('mostrar');
            document.body.classList.remove('menu-abierto');
            abrirMenu.classList.remove('active');
        }
    });
})();

