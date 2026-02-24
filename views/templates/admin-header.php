<div class="dashboard__header">
    <div class="dashboard__header-grid">

        <a href="/" class="dashboard__enlace-principal" data-value="AIKO'S BOOK">
            <div class="dashboard__logotipo">
                <span class="dashboard__logo material-symbols-outlined" translate="no">auto_stories</span>
                <h2 class="dashboard__titulo">AIKO'S BOOK</h2>
            </div>
        </a>

        <div class="dashboard__header-right">
            <div class="dashboard__darkmode">
                <div class="barra__darkmode-contenedor">
                    <span class="material-symbols-outlined" translate="no">brightness_4</span>
                </div>
            </div>

            <nav class="dashboard__nav-enlaces">
                <form method="POST" action="/logout" class="barra__form">
                    <label for="cerrar_sesion" class="barra__label"><span class="barra__search-img material-symbols-outlined" translate="no">login</span></label>
                    <input id="cerrar_sesion" type="submit" value="LOGOUT" class="barra__submit">
                </form>
            </nav>

            <!-- MOBILE MENU BUTTON -->
            <button class="dashboard__mobile-button">
                <svg viewBox="0 0 64 48">
                    <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                    <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                    <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
                </svg>
            </button>

        </div>
    </div>
</div>