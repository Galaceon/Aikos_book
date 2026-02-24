<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Administra y edita los tags creados.</p>
    </div>

    <a href="/admin/tags/create">
        <div class="dashboard__button">
            <span class="material-symbols-outlined" translate="no">add</span>
            <p class="dashboard__add-button">Añadir Tag</p>
        </div>
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($tags)) { ?>
        <table class="table">

            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">NOMBRE</th>
                    <th scope="col" class="table__th">ACCIONES</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($tags as $tag) { ?>
                    <tr class="table__tr">
                        <td class="table__td table__td--first"><?php echo $tag->name; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/tags/edit?id=<?php echo $tag->id; ?>" class="">
                                <span class="material-symbols-outlined accion__editar" translate="no">edit</span>
                            </a>
                            <form action="/admin/tags/delete" method="POST" class="table__delete-form">
                                <input type="hidden" name="id" value="<?php echo $tag->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <span class="material-symbols-outlined accion__eliminar" translate="no">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    <?php } else { ?>
        <p class="text-center">Aun no hay Tags</p>
    <?php } ?>
</div>


<div class="dashboard__contenedor--mobile">
    <?php if(!empty($tags)) { ?>
        <?php foreach($tags as $tag) { ?>
            <div class="mobile-list">
                <div class="mobile-list__head">
                    <div class="mobile-list__title"><?php echo $tag->name; ?></div>
                    <div class="mobile-list__acciones">
                        <a href="/admin/tags/edit?id=<?php echo $tag->id; ?>" class="">
                            <span class="material-symbols-outlined accion__editar" translate="no">edit</span>
                        </a>
                        <form action="/admin/tags/delete" method="POST" class="table__delete-form">
                            <input type="hidden" name="id" value="<?php echo $tag->id; ?>">
                            <button class="table__accion table__accion--eliminar" type="submit">
                                <span class="material-symbols-outlined accion__eliminar" translate="no">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-center">Aun no hay Reseñas</p>
    <?php } ?> 
</div>

<?php echo $paginacion; ?>