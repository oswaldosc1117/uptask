
(function(){ // NG - 1.

    obtenerTareas()
    let tareas = []; // Variable global.
    let filtradas = []; // Variable global.

    // Boton para mostrar el Modal de agregar tarea.
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function(){
        mostrarFormulario();
    });


    // Filtros de busqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"]');
    filtros.forEach(radio =>{
        radio.addEventListener('input', filtrarTareas);
    });


    function filtrarTareas(e){
        const filtro = e.target.value;

        if(filtro !== ''){
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } else{
            filtradas = [];
        }

        mostrarTareas();
    }

    async function obtenerTareas(){
        try {
            const url = obtenerProyecto();
            const direccion = `/api/tareas?url=${url}`;
            const respuesta = await fetch(direccion);
            const resultado = await respuesta.json();

            tareas = resultado.tareas;
            mostrarTareas();

        } catch (error) {
            console.log(error);
        }
    }


    function mostrarTareas(){
        limpiarTareas();
        totalTareasPendientes();
        totalTareasCompletas();

        const arrayTareas = filtradas.length ? filtradas : tareas;

        if(arrayTareas.length === 0){
            const contenedorTareas = document.querySelector('#listado-tareas');
            const noTareas = document.createElement('LI');
            noTareas.textContent = 'No hay Tareas en este Proyecto';
            noTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(noTareas);
            return;
        };

        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }
        arrayTareas.forEach(tarea => {
            const contenedorTareas = document.createElement('LI');
            contenedorTareas.dataset.tareaID = tarea.id;
            contenedorTareas.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function(){
                mostrarFormulario(editar = true, {...tarea});
            }

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const botonEstadoTarea = document.createElement('BUTTON');
            botonEstadoTarea.classList.add('estado-tarea');
            botonEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`); // NG - 7.
            botonEstadoTarea.textContent = estados[tarea.estado];
            botonEstadoTarea.dataset.estadoTarea = tarea.estado;
            botonEstadoTarea.onclick = function(){
                cambiarEstadoTarea({...tarea});
            }

            const botonEliminarTarea = document.createElement('BUTTON');
            botonEliminarTarea.classList.add('eliminar-tarea');
            botonEliminarTarea.dataset.tareaID = tarea.id;
            botonEliminarTarea.textContent = 'Eliminar';
            botonEliminarTarea.onclick = function(){
                confirmarEliminarTarea({...tarea});
            }

            opcionesDiv.appendChild(botonEstadoTarea);
            opcionesDiv.appendChild(botonEliminarTarea);

            contenedorTareas.appendChild(nombreTarea);
            contenedorTareas.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTareas);
        });
    }


    function totalTareasPendientes(){
        const pendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendientesRadio = document.querySelector('#pendientes');

        if(pendientes.length === 0){
            pendientesRadio.disabled = true;
        } else{
            pendientesRadio.disabled = false;
        }
    }


    function totalTareasCompletas(){
        const completas = tareas.filter(tarea => tarea.estado === "1");
        const completasRadio = document.querySelector('#completadas');

        if(completas.length === 0){
            completasRadio.disabled = true;
        } else{
            completasRadio.disabled = false;
        }
    }


    function mostrarFormulario(editar = false, tarea = {}){
        console.log(tarea);
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Tarea' : 'Añade una Nueva Tarea'}</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input type="text"
                    name="tarea"
                    placeholder="${tarea.nombre ? 'Edita la Tarea' : 'Añadir Tarea al Proyecto Actual'}"
                    id="tarea" value="${tarea.nombre ? tarea.nombre : ''}"/>
                </div>

                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="${tarea.nombre ? 'Guardar Cambios' : 'Añadir Tarea'}"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>`;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click', function(e){
            e.preventDefault();

            if(e.target.classList.contains('cerrar-modal')){
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');

                setTimeout(() => {
                    modal.remove();
                }, 1000);
            };

            if(e.target.classList.contains('submit-nueva-tarea')){
                const nombreTarea = document.querySelector('#tarea').value.trim(); // NG - 2.
                if(nombreTarea === ''){
                    // Mostrar una alerta de error.
                    mostrarAlerta('El Nombre de la Tarea es Obligatorio', 'error', document.querySelector('.formulario legend'));
                    return;
                };

                if(editar){
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                } else{
                    agregarTarea(nombreTarea);
                }
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }


    // Mostrar un mensaje en la interfaz.
    function mostrarAlerta(mensaje, tipo, referencia){

        // Prevenir la creacion de multiples alertas.
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia){
            alertaPrevia.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        // Insertar la alerta antes del legend.
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling); // NG - 3, 4 y 5.

        // Eliminar la alerta despues de 4 segundos.
        setTimeout(() => {
            alerta.remove();
        }, 4000);
    }


    // Consultar al servidor para añadir una nueva tarea al proyecto actual.
    async function agregarTarea(tarea){

        // Construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoID', obtenerProyecto());

        try {
            const url = '/api/tarea';
            const respuesta = await fetch(url, {
               method: 'POST',
               body: datos 
            });

            const resultado = await respuesta.json();
            console.log(resultado);

            // Mostrar una alerta de error.
            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

            if(resultado.tipo === 'exito'){
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                    // window.location.reload(); // NG - 6.
                }, 3000);

                // Agregar el objeto de tareas al global de tareas.
                const tareasObjeto = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: '0',
                    proyectoID: resultado.proyectoID
                }

                tareas = [...tareas, tareasObjeto];
                mostrarTareas();
            }

        } catch (error) {
            console.log(error); 
        }
    }


    function cambiarEstadoTarea(tarea){

        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;

        actualizarTarea(tarea);
    }


    async function actualizarTarea(tarea){
        const {estado, id, nombre, proyectoID} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoID', obtenerProyecto());

        // for(let valor of datos.values()){
        //     console.log(valor);
        // } // Forma de comprobar que los datos en el formData se esten seleccionando correctamente.

        try {
            const url = '/api/tarea/actualizar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            // console.log(resultado);
            
            if(resultado.respuesta.tipo === 'exito'){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: resultado.respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });

                const modal = document.querySelector('.modal');
                if(modal){
                    modal.remove();
                }

                tareas = tareas.map(tareaMemoria => { // NG - 8.
                    if(tareaMemoria.id === id){
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }
    
                    return tareaMemoria;
                });
    
                mostrarTareas();
            };
        } catch (error) {
            console.log(error);
        }
    }


    function confirmarEliminarTarea(tarea){
        Swal.fire({
            title: "¿Deseas Eliminar esta Tarea?",
            text: "Esta acción no podrá ser revertida",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#a90000",
            cancelButtonColor: "#2563EB",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed){
                eliminarTarea(tarea);
                
                Swal.fire({
                    title: "Eliminada",
                    text: "Tu tarea ha sido Eliminada",
                    icon: "success"
                });
            }
        });
    }


    async function eliminarTarea(tarea){
        
        const {estado, id, nombre} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoID', obtenerProyecto());

        try {
            const url = '/api/tarea/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            
            tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);
            mostrarTareas();
            
        } catch (error) {
            console.log(error);
        }
    }


    function obtenerProyecto(){
        const proyectParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectParams.entries());
        return proyecto.url;
    }


    function limpiarTareas(){
        const listadoTareas = document.querySelector('#listado-tareas');

        while(listadoTareas.firstChild){
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }





})() // IIFE (Immediately Invoked Function Expression) NG - 1.


