
const mobileMenuBoton = document.querySelector('#mobile-menu');
const cerrarMenuBoton = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');

if(mobileMenuBoton){
    mobileMenuBoton.addEventListener('click', function(){
        sidebar.classList.add('mostrar');
        // sidebar.classList.toggle('mostrar'); // NG - 1.
    })
}

if(cerrarMenuBoton){
    cerrarMenuBoton.addEventListener('click', function(){
        sidebar.classList.add('ocultar');
        setTimeout(() => {
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');
        }, 500);
    })
}

// Eliminar la clase de 'mostrar' para dispositivos tablets o mayores.
const anchoPantalla = document.body.clientWidth;

window.addEventListener('resize', function(){
    const anchoPantalla = document.body.clientWidth;

    if(anchoPantalla >= 768){
        sidebar.classList.remove('mostrar');
    }
})



/** NOTAS GENERALES
 * 
 * 1.- El método toggle() de la interfaz DOMTokenList elimina un token existente de la lista y devuelve falso. Si el token no existe, se agrega y la función
 * devuelve verdadero. Para fines del ejercicio, como está asociado a un evento de tipo 'click', cada vez que ocurra este evento, agregara o quitara la clase
 * dependiendo sea el caso.
*/