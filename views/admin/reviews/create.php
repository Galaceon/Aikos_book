<div class="dashboard__formularios-contenido">
    <div class="dashboard__contenedor-header dashboard__contenedor-header--form">
        <a href="/admin/reviews">
            <div class="dashboard__button dashboard__button--round">
                <span class="material-symbols-outlined">arrow_back</span>
            </div>
        </a>

        <div class="dashboard__encabezado">
            <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
            <p class="dashboard__text">Añade una nueva reseña a tu blog.</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../templates/alerts.php' ;?>

    <div class="dashboard__formulario">
        <form action="/admin/reviews/create" class="admin-formulario" method="POST">
            <div class="admin-formulario__campo">
                <label for="nombre" class="admin-formulario__label">Titulo de la Publicación</label>
                <input class="admin-formulario__input" type="text" id="nombre" name="title" placeholder="Nombre Reseña..." value="<?php echo $reseña->title; ?>"/>
            </div>

            <div class="admin-formulario__filtros">

                <div class="admin-formulario__campo--filtros">
                    <label for="tags" class="admin-formulario__label">Añade o crea Tags</label>
                    <div class="admin-formulario__filtro">
                        <input class="admin-formulario__search-field" type="text" id="tags" name="tag" placeholder="Escribe tags..." value="<?php echo $tag->title; ?>"/>
                        <button type="button" class="admin-formulario__add-button" id="btn-crear-tag">+</button>
                    </div>

                    <ul id="listado-tags" class="listado-tags">
                    </ul>

                    <div class="admin-formulario__contenedor-tags" id="admin-formulario__contenedor-tags">
                        
                    </div>
                </div>

                <div class="admin-formulario__campo--filtros">
                    <label for="authors" class="admin-formulario__label">Añade o crea Autores</label>
                    <div class="admin-formulario__filtro">
                        <input class="admin-formulario__search-field" type="text" id="authors" name="authors" placeholder="Escribe autores..." value="<?php echo $author->title; ?>"/>
                        <button type="button" class="admin-formulario__add-button" id="btn-crear-author">+</button>
                    </div>
                    
                    <div class="admin-formulario__contenedor-authors" id="admin-formulario__contenedor-authors">
                        
                    </div>
                </div>

            </div>

            <input type="submit" value="Crear Reseña" class="formulario__submit admin-formulario__submit" />
            <input type="hidden" name="tags" id="tags-hidden">
        </form>
    </div>
</div>