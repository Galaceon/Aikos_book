(function () {
    const abrirMenu = document.querySelector('.barra__mobile-button');
    const abrirMenuAdmin = document.querySelector('.dashboard__mobile-button');

    const menu = document.querySelector('.barra__mobile-menu');
    const menuAdmin = document.querySelector('.dashboard__sidebar--mobile');

    if (abrirMenu) {
        if(!abrirMenu) return;
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

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                menu.classList.remove('mostrar');
                document.body.classList.remove('menu-abierto');
                abrirMenu.classList.remove('active');
            }
        });
    }

    if(abrirMenuAdmin) {
        if(!abrirMenuAdmin) return;
        abrirMenuAdmin.addEventListener('click', () => {
        
        const menuState = menuAdmin.classList.contains('mostrar');

        if (menuState) {
            menuAdmin.classList.remove('mostrar');
            document.body.classList.remove('menu-abierto');
        } else {
            menuAdmin.classList.add('mostrar');
            document.body.classList.add('menu-abierto');
        }

        abrirMenuAdmin.classList.toggle('active');
    });
    }

    window.addEventListener('resize', () => {
        if (!menuAdmin || !abrirMenuAdmin) return;

        if (window.innerWidth >= 768) {
            menuAdmin.classList.remove('mostrar');
            document.body.classList.remove('menu-abierto');
            abrirMenuAdmin.classList.remove('active');
        }
    });
})();

