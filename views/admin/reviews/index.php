<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Administra y edita las críticas literarias publicadas.</p>
    </div>

    <a href="/admin/reviews/create">
        <div class="dashboard__button">
            <span class="material-symbols-outlined">add</span>
            <p class="dashboard__add-button">Añadir <span class="dashboard__add-button--span">Reseña<span></p>
        </div>
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($reviews)) { ?>
        <table class="table">

            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">TÍTULO</th>
                    <th scope="col" class="table__th">PUBLICACIÓN</th>
                    <th scope="col" class="table__th">NOTA</th>
                    <th scope="col" class="table__th">ACCIONES</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($reviews as $review) { ?>
                    <tr class="table__tr">
                        <td class="table__td table__td--first"><?php echo $review->title; ?></td>
                        <td class="table__td table__td--first"><?php echo date('d-m-Y', strtotime($review->created_at)); ?></td>
                        <td class="table__td table__td--first"><?php echo $review->rating; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/reviews/edit?id=<?php echo $review->id; ?>" class="">
                                <span class="material-symbols-outlined accion__editar">edit</span>
                            </a>
                            <form action="/admin/reviews/delete" method="POST" class="table__delete-form">
                                <input type="hidden" name="id" value="<?php echo $review->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <span class="material-symbols-outlined accion__eliminar">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    <?php } else { ?>
        <p class="text-center">Aun no hay Reseñas</p>
    <?php } ?>
</div>

<div class="dashboard__contenedor--mobile">
    <?php if(!empty($reviews)) { ?>
    <?php foreach($reviews as $review) { ?>
        <div class="mobile-list">
            <div class="mobile-list__head">
                <div class="mobile-list__title"><?php echo $review->title; ?></div>
                <div class="mobile-list__acciones">
                    <a href="/admin/reviews/edit?id=<?php echo $review->id; ?>" class="">
                        <span class="material-symbols-outlined accion__editar">edit</span>
                    </a>
                    <form action="/admin/reviews/delete" method="POST" class="table__delete-form">
                        <input type="hidden" name="id" value="<?php echo $review->id; ?>">
                        <button class="table__accion table__accion--eliminar" type="submit">
                            <span class="material-symbols-outlined accion__eliminar">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="mobile-list__foot">
                <div class="mobile-list__date">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <?php echo date('d-m-Y', strtotime($review->created_at)); ?>
                </div>
                <div class="mobile-list__rating">
                    <?php echo $review->rating; ?>
                    <span class="material-symbols-outlined">star_rate</span>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-center">Aun no hay Reseñas</p>
    <?php } ?> 
</div>

<?php echo $paginacion; ?>