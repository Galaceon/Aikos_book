<div class="dashboard__formularios-contenido">
    <div class="dashboard__contenedor-header dashboard__contenedor-header--form">
        <a href="/admin/reviews">
            <div class="dashboard__button dashboard__button--round">
                <span class="material-symbols-outlined">arrow_back</span>
            </div>
        </a>

        <div class="dashboard__encabezado">
            <h2 class="dashboard__heading"><?php echo $titulo; ?></h2>
            <p class="dashboard__text">Edita tus reseñas para que se actualicen en la página principal.</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../templates/alerts.php' ;?>

    <div class="dashboard__formulario">
        <form class="admin-formulario" method="POST" enctype="multipart/form-data">
            <?php include_once __DIR__ . '/form.php'; ?>
        </form>
    </div>
</div>

<script>
    window.tagsReview = <?php echo json_encode($reviewTags); ?>;
    window.authorsReview = <?php echo json_encode($reviewAuthors); ?>;
</script>