<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/nuevo-proyecto">
            <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
            <input type="submit" value="Crear Proyecto">
        </form>
    </div> <!--Cierre de contenedor-sm-->


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>