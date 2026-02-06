<main class="profile">
    <div class="profile__grid">
        <div class="profile__avatar">
            <label for="avatar" class="profile-avatar__label">
                <img
                    id="avatar-preview"
                    src="/img/users/<?php echo $user->image;?>.jpg"
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
                <label class="profile__desp-label" for="edit-desp-button"><span class="material-symbols-outlined">edit_note</span>EDITAR</label>
            </div>
            <textarea id="edit-desp-button" class="profile__desp-contenedor" maxlength="120" placeholder="Escribe tu descripción..."><?php echo $user->description; ?></textarea>
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
        <div class="profile__save">
            <span class="material-symbols-outlined">save</span>
            <p>Guardar Cambios</p>
        </div>
    </div>
</main>