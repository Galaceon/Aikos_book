<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Revisa las últimas actualizaciones de tu blog.</p>
    </div>
</div>

<div class="bloques__grid">

    <div class="bloque">
        <h3 class="bloque__title">Últimos Registros</h3>

        <?php if(!empty($ultimosUsuarios)) : ?>
            <ul class="bloque__lista">
                <?php foreach($ultimosUsuarios as $usuario) : ?>
                    <li class="bloque__item">
                        <?php echo htmlspecialchars($usuario->name) . " " . htmlspecialchars($usuario->surname); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay registros aún.</p>
        <?php endif; ?>
    </div>


    <div class="bloque">
        <h3 class="bloque__title">Reseñas Totales</h3>
        <p class="bloque__numero"><?php echo $totalReviews; ?></p>
    </div>

    <div class="bloque">
        <h3 class="bloque__title">Likes Totales</h3>
        <p class="bloque__numero"><?php echo $totalLikes; ?></p>
    </div>

    <div class="bloque">
        <h3 class="bloque__title">Autores Leídos</h3>
        <p class="bloque__numero"><?php echo $totalAutores; ?></p>
    </div>

</div>