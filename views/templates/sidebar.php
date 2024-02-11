<aside class="sidebar">

    <div class="contenedor-sidebar">

        <h2>UpTask</h2>

        <div class="cerrar-menu">
            <i class="fa-solid fa-xmark icono-cerrar-mobile" id="cerrar-menu"></i>
        </div>

    </div>

    <nav class="sidebar-nav">
        <a href="/nuevo-proyecto" class="<?php echo ($titulo === 'Nuevo Proyecto') ? 'activo' : ''; ?>"><i class="fa-solid fa-file-circle-plus"></i></a>
        <a href="/dashboard" class="<?php echo ($titulo === 'Mis Proyectos') ? 'activo' : ''; ?>"><i class="fa-solid fa-file-circle-check"></i></a>
        <a href="/perfil" class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>"><i class="fa-solid fa-user"></i></a>
    </nav>

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>