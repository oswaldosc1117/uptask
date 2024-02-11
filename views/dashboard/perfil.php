<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" value="<?php echo $usuario->nombre; ?>" name="nombre" placeholder="Tu Nombre">
        </div>

        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" value="<?php echo $usuario->email; ?>" name="email" placeholder="Tu E-mail">
        </div>

        <div class="perfil-flex">
            <input type="submit" value="Guardar Cambios">
            <a href="/cambiar-password" class="enlace">Cambiar Contraseña</a>
        </div>

    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>