<div class="auth">
    <form class="auth-formulario">
        <div class="auth-formulario__contenedor">
            <h2 class="auth__heading">AIKO'S BOOK</h2>
            <p class="auth__descripcion">Iniciar Sesión en Aiko's Book</p>

            <?php require_once __DIR__ . '/../templates/alerts.php' ;?>

            <div class="formulario__input">
                <label for="email">EMAIL</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon">
                        alternate_email
                    </span>
                    <input type="email" id="email" placeholder="Tu email..." name="email" value=""/>
                </div>
            </div>

            <div class="formulario__input">
                <label for="password">CONTRASEÑA</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon">
                        lock
                    </span>
                    <input type="password" id="password" placeholder="Tu contraseña..." name="password" value=""/>
                </div>
            </div>

            <input type="submit" value="Crear Cuenta" class="formulario__submit" />

            <div class="acciones">
                <a class="acciones__enlace" href="/register">Crear Cuenta</a>
                <a class="acciones__enlace" href="/forget">¿Olvidaste tu Contraseña?</a>
            </div>
        </div>
    </form>
</div>