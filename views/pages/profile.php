<main class="profile">
    <form method="POST" enctype="multipart/form-data">
        <div class="profile__grid">

            <?php require_once __DIR__ . '/../templates/alerts.php' ;?>

            <div class="profile__avatar">
                <label for="avatar" class="profile-avatar__label">
                    <img
                        id="avatar-preview"
                        src="/img/users/<?php echo $user->image;?>.webp"
                        alt="Foto de perfil"
                    >
                    <span class="profile-avatar__overlay">Cambiar</span>
                </label>

                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    accept="image/*"
                    hidden
                >
            </div>
            <div class="profile__name"><?php echo $user->name . " " . $user->surname; ?></div>
            <div class="profile__description">
                <div class="profile__desp-head">
                    <div class="profile__titles">DESCRIPCIÓN</div>
                    <label class="profile__desp-label" for="edit-desp-button"><span class="material-symbols-outlined" translate="no">edit_note</span>EDITAR</label>
                </div>
                <textarea name="description" id="edit-desp-button" class="profile__desp-contenedor" maxlength="120" placeholder="Escribe tu descripción..."><?php echo $user->description; ?></textarea>
            </div>
            <div class="profile__info-separator">
                <div class="profile__email">
                    <div class="profile__titles">CORREO ELECTRÓNICO</div>
                    <div class="profile__info"><?php echo $user->email; ?></div>
                </div>
                <div class="profile__creation">
                    <div class="profile__titles">MIEMBRO DESDE</div>
                    <div class="profile__info"><?php echo date('d-m-Y', strtotime($user->created_at)); ?></div>
                </div>
            </div>
            <input class="profile__save" type="submit" value="Guardar Cambios">
        </div>
    </form>
</main>