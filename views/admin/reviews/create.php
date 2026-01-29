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
        <form action="/admin/reviews/create" class="admin-formulario" method="POST" enctype="multipart/form-data">
            <div class="admin-formulario__campo">
                <label for="nombre" class="admin-formulario__label">Titulo de la Publicación</label>
                <input class="admin-formulario__input" type="text" id="nombre" name="title" placeholder="Nombre Reseña..." value="<?php echo $review->title; ?>"/>
            </div>

            <div class="admin-formulario__filtros">

                <div class="admin-formulario__campo--filtros">
                    <label for="tags" class="admin-formulario__label">Añade o crea Tags</label>
                    <div class="admin-formulario__filtro">
                        <input class="admin-formulario__search-field" type="text" id="tags" name="tag" placeholder="Escribe tags..." value="<?php echo $tag->name; ?>"/>
                        <button type="button" class="admin-formulario__add-button" id="btn-crear-tag">+</button>
                    </div>

                    <ul id="listado-tags" class="listado-filtros"><!-- LISTADO TAGS --></ul>

                    <div class="admin-formulario__contenedor-filtros" id="admin-formulario__contenedor-tags">
                        
                    </div>
                </div>

                <div class="admin-formulario__campo--filtros">
                    <label for="authors" class="admin-formulario__label">Añade o crea Autores</label>
                    <div class="admin-formulario__filtro">
                        <input class="admin-formulario__search-field" type="text" id="authors" name="authors" placeholder="Escribe autores..." value="<?php echo $author->name; ?>"/>
                        <button type="button" class="admin-formulario__add-button" id="btn-crear-author">+</button>
                    </div>

                    <ul id="listado-authors" class="listado-filtros"><!-- LISTADO AUTHORS --></ul>
                    
                    <div class="admin-formulario__contenedor-filtros" id="admin-formulario__contenedor-authors">
                        
                    </div>
                </div>

            </div>

            <div class="admin-formulario__slider">
                <label for="rating" class="admin-formulario__slider__text">Valoración</label>
                <div class="admin-formulario__slider__content">
                    <input
                        type="range"
                        id="rating"
                        name="rating"
                        min="0"
                        max="10"
                        step="0.1"
                        value="5"
                        class="admin-formulario__slider__range"
                    >
                    <div class="admin-formulario__slider__rating">
                        <span id="rating-valor" class="admin-formulario__slider__rate">5.0</span>
                        <span class="material-symbols-outlined">star_rate</span>
                    </div>
                    
                </div>
            </div>


            <div class="admin-formulario__upload">
                <p class="admin-formulario__imagen-head">IMAGEN</p>

                <label class="upload-zone" for="imagen">
                    <p class="upload-zone__text">
                        Arrastra una imagen aquí o <span>haz clic</span>
                    </p>
                    <p class="upload-zone__info">PNG / JPG / WEBP · máx 2MB</p>
                </label>

                <input
                    type="file"
                    id="imagen"
                    name="imagen"
                    accept="image/*"
                    hidden
                >

                <div id="preview-imagen" class="upload-preview"></div>
            </div>

            <div>
                <label for="nombre" class="admin-formulario__label">CONTENIDO</label>
                <textarea id="content" name="content">Hello, World!</textarea>
            </div>

            <input type="submit" value="Crear Reseña" class="formulario__submit admin-formulario__submit" />
            <input type="hidden" name="tags" id="tags-hidden">
            <input type="hidden" name="authors" id="authors-hidden">
        </form>
    </div>
</div>