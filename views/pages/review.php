<main class="article">
    <h2 class="article__title"><?php echo $review->title; ?></h2>

    <div class="article__grid">
        <section class="article__section">
            <div class="article__top-section">
                <div class="article__top-left article__section-single">
                    <?php echo date('d-M-Y', strtotime($review->created_at)); ?>
                </div>
                <div class="article__top-right article__section-single">
                    <span class="dashboard__sidebar-icon material-symbols-outlined" translate="no">star_rate</span>
                    <h5 class="article__section-titles">VALORACIÓN</h5>

                    <div class="article__section-rating"><?php echo $review->rating; ?></div>
                </div>
            </div>
            <div class="article__bottom-section">
                <div class="article__bottom-left article__section-single">
                    <span class="dashboard__sidebar-icon material-symbols-outlined" translate="no">sell</span>
                    <h5 class="article__section-titles">TAGS</h5>

                    <div class="article__section-contenedor">
                        <?php foreach($reviewTags as $tag) { ?>
                            <li class="admin-formulario__filtro-DOM"><?php echo $tag->name; ?></li>
                        <?php } ?>
                    </div>
                </div>
                <div class="article__bottom-right article__section-single">
                    <span class="dashboard__sidebar-icon material-symbols-outlined" translate="no">article_person</span>
                    <h5 class="article__section-titles">AUTORES</h5>
                    <div class="article__section-contenedor">
                        <?php foreach($reviewAuthors as $author) { ?>
                            <li class="admin-formulario__filtro-DOM"><?php echo $author->name; ?></li>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
            
        <article class="article__content">
            <div class="article__image-contenedor">
                <picture>
                    <source srcset="<?php echo BASE_URL; ?>/img/reviews/<?php echo $review->image; ?>.webp" type="image/webp">
                    <source srcset="<?php echo BASE_URL; ?>/img/reviews/<?php echo $review->image; ?>.png" type="image/png">
                    <img
                        class="review__image" 
                        loading="lazy" 
                        width="200" 
                        height="300" 
                        src="<?php echo BASE_URL; ?>/img/reviews/<?php echo $review->image; ?>.png" 
                        alt="Imagen Review"
                    >
                </picture>
            </div>

            <div class="article__text"><?php echo $review->content; ?></div> 
        </article>
    </div>
</main>

<section class="personal-info">
    <div class="personal-info__head">
        <div class="personal-info__image">
            <img
                src="/img/users/<?php echo $admin->image;?>.webp"
                alt="Foto del administador"
            >
        </div>
        <div class="personal-info__informacion">
            <h4 class="personal-info__name"><?php echo $admin->name . " " . $admin->surname ;?></h4>
            <p class="personal-info__description"><?php echo $admin->description; ?></p>
        </div>
    </div>

    <div class="personal-info__reviews">
        <div class="personal-info__date">
            <span class="material-symbols-outlined" translate="no">calendar_today</span>
            <div class="personal-info__date-text">
                Publicado el <?php echo date('d', strtotime($review->created_at)). " de " . date('M', strtotime($review->created_at)) . " de " . date('Y', strtotime($review->created_at)); ?></div>
        </div>
            
        <div class="personal-info__tags">
            <?php foreach($reviewTags as $tag) { ?>
                <li class="admin-formulario__filtro-DOM"><?php echo $tag->name; ?></li>
            <?php } ?>
        </div>

        <div class="personal-info__change">
            <?php if($reviewAnterior) { ?>
                <a href="/review?slug=<?php echo $reviewAnterior->slug; ?>">
                    <div class="personal-info__arrows">
                        <span class="material-symbols-outlined" translate="no">arrow_back</span>
                        Ver <p class="personal-info__quit"> reseña </p> anterior
                    </div>
                </a>
            <?php } ?>

            <?php if($reviewSiguiente) { ?>
                <a href="/review?slug=<?php echo $reviewSiguiente->slug; ?>">
                    <div class="personal-info__arrows">
                        Ver <p class="personal-info__quit"> reseña </p> siguiente
                        <span class="material-symbols-outlined" translate="no">arrow_forward</span>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</section>

<section class="comments">

    <h3>Comentarios</h3>

    <?php if(!empty($alertas['error'])): ?>
        <?php foreach($alertas['error'] as $error): ?>
            <div class="alerta alerta__error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(is_auth()) { ?>

        <form method="POST" action="/comment/create" class="comment-form" id="comment-form">

            <input type="hidden" name="review_id" value="<?php echo $review->id; ?>">

            <input type="hidden" name="parent_id" value="" id="parent_id">

            <textarea 
                name="content" 
                placeholder="Escribe tu comentario..."
                required
            ></textarea>

            <button type="submit" class="comments__button">
                Publicar comentario
            </button>

        </form>

    <?php } else { ?>
    <p class="comments__no-session">Debes iniciar sesión para comentar.</p>

<?php } ?>


    <?php if(!empty($comentarios)) { ?>

        <?php foreach($comentarios as $comentario) { ?>

            <div class="comment">

                <div class="comment__header">
                    <div class="comment__user">
                        <img 
                            src="/img/users/<?php echo htmlspecialchars($comentario->usuario->image); ?>.webp" 
                            alt="Foto de <?php echo htmlspecialchars($comentario->usuario->name); ?>"
                            class="comment__user-image"
                        >
                        <span class="comment__user-name">
                            <?php echo htmlspecialchars($comentario->usuario->name . ' ' . $comentario->usuario->surname); ?>
                        </span>
                    </div>
                </div>

                <p class="comment__content">
                    <?php echo htmlspecialchars($comentario->content); ?>
                </p>

                <small class="comment__date">
                    Publicado el 
                    <?php echo date('d/m/Y H:i', strtotime($comentario->created_at)); ?>
                </small>

                <?php if(is_auth()) { ?>
                    <button 
                        class="comment__reply-btn" 
                        data-comment-id="<?php echo $comentario->id; ?>">
                        Responder
                    </button>
                <?php } ?>


                <?php if(!empty($comentario->respuestas)) { ?>
                    <div class="comment__responses">
                        <?php foreach($comentario->respuestas as $respuesta) { ?>

                            <div class="comment comment--response">
                                <div class="comment__header">
                                    <div class="comment__user">
                                        <img 
                                            src="/img/users/<?php echo htmlspecialchars($respuesta->usuario->image); ?>.webp" 
                                            alt="Foto de <?php echo htmlspecialchars($respuesta->usuario->name); ?>"
                                            class="comment__user-image"
                                        >
                                        <span class="comment__user-name">
                                            <?php echo htmlspecialchars($respuesta->usuario->name . ' ' . $respuesta->usuario->surname); ?>
                                        </span>
                                    </div>
                                </div>

                                <p class="comment__content-response">
                                    <?php echo htmlspecialchars($respuesta->content); ?>
                                </p>

                                <small>
                                    <?php echo date('d/m/Y H:i', strtotime($respuesta->created_at)); ?>
                                </small>
                                
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

        <?php } ?>

    <?php } else { ?>
        <p>No hay comentarios todavía.</p>
    <?php } ?>
</section>