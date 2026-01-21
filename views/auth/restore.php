<div class="auth--no-style">
    <div class="auth-contenedor">
        <h2 class="auth__heading">Reestablecer Contraseña</h2>
        <p class="auth__descripcion">Coloca tu nueva contraseña</p>

        <?php require_once __DIR__ . '/../templates/alerts.php' ;?>

        <?php if($token_valido) { ?>
        <form class="formulario" class="auth-formulario" method="POST">
            <div class="formulario__input">
                <label for="password">CONTRASEÑA</label>
                <div class="formulario__input-group">
                    <span class="material-symbols-outlined formulario__icon">
                        lock
                    </span>
                    <input type="password" id="password" placeholder="Tu nueva contraseña..." name="password" value=""/>
                </div>
            </div>

            <input type="submit" value="Guardar Contraseña" class="formulario__submit" />

            <div class="acciones">
                <a class="acciones__enlace" href="/login">Iniciar Sesión</a>
                <a class="acciones__enlace" href="/register">Crear Cuenta</a>
            </div>
        </form>
        <?php } ?>

    </div>
</div>