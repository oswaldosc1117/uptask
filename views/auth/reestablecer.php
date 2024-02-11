<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Introduce tu nueva Clave</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        
        <?php if($mostrar): ?>
            <form class="formulario" method="POST">
                <div class="campo">
                    <label for="password">Clave</label>
                    <input type="password" id="password" name="password" placeholder="Tu Contraseña">
                </div>

                <div class="campo">
                    <label for="password2">Confirmar Clave</label>
                    <input type="password" id="password2" name="password2" placeholder="Introduce nuevamente tu Contraseña">
                </div>

                <input type="submit" class="boton" value="Reestablecer">
            </form>
        <?php endif; ?>

        <div class="acciones">
            <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
            <a href="/olvidar">¿Olvidaste tu Contraseña?</a>
        </div>




    </div>
</div>