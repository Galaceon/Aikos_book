<div class="dashboard__contenedor-header">
    <div class="dashboard__encabezado">
        <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
        <p class="dashboard__text">Revisa las últimas actualizaciones de tu blog.</p>
    </div>
</div>
<?php require_once __DIR__ . '/../../templates/alerts.php' ;?>
<div class="bloques__grid">
    <div class="bloque">
        <h3 class="bloque__title">Comentarios Totales</h3>
        <p class="bloque__numero"><?php echo $totalComments; ?></p>
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

    <div class="bloque bloque__special-pages">
        <h3 class="bloque__title">Páginas leídas</h3>
        <form action="/admin/dashboard" method="POST">
            <input class="bloque__save-pages" type="submit" value="Guardar" />
            <input class="bloque__total-pages" type="text" name="total_pages" value="<?php echo $allPages; ?>"/>
        </form>
    </div>
</div>