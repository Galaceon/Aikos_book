 <div class="barra">
    <div class="barra__contenido">

        <!-- LOGOTIPO -->
        <a href="/" class="barra__enlace" data-value="AIKO'S BOOK">
            <div class="barra__logotipo">
                <span class="barra__logo material-symbols-outlined">auto_stories</span>
                <h2 class="barra__titulo">AIKO'S BOOK</h2>
            </div>
        </a>

        <!-- BUSCADORES -->
        <div class="barra__buscadores">
            <!-- BUSCADOR -->
            <div class="barra__buscador">
                <span class="barra__search-img material-symbols-outlined">search</span>
                <input class="barra__input" id="buscador" type="text" placeholder="Buscar reseña...">
            </div> 

            <!-- FILTROS -->
            <div class="barra__filtros">
                Filtros
                <span class="barra__symbol material-symbols-outlined">keyboard_arrow_down</span>
            </div>
        </div>

        <!-- NAVEGACION -->
        <nav class="barra__nav">
            <?php if(is_auth()) { ?>
                <a href="/profile">
                    <div class="barra__nav-enlaces">
                        <span class="barra__search-img material-symbols-outlined">frame_person</span>
                        <p class="barra__nav-text">PERFIL</p>
                    </div>
                </a>
                <?php  if(is_admin()) { ?>
                    <a href="/admin/dashboard">
                        <div class="barra__nav-enlaces barra__nav-enlaces-admin">
                            <span class="material-symbols-outlined">view_list</span>
                            <p class="barra__nav-text">ADMINISTRAR</p>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="/">
                        <div class="barra__nav-enlaces">
                            <span class="barra__search-img material-symbols-outlined">bookmarks</span>
                            <p class="barra__nav-text">GUARDADOS</p>
                        </div>
                    </a>
                <?php } ?>

                <div class="barra__nav-enlaces">
                    <form method="POST" action="/logout" class="barra__form">
                        <label for="cerrar_sesion" class="barra__label"><span class="barra__search-img material-symbols-outlined">logout</span></label>
                        <input id="cerrar_sesion" type="submit" value="LOGOUT" class="barra__submit">
                    </form>
                </div>
            <?php } else { ?>

                <a href="/login" class="barra__login">
                    <div class="barra__nav-enlaces">
                        <span class="barra__search-img material-symbols-outlined">login</span>
                        <p class="barra__nav-text barra__nav-text--login">LOGIN</p>
                    </div>
                </a>

            <?php } ?>

        </nav>

        <!-- DARKMODE BUTTON -->
        <div class="barra__darkmode">
            <div class="barra__darkmode-contenedor">
                <span class="material-symbols-outlined">brightness_4</span>
            </div>
        </div>


        <!-- MOBILE MENU BUTTON -->
        <button class="barra__mobile-button">
            <svg viewBox="0 0 64 48">
                <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
            </svg>
        </button>

        <!-- MOBILE MENU -->
        <aside class="barra__mobile-menu">

            <!-- BUSCADORES -->
            <div class="barra__buscadores--mobile">
                <!-- BUSCADOR -->
                <div class="barra__buscador barra__buscador--mobile">
                    <span class="barra__search-img material-symbols-outlined">search</span>
                    <input class="barra__input--mobile" id="buscador" type="text" placeholder="Buscar reseña...">
                </div> 

                <!-- FILTROS -->
                <div class="barra__filtros--mobile">
                    Filtros
                    <span class="barra__symbol material-symbols-outlined">keyboard_arrow_down</span>
                </div>
            </div>


            <!-- NAVEGACION -->
            <nav class="barra__nav--mobile">
                <?php if(is_auth()) { ?>
                    <?php if(is_admin()) { ?>
                        <a href="/">
                            <div class="barra__nav-enlaces--mobile">
                                <span class="barra__search-img--mobile material-symbols-outlined">frame_person</span>
                                <p class="barra__nav-text-mobile">PERFIL</p>
                            </div>
                        </a>

                        <a href="/admin/dashboard">
                            <div class="barra__nav-enlaces--mobile">
                                <span class="barra__search-img--mobile material-symbols-outlined">view_list</span>
                                <p class="barra__nav-text-mobile">ADMINISTRAR</p>
                            </div>
                        </a>

                        <div class="barra__nav-enlaces--mobile">
                            <form method="POST" action="/logout" class="barra__form">
                                <label for="cerrar_sesion" class="barra__label"><span class="barra__search-img--mobile material-symbols-outlined">login</span></label>
                                <input id="cerrar_sesion" type="submit" value="LOGOUT" class="barra__submit--mobile">
                            </form>
                        </div>
                    <?php } else { ?>
                        <a href="/">
                            <div class="barra__nav-enlaces--mobile">
                                <span class="barra__search-img--mobile material-symbols-outlined">frame_person</span>
                                <p class="barra__nav-text-mobile">PERFIL</p>
                            </div>
                        </a>

                        <a href="/">
                            <div class="barra__nav-enlaces--mobile">
                                <span class="barra__search-img--mobile material-symbols-outlined">bookmarks</span>
                                <p class="barra__nav-text-mobile">GUARDADOS</p>
                            </div>
                        </a>

                        <div class="barra__nav-enlaces--mobile">
                            <form method="POST" action="/logout" class="barra__form">
                                <label for="cerrar_sesion" class="barra__label"><span class="barra__search-img--mobile material-symbols-outlined">login</span></label>
                                <input id="cerrar_sesion" type="submit" value="LOGOUT" class="barra__submit--mobile">
                            </form>
                        </div>
                    <?php } ?>
                <?php } else { ?>

                    <a href="/login">
                        <div class="barra__nav-enlaces--mobile">
                            <span class="barra__search-img--mobile material-symbols-outlined">login</span>
                            <p class="barra__nav-text-mobile">LOGIN</p>
                        </div>
                    </a>

                <?php } ?>
            </nav>


            <!-- DARKMODE BUTTON -->
            <div class="barra__darkmode--mobile">
                <div class="barra__darkmode-contenedor--mobile">
                    <span class="material-symbols-outlined">brightness_4</span>
                </div>
            </div>
        </aside>
        <!-- MOBILE MENU -->
    </div>
</div>


<!-- HEADER IMAGE -->
<header class="header">
    <div class="header__contenido">
        <h1 class="header__titulo">AIKO'S BOOK</h1>
        <h3 class="header__descripcion">Reseñas literarias de Laura Ruiz</h3>
    </div>
</header>