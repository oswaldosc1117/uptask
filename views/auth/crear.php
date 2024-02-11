<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/crear">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($usuarios->nombre); ?>">
            </div>
            
            <div class="campo">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido" value="<?php echo s($usuarios->apellido); ?>">
            </div>

            <div class="campo">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" placeholder="Tu E-Mail" value="<?php echo s($usuarios->email); ?>">
            </div>

            <div class="campo">
                <label for="password">Clave</label>
                <input type="password" id="password" name="password" placeholder="Tu Contraseña">
            </div>

            <div class="campo">
                <label for="password2">Confirmar Clave</label>
                <input type="password" id="password2" name="password2" placeholder="Introduce nuevamente tu Contraseña">
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una Cuenta? Inicia Sesión</a>
            <a href="/olvidar">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
</div>