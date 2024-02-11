<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Models\Usuarios;

class LoginController{

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarios = new Usuarios($_POST);

            $alertas = $usuarios->validarLogin();

            if(empty($alertas)){
                // Validar que el usuario exista.
                $usuarios = Usuarios::where('email', $usuarios->email);

                if(!$usuarios || !$usuarios->confirmado){
                    Usuarios::setAlerta('error', 'El Usuario no Existe o no está Confirmado');
                } else{
                    // El usuario existe
                    if(password_verify($_POST['password'], $usuarios->password)){
                        session_start();
                        $_SESSION['id'] = $usuarios->id;
                        $_SESSION['nombre'] = $usuarios->nombre;
                        $_SESSION['email'] = $usuarios->email;
                        $_SESSION['login'] = true;

                        header('Location: /dashboard');
                    } else{
                        Usuarios::setAlerta('error', 'Clave Invalida');
                    }
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/login', ['titulo' => 'Iniciar Sesión', 'alertas' => $alertas]);
    }


    public static function logout(){
        session_start();
        $_SESSION = [];

        header('Location: /');

    }


    public static function crear(Router $router){

        $usuarios = new Usuarios;
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarios->sincronizar($_POST);
            $alertas = $usuarios->validarCuenta();

            if(empty($alertas)){
                $existeUsuario = Usuarios::where('email', $usuarios->email);

                if($existeUsuario){
                    Usuarios::setAlerta('error', 'Este Usuario ya Existe');
                    $alertas = Usuarios::getAlertas();
                } else{
                    // Hashear el password del usuario.
                    $usuarios->hashPassword();

                    // Eliminar password2.
                    unset($usuarios->password2); // NG - 1.

                    // Crear token.
                    $usuarios->crearToken();

                    // Crear un nuevo usuario.
                    $resultado = $usuarios->guardar();

                    // Enviar Email.
                    $email = new Email($usuarios->nombre, $usuarios->email, $usuarios->token);
                    $email->enviarConfirmacion();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                    
                }
            }
        }

        $router->render('auth/crear', ['titulo' => 'Crea tu Cuenta', 'usuarios' => $usuarios, 'alertas' => $alertas]);
    }


    public static function olvidar(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarios = new Usuarios($_POST);
            $alertas = $usuarios->validarEmail();

            if(empty($alertas)){
                // Buscar usuario
                $usuarios = Usuarios::where('email', $usuarios->email);

                if($usuarios && $usuarios->confirmado){
                    // Generar un nuevo token.
                    $usuarios->crearToken();
                    unset($usuarios->password2);

                    // Actualizar usuario.
                    $usuarios->guardar();

                    // Enviar Email.
                    $email = new Email($usuarios->nombre, $usuarios->email, $usuarios->token);
                    $email->enviarInstrucciones();
                    
                    // Imprimir alerta
                    Usuarios::setAlerta('exito', 'Hemos enviado las instrucciones para recuperar tu cuenta a tu E-Mail');

                } else{
                    Usuarios::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/olvidar', ['titulo' => 'Reestablece tu Clave', 'alertas' => $alertas]);
    }


    public static function reestablecer(Router $router){

        $alertas = [];
        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token){
            header('Location: /');
        }

        // Identificar al usuario por su token
        $usuarios = Usuarios::where('token', $token);

        if(empty($usuarios)){
            Usuarios::setAlerta('error', 'Token no Válido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            // Añadir el nuevo password.
            $usuarios->sincronizar($_POST);

            // Validar el password.
            $alertas = $usuarios->validarPassword();

            if(empty($alertas)){
                // Hashear el nuevo password.
                $usuarios->hashPassword();
                unset($usuarios->password2);

                // Eliminar el token generado.
                $usuarios->token = null;

                // Guardar el nuevo password en la BD.
                $resultado = $usuarios->guardar();

                // Redireccionar.
                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas = Usuarios::getAlertas();

        $router->render('auth/reestablecer', ['titulo' => 'Reestablecer Clave', 'alertas' => $alertas, 'mostrar' => $mostrar]);
    }


    public static function mensaje(Router $router){
        $router->render('auth/mensaje', ['titulo' => 'Confirma tu cuenta']);
    }


    public static function confirmar(Router $router){

        $token = $_GET['token'];

        if(!$token){
            header('Location: /');
        }

        // Encontrar al usuario con este Token.

        $usuarios = Usuarios::where('token', $token);

        if(empty($usuarios)){
            // No se encontro ningun usuario con ese token
            Usuarios::setAlerta('error', 'Token no Válido');
        } else{
            // Confirmar la cuenta
            $usuarios->confirmado = 1;
            $usuarios->token = null;
            unset($usuarios->password2);

            // Guardar en la BD
            $usuarios->guardar();

            Usuarios::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = Usuarios::getAlertas();


        $router->render('auth/confirmar', ['titulo' => 'Cuenta Confirmada', 'alertas' => $alertas]);

    }
}


/** NOTAS GENERALES
 * 
 * 1.- unset() Destruye una o más variables especificadas. En el caso de la funcion crear, eliminamos password2 dado que no necesitamos que se muestre al momento
 * de guardar la informacion del usuario.
*/

