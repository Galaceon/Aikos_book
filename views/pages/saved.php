<main class="reviews">
    <h2 class="reviews__title"><?php echo $titulo; ?></h2>
    <div class="reviews__grid">
        <?php if(!empty($reviews)) { ?>
            <?php foreach($reviews as $review) { ?>
                <?php $isLiked = !empty($likedReviews[$review->id]); ?>
                <article class="review fold-corner">
                    <div class="review__image-contenedor">
                        <a href="review?slug=<?php echo $review->slug; ?>">
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
                        </a>
                    </div>

                    <div class="review__information">
                        <div class="review__main-info">
                            <div class="review__head">
                                <a href="review?slug=<?php echo $review->slug; ?>">
                                    <h4 class="review__title"><?php echo $review->title; ?></h4>
                                </a>
                                
                                <div class="review__rating">
                                    <?php echo $review->rating; ?>
                                    <span class="material-symbols-outlined" translate="no">star_rate</span>
                                </div>
                                
                            </div>
                            
                            <div class="review__content">
                                <p class="review__text"><?php echo strip_tags($review->content); ?></p>
                            </div>
                        </div>
                    

                        <div class="review__foot">
                            <div class="review__social">
                                <div class="review__likes">
                                    <?php $isLiked = !empty($likedReviews[$review->id]); ?>
                                    <button class="review__like-button <?php echo $isLiked ? 'liked' : ''; ?>" data-review-id="<?php echo $review->id; ?>">
                                        <span class="material-symbols-outlined" translate="no">
                                            <?php echo $isLiked ? 'favorite' : 'favorite_border'; ?>
                                        </span>
                                        <span class="review__like-count">
                                            <?php echo $likesCount[$review->id]; ?>
                                        </span>
                                    </button>
                                </div>
                                <div class="review__comments">
                                    <span class="material-symbols-outlined" translate="no">comment</span>
                                    0
                                </div>
                            </div>

                            <div class="review__date"><?php echo date('d-m-Y', strtotime($review->created_at)); ?></div>
                        </div>
                    </div>
                    <?php if(is_auth()) {
                        $isSaved = is_auth() && !empty($savedReviews[$review->id]);
                    ?>

                        <button class="review__save-button <?php echo $isSaved ? 'saved' : ''; ?>" data-review-id="<?php echo $review->id; ?>">
                            <span class="material-symbols-outlined" translate="no">
                                <?php echo $isSaved ? 'bookmark_added' : 'bookmark'; ?>
                            </span>
                        </button>
                    <?php } ?>
                </article>
            <?php } ?>
        <?php } else { ?>
            <p class="reviews__no-article">Aun no hay reseñas guardadas</p>
        <?php } ?>
    </div>

    <?php echo $paginacion; ?>
</main>