(function () {
    const darkBtn = document.querySelector('.barra__darkmode-contenedor');
    const darkBtnMobile = document.querySelector('.barra__darkmode-contenedor--mobile');

    const DARK_CLASS = 'darkmode';
    const STORAGE_KEY = 'theme';

    // Si hay un tema guardado, aplicarlo
    const savedTheme = localStorage.getItem(STORAGE_KEY);

    // Si el tema guardado es 'dark', aplicar la clase darkmode
    if (savedTheme === 'dark') {
        document.body.classList.add(DARK_CLASS);
    }

    // Añadir evento al botón para alternar el modo oscuro
    if (darkBtn || darkBtnMobile) {
        darkBtn.addEventListener('click', darkmodeActivator);
        darkBtnMobile.addEventListener('click', darkmodeActivator);
    }

    function darkmodeActivator() {
        const isDark = document.body.classList.toggle(DARK_CLASS);

        localStorage.setItem(
            STORAGE_KEY,
            isDark ? 'dark' : 'light'
        );
    }
    
})();
