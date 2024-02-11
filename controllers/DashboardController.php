<?php

namespace Controllers;

use Models\Proyecto;
use Models\Usuarios;
use MVC\Router;

class dashboardController{

    public static function index(Router $router){

        session_start();
        isAuth();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioID', $id);


        $router->render('dashboard/index', ['titulo' => 'Mis Proyectos', 'proyectos' => $proyectos]);
    }


    public static function nuevoProyecto(Router $router){

        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);
            
            // Validar las alertas.
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                // Generar una URL unica.
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar al creador del proyecto.
                $proyecto->propietarioID = $_SESSION['id'];

                // Guardar el proyecto.
                $proyecto->guardar();

                // Redireccionar.
                header('Location: /proyecto?url=' . $proyecto->url); // NG - 1.
            }
        }

        $router->render('dashboard/nuevo-proyecto', ['titulo' => 'Nuevo Proyecto', 'alertas' => $alertas]);
    }


    public static function proyecto(Router $router){

        session_start();
        isAuth();

        $token = $_GET['url'];
        if(!$token){
            header('Location: /dashboard');
        }

        // Revisar que la persona que visita el proyecto, es quien lo creo.
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioID !== $_SESSION['id']){
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', ['titulo' => $proyecto->proyecto]);
    }


    public static function perfil(Router $router){

        isSession();
        isAuth();
        $alertas = [];

        $usuario = Usuarios::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if(empty($alertas)){

                $existeUsuario = Usuarios::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    // Mensaje de error.
                    Usuarios::setAlerta('error', 'El Email ya existe');
                    $alertas = $usuario->getAlertas();
                } else{
                    // Guardar los cambios en el perfil de usuario.
                    $usuario->guardar();

                    Usuarios::setAlerta('exito', 'Cambios Guardados Correctamente');
                    $alertas = $usuario->getAlertas();

                    // Asignar el nuevo nombre de usuario a la barra.
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }

        $router->render('dashboard/perfil', ['titulo' => 'Perfil', 'usuario' => $usuario, 'alertas' => $alertas]);
    }


    public static function cambiarPassword(Router $router){
        isSession();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario = Usuarios::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevoPassword();

            if(empty($alertas)){
                $resultado = $usuario->comprobarPassword();

                if($resultado){
                    // Asignar el nuevo password.
                    $usuario->password = $usuario->contraseña_nueva;

                    // Eliminar propiedades innecesarias.
                    unset($usuario->contraseña_actual);
                    unset($usuario->contraseña_nueva);
                    unset($usuario->contraseña_confirmar);

                    // Hashear el nuevo password.
                    $usuario->hashPassword();

                    // Actualizar.
                    $resultado = $usuario->guardar();

                    if($resultado){
                    // Mensaje de exito.
                    Usuarios::setAlerta('exito', 'Contraseña Actualizada Correctamente');
                    $alertas = Usuarios::getAlertas();
                    }

                } else{
                    // Mensaje de error.
                    Usuarios::setAlerta('error', 'Contraseña Actual Incorrecta');
                    $alertas = Usuarios::getAlertas();
                }
            }

            // debuguear($usuario);
        }

        $router->render('dashboard/cambiar-password', ['titulo' => 'Cambiar Contraseña', 'alertas' => $alertas]);
    }
}

/** NOTAS GENERALES
 * 
 * 1.- puedo cambiar la inicial de la URL con el termino que mejor se ajuste a las necesidades. Anteriormente hemos empleado enlaces como: /proyecto?id=(id a usar)
 * porque han sido justamente para eso, para llamar el numero de un determinado usuario, producto o servicio. Sin embargo, como esta vez lo que se desea es generar
 * una URL para almacenar la informacion de cierto proyecto, se cambio la sintaxis a /proyecto?url=(url generada aleatoriamente).
*/