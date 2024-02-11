<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/" novalidate>
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" placeholder="Tu E-Mail">
            </div>

            <div class="campo">
                <label for="password">Clave</label>
                <input type="password" id="password" name="password" placeholder="Tu Contraseña">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una Cuenta? Crea una</a>
            <a href="/olvidar">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
</div>