<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Administra o elimina los usuarios registrados.</p>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($users)) { ?>
        <table class="table">

            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">NOMBRE</th>
                    <th scope="col" class="table__th">EMAIL</th>
                    <th scope="col" class="table__th">CONFIRMADO</th>
                    <th scope="col" class="table__th">REGISTRO</th>
                    <th scope="col" class="table__th">ACCIONES</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($users as $user) { ?>
                    <tr class="table__tr">
                        <td class="table__td table__td--first"><?php echo $user->name . " " . $user->surname; ?></td>
                        <td class="table__td"><?php echo $user->email; ?></td>
                        <td class="table__td"><?php echo $user->confirmed["0"] ? 'Confirmado' : 'No Confirmado'; ?></td>
                        <td class="table__td"><?php echo $user->created_at ?></td>
                        <td class="table__td--acciones">
                            <form action="/admin/users/delete" method="POST" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
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
        <p class="text-center">No hay Usuarios Registrados</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>