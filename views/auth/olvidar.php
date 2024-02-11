<div class="contenedor olvidar">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso a Uptask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>


        <form class="formulario" method="POST" action="/olvidar" novalidate>
            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" placeholder="Tu E-Mail">
            </div>

            <input type="submit" class="boton" value="Confirmar">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una Cuenta? Crea una</a>
            <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
        </div>
    </div>
</div>