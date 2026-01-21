<div class="auth">
    <form class="auth-formulario" form class="auth-formulario" method="POST" action="/forget">
        <div class="auth-formulario__contenedor">
            <h2 class="auth__heading">AIKO'S BOOK</h2>
            <p class="auth__descripcion">Escribe tu email para recuperar tu Cuenta</p>

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

            <input type="submit" value="Enviar Instrucciones" class="formulario__submit" />

            <div class="acciones">
                <a class="acciones__enlace" href="/login">Iniciar Sesión</a>
                <a class="acciones__enlace" href="/register">Crear Cuenta</a>
            </div>
        </div>
    </form>
</div>