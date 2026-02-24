<div class="auth">
    <form class="auth-formulario" method="POST" action="/register">
        <div class="auth-formulario__contenedor">
            <h2 class="auth__heading">AIKO'S BOOK</h2>
            <p class="auth__descripcion">Crear tu cuenta en Sesión en Aiko's Book</p>

            <?php require_once __DIR__ . '/../templates/alerts.php' ;?>

            <div class="formulario__input">
                <label for="nombre">NOMBRE</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon" translate="no">
                        person
                    </span>
                    <input type="text" id="nombre" placeholder="Tu nombre..." name="name" value="<?php echo $user->name; ?>"/>
                </div>
            </div>

            <div class="formulario__input">
                <label for="apellido">APELLIDO</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon" translate="no">
                        person
                    </span>
                    <input type="text" id="apellido" placeholder="Tu apellido..." name="surname" value="<?php echo $user->surname; ?>"/>
                </div>
            </div>

            <div class="formulario__input">
                <label for="email">EMAIL</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon" translate="no">
                        alternate_email
                    </span>
                    <input type="email" id="email" placeholder="Tu email..." name="email" value="<?php echo $user->email; ?>"/>
                </div>
            </div>

            <div class="formulario__input">
                <label for="password">CONTRASEÑA</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon" translate="no">
                        lock
                    </span>
                    <input type="password" id="password" placeholder="Tu contraseña..." name="password" value=""/>
                </div>
            </div>

            <div class="formulario__input">
                <label for="password2">REPETIR CONTRASEÑA</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon" translate="no">
                        lock
                    </span>
                    <input type="password" id="password2" placeholder="Repite tu contraseña..." name="password2" value=""/>
                </div>
            </div>

            <input type="submit" value="Crear Cuenta" class="formulario__submit" />

            <div class="acciones">
                <a class="acciones__enlace" href="/login">Iniciar Sesión</a>
                <a class="acciones__enlace" href="/forget">¿Olvidaste tu Contraseña?</a>
            </div>
        </div>
    </form>
</div>