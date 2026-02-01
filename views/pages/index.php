<main class="reviews">
    <h2 class="reviews__title">Últimas Reseñas</h2>
    <div class="reviews__grid">
        <?php if(!empty($reviews)) { ?>
            
            <?php foreach($reviews as $review) { ?>
                <article class="review">
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

                    <div class="review__information">
                        <div class="review__main-info">
                            <div class="review__head">
                                <h4 class="review__title"><?php echo $review->title; ?></h4>
                                
                                <div class="review__rating">
                                    <?php echo $review->rating; ?>
                                    <span class="material-symbols-outlined">star_rate</span>
                                </div>
                                
                            </div>
                            

                            <p class="review__content">tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal. Nose que mas poner lokte illu. tal y tal y tal.</p>
                        </div>
                    

                        <div class="review__foot">
                            <div class="review__social">
                                <div class="review__likes">
                                    <span class="material-symbols-outlined">favorite</span>
                                    12
                                </div>
                                <div class="review__comments">
                                    <span class="material-symbols-outlined">comment</span>
                                    8
                                </div>
                            </div>

                            <div class="review__date"><?php echo date('d-m-Y', strtotime($review->created_at)); ?></div>
                        </div>
                    </div>
                </article>

            <?php } ?>
        <?php } else { ?>
            <p class="reviews__no-article">Aun no hay reseñas</p>
        <?php } ?>
    </div>
</main>