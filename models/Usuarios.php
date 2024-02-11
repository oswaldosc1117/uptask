<?php

namespace Models;

class Usuarios extends ActiveRecord{

    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $contraseña_actual;
    public $contraseña_nueva;
    public $contraseña_confirmar;
    public $token;
    public $confirmado;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->contraseña_actual = $args['contraseña_actual'] ?? '';
        $this->contraseña_nueva = $args['contraseña_nueva'] ?? '';
        $this->contraseña_confirmar = $args['contraseña_confirmar'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }


    // Validacion del inicio de sesion.
    public function validarLogin() : array{
        if(!$this->email && !$this->password){
            self::$alertas['error'][] = 'Los campos están vacíos';
        } else{    
            if(!$this->email){
                self::$alertas['error'][] = 'Introduce tu E-Mail para iniciar sesión';
            } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'E-Mail no válido';
            }

            if(!$this->password){
                self::$alertas['error'][] = 'Introduce tu Contraseña para iniciar sesión';
            } elseif(strlen($this->password) < 6){
                self::$alertas['error'][] = 'La contraseña debe tener un minimo de 6 caracteres';
            }
        }

        return self::$alertas;
    }

    // Validacion para cuentas nuevas.
    public function validarCuenta() : array{

        if(!$this->nombre && !$this->apellido && !$this->email && !$this->password){
            self::$alertas['error'][] = 'Debes llenar el formulario para Crear tu Cuenta';
        } else{
            if(!$this->nombre){
                self::$alertas['error'][] = 'El Nombre es Obligatorio';
            }
    
            if(!$this->apellido){
                self::$alertas['error'][] = 'El Apellido es Obligatorio';
            }
    
            if(!$this->email){
                self::$alertas['error'][] = 'El E-Mail es Obligatorio';
            }

            if(!$this->password){
                self::$alertas['error'][] = 'La Contraseña es Obligatoria';
            } elseif(strlen($this->password) < 6){
                self::$alertas['error'][] = 'La contraseña debe tener un minimo de 6 caracteres';
            } elseif($this->password && !$this->password2){
                self::$alertas['error'][] = 'Debes Confirmar tu Contraseña';
            } elseif($this->password !== $this->password2){
                self::$alertas['error'][] = 'Las contraseñas son diferentes';
            }
        }

        return self::$alertas;
    }


    // Validar Email.
    public function validarEmail() : array{
        if(!$this->email){
            self::$alertas['error'][] = 'El E-Mail es Obligatorio para recuperar tu cuenta';
        } elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'E-Mail no válido';
        }

        return self::$alertas;
    }


    // Validar el Password.
    public function validarPassword() : array{
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        } elseif(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener un minimo de 6 caracteres';
        } elseif($this->password && !$this->password2){
            self::$alertas['error'][] = 'Debes Confirmar tu Contraseña';
        } elseif($this->password !== $this->password2){
            self::$alertas['error'][] = 'Las contraseñas son diferentes';
        }

        return self::$alertas;
    }


    // Validar los cambios en el perfil del usuario.
    public function validarPerfil() : array{

        if(!$this->nombre && !$this->email){
            self::$alertas['error'][] = 'Los campos no pueden estar vacíos';
        } else{
            if(!$this->nombre){
                self::$alertas['error'][] = 'El Nombre es Obligatorio';
            }
            
            if(!$this->email){
                self::$alertas['error'][] = 'El E-mail es Obligatorio';
            }
        }

        return self::$alertas;
    }


    // Cambiar el Password del usuario.
    public function nuevoPassword() : array{
        if(!$this->contraseña_actual && !$this->contraseña_nueva && !$this->contraseña_confirmar){
            self::$alertas['error'][] = 'Los campos no pueden estar vacíos';
        } else{
            if(!$this->contraseña_actual){
                self::$alertas['error'][] = 'Debes introducir tu Contraseña Actual';
            } elseif(!$this->contraseña_nueva){
                self::$alertas['error'][] = 'Debes introducir una Nueva Contraseña';
            } elseif(strlen($this->contraseña_nueva) < 6){
                self::$alertas['error'][] = 'La Nueva Contraseña no puede tener menos de 6 caracteres';
            } elseif($this->contraseña_nueva && !$this->contraseña_confirmar){
                self::$alertas['error'][] = 'Debes Confirmar la Nueva Contraseña';
            } elseif($this->contraseña_nueva !== $this->contraseña_confirmar){
                self::$alertas['error'][] = 'Las contraseñas son diferentes';
            }
        }

        return self::$alertas;
    }


    // Comprobar Password.
    public function comprobarPassword() : bool{
        return password_verify($this->contraseña_actual, $this->password);
    }


    // Hash al Password.
    public function hashPassword() : void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    // Crear un token.
    public function crearToken() : void{
        $this->token = md5(uniqid());
    }
}