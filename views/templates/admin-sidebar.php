<aside class="dashboard__sidebar">
    <a href="/admin/dashboard" class="dashboard__enlace <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">dashboard</span>
        <p class="dashboard__sidebar-text">DASHBOARD</p>
    </a>

    <a href="/admin/reviews" class="dashboard__enlace <?php echo pagina_actual('/reviews') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">reviews</span>
        <p class="dashboard__sidebar-text">RESEÑAS</p>
    </a>

    <a href="/admin/tags" class="dashboard__enlace <?php echo pagina_actual('/tags') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">sell</span>
        <p class="dashboard__sidebar-text">TAGS</p>
    </a>

    <a href="/admin/authors" class="dashboard__enlace <?php echo pagina_actual('/authors') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">article_person</span>
        <p class="dashboard__sidebar-text">AUTORES</p>
    </a>

    <a href="/admin/users" class="dashboard__enlace <?php echo pagina_actual('/users') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">groups</span>
        <p class="dashboard__sidebar-text">REGISTRADOS</p>
    </a>
</aside>

<aside class="dashboard__sidebar--mobile">
    <a href="/admin/dashboard" class="dashboard__enlace <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">dashboard</span>
        <p class="dashboard__sidebar-text">DASHBOARD</p>
    </a>

    <a href="/admin/reviews" class="dashboard__enlace <?php echo pagina_actual('/reviews') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">reviews</span>
        <p class="dashboard__sidebar-text">RESEÑAS</p>
    </a>

    <a href="/admin/tags" class="dashboard__enlace <?php echo pagina_actual('/tags') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">sell</span>
        <p class="dashboard__sidebar-text">TAGS</p>
    </a>

    <a href="/admin/authors" class="dashboard__enlace <?php echo pagina_actual('/authors') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">article_person</span>
        <p class="dashboard__sidebar-text">AUTORES</p>
    </a>

    <a href="/admin/users" class="dashboard__enlace <?php echo pagina_actual('/users') ? 'dashboard__enlace-actual' : ''; ?>">
        <span class="dashboard__sidebar-icon material-symbols-outlined">groups</span>
        <p class="dashboard__sidebar-text">REGISTRADOS</p>
    </a>

    <div class="barra__darkmode--mobile">
        <div class="barra__darkmode-contenedor--mobile">
            <span class="material-symbols-outlined">brightness_4</span>
        </div>
    </div>

    <form method="POST" action="/logout" class="dashboard__enlace">
        <label for="cerrar_sesion" class="dashboard__sidebar--mobile__label"><span class="barra__search-img material-symbols-outlined">login</span></label>
        <input id="cerrar_sesion" type="submit" value="LOGOUT" class="dashboard__sidebar--mobile__submit">
    </form>
</aside>