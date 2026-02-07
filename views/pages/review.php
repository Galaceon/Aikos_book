<main class="article">
    <h2 class="article__title"><?php echo $review->title; ?></h2>

    <div class="article__grid">
        <section class="article__section">
            <div class="article__date grid-top-left article__every-section">
                <div class="article__day"><?php echo date('d', strtotime($review->created_at)); ?></div>
                <div class="article__year"><?php echo date('M-Y', strtotime($review->created_at)); ?></div>
            </div>

            <div class="grid-bottom-left article__every-section">
                <div class="article__section-title-contenedor">
                    <span class="dashboard__sidebar-icon material-symbols-outlined">sell</span>
                    <h5 class="article__section-titles">TAGS</h5>
                </div>

                <div class="article__section-contenedor">
                    <?php foreach($reviewTags as $tag) { ?>
                        <li class="admin-formulario__filtro-DOM"><?php echo $tag->name; ?></li>
                    <?php } ?>
                </div>
            </div>

            <div class="grid-bottom-right article__every-section">
                <div class="article__section-title-contenedor">
                    <span class="dashboard__sidebar-icon material-symbols-outlined">article_person</span>
                    <h5 class="article__section-titles">AUTORES</h5>
                </div>
                
                <div class="article__section-contenedor">
                    <?php foreach($reviewAuthors as $author) { ?>
                        <li class="admin-formulario__filtro-DOM"><?php echo $author->name; ?></li>
                    <?php } ?>
                </div>
            </div>

            <div class="grid-top-right article__every-section">
                <div class="article__section-title-contenedor">
                    <span class="dashboard__sidebar-icon material-symbols-outlined">star_rate</span>
                    <h5 class="article__section-titles">VALORACIÓN</h5>
                </div>
                <div class="article__section-rating"><?php echo $review->rating; ?></div>
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
            <span class="material-symbols-outlined">calendar_today</span>
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
                        <span class="material-symbols-outlined">arrow_back</span>
                        Ver <p class="personal-info__quit"> reseña </p> anterior
                    </div>
                </a>
            <?php } ?>

            <?php if($reviewSiguiente) { ?>
                <a href="/review?slug=<?php echo $reviewSiguiente->slug; ?>">
                    <div class="personal-info__arrows">
                        Ver <p class="personal-info__quit"> reseña </p> siguiente
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</section>