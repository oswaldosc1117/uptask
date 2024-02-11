<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo">
            <label for="contraseña">Contraseña Actual</label>
            <input type="password" name="contraseña_actual" placeholder="Tu Contraseña Actual">
        </div>

        <div class="campo">
            <label for="contraseña">Contraseña Nueva</label>
            <input type="password" name="contraseña_nueva" placeholder="Tu Contraseña Nueva">
        </div>

        <div class="campo">
            <label for="contraseña">Confirmar Contraseña</label>
            <input type="password" name="contraseña_confirmar" placeholder="Tu Contraseña Nueva">
        </div>

        <div class="perfil-flex">
            <input type="submit" value="Guardar Cambios">
            <a href="/perfil" class="enlace">Volver</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>