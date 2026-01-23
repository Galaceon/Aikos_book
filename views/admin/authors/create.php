<div class="dashboard__formularios-contenido">
    <div class="dashboard__contenedor-header dashboard__contenedor-header--form">
        <a href="/admin/authors">
            <div class="dashboard__button dashboard__button--round">
                <span class="material-symbols-outlined">arrow_back</span>
            </div>
        </a>

        <div class="dashboard__encabezado">
            <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
            <p class="dashboard__text">Administra y edita los autores creados.</p>
        </div>
    </div>

    <div class="dashboard__formulario">
        <form action="admin/authors/create" class="admin-formulario">
            <div class="admin-formulario__campo">
                <label for="nombre" class="admin-formulario__label">Nombre del Autor</label>
                <input class="admin-formulario__input" type="text" id="nombre" name="name" placeholder="Nombre Autor..." value=""/>
            </div>

            <input type="submit" value="Añadir Autor" class="formulario__submit admin-formulario__submit" />
        </form>
    </div>
</div>
