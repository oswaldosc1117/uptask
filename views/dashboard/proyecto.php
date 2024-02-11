<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva Tarea</button>
        </div> <!--Cierre de contenedor-nueva-tarea-->

        <div id="filtros" class="filtros">
            <h2>Filtra tus Tareas</h2>
            <div class="filtros-inputs">
                <div class="campo">
                    <label for="todas">Todas</label>
                    <input type="radio" id="todas" name="filtro" value="" checked>
                </div>

                <div class="campo">
                    <label for="completadas">Completadas</label>
                    <input type="radio" id="completadas" name="filtro" value="1">
                </div>

                <div class="campo">
                    <label for="pendientes">Pendientes</label>
                    <input type="radio" id="pendientes" name="filtro" value="0">
                </div>
            </div>
        </div>
        <ul id="listado-tareas" class="listado-tareas"></ul>
    </div> <!--Cierre de contenedor-sm-->


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
<?php $script .= '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/tareas.js"></script>';
?>