/** NOTAS GENERALES
 * 
 * 1.- Las expresiones de función ejecutadas inmediatamente (IIFE por su sigla en inglés) son funciones que se ejecutan tan pronto como se definen. Es un patrón
 * de diseño también conocido cómo función autoejecutable y se compone por dos partes. La primera es la función anónima con alcance léxico encerrado por el
 * Operador de Agrupación (). Esto impide accesar variables fuera del IIFE, así cómo contaminar el alcance (scope) global. La segunda parte crea la expresión de
 * función cuya ejecución es inmediata (), siendo interpretado directamente en el engine de JavaScript.
 * 
 * 2.- El método trim( ) elimina los espacios en blanco en ambos extremos del string. Los espacios en blanco en este contexto, son todos los caracteres sin
 * contenido (espacio, tabulación, etc.).
 * 
 * 3.- El método Node.insertBefore() inserta un nodo antes del nodo de referencia como hijo de un nodo padre indicado. Si el nodo hijo es una referencia a un nodo
 * ya existente en el documento, insertBefore() lo mueve de la posición actual a la nueva posición (no hay necesidad de eliminar el nodo de su nodo padre antes de
 * agregarlo al algún nodo nuevo).
 * 
 * 4.- La propiedad de sólo lectura NonDocumentTypeChildNode.nextElementSibling devuelve el elemento inmediatamente posterior al especificado, dentro de la lista de
 * elementos hijos de su padre, o bien null si el elemento especificado es el último en dicha lista.
 * 
 * 5.- La propiedad de Nodo.parentElement devuelve el nodo padre del DOM Element, o null, si el nodo no tiene padre o si el padre no es un Element DOM.
 * 
 * 6.- El metodo location.reload() carga de nuevo la URL actual, como lo hace el boton de Refresh de los navegadores.
 * 
 * 7.- El método toLowerCase() devuelve el valor en minúsculas de la cadena que realiza la llamada.
 * 
 * 8.- El método map() crea un nuevo array con los resultados de la llamada a la función indicada aplicados a cada uno de sus elementos.
 */

