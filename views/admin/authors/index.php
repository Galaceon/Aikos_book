<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Administra y edita los autores creados.</p>
    </div>

    <a href="/admin/authors/create">
        <div class="dashboard__button">
            <span class="material-symbols-outlined">add</span>
            <p class="dashboard__add-button">Añadir Autor</p>
        </div>
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($authors)) { ?>
        <table class="table">

            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">NOMBRE</th>
                    <th scope="col" class="table__th">ACCIONES</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($authors as $author) { ?>
                    <tr class="table__tr">
                        <td class="table__td table__td--first"><?php echo $author->name; ?></td>
                        <td class="table__td--acciones">
                            <a href="/admin/authors/edit" class="">
                                <span class="material-symbols-outlined accion__editar">edit</span>
                            </a>
                            <form action="/admin/authors/delete" method="POST" class="table__delete-form">
                                <input type="hidden" name="id" value="<?php echo $author->id; ?>">
                                <button class="table__accion table__accion--aliminar" type="submit">
                                    <span class="material-symbols-outlined accion__eliminar">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    <?php } else { ?>
        <p class="text-center">Aun no hay Autores</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>