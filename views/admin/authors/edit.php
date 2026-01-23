<div class="dashboard__formularios-contenido">
    <div class="dashboard__contenedor-header dashboard__contenedor-header--form">
        <a href="/admin/authors">
            <div class="dashboard__button dashboard__button--round">
                <span class="material-symbols-outlined">arrow_back</span>
            </div>
        </a>

        <div class="dashboard__encabezado">
            <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
            <p class="dashboard__text">Edita el nombre del autor para que se actualice en tus reseñas.</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../templates/alerts.php' ;?>

    <div class="dashboard__formulario">
        <form class="admin-formulario" method="POST">
            <div class="admin-formulario__campo">
                <label for="nombre" class="admin-formulario__label">Cambia el nombre del Autor</label>
                <input class="admin-formulario__input" type="text" id="nombre" name="name" placeholder="Nuevo Nombre..." value="<?php echo $author->name; ?>"/>
            </div>

            <input type="submit" value="Editar Autor" class="formulario__submit admin-formulario__submit" />
        </form>
    </div>
</div>