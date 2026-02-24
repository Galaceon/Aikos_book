<div class="dashboard__formularios-contenido">
    <div class="dashboard__contenedor-header dashboard__contenedor-header--form">
        <a href="/admin/tags">
            <div class="dashboard__button dashboard__button--round">
                <span class="material-symbols-outlined" translate="no">arrow_back</span>
            </div>
        </a>

        <div class="dashboard__encabezado">
            <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
            <p class="dashboard__text">Añade un nuevo tag para tus reseñas.</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../templates/alerts.php' ;?>

    <div class="dashboard__formulario">
        <form action="/admin/tags/create" class="admin-formulario" method="POST">
            <div class="admin-formulario__campo">
                <label for="nombre" class="admin-formulario__label">Nombre del Tag</label>
                <input class="admin-formulario__input" type="text" id="nombre" name="name" placeholder="Nombre Tag..." value="<?php echo $tag->name; ?>"/>
            </div>

            <input type="submit" value="Añadir Tag" class="formulario__submit admin-formulario__submit" />
        </form>
    </div>
</div>
