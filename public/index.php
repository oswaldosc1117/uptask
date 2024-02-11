<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareasController;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Crear cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

// Formulario en caso de que el usuario haya olvidado su password
$router->get('/olvidar', [LoginController::class, 'olvidar']);
$router->post('/olvidar', [LoginController::class, 'olvidar']);

// Formulario para introducir el nuevo password
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

// Confirmacion de la cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);


// Zona de Proyectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/nuevo-proyecto', [DashboardController::class, 'nuevoProyecto']);
$router->post('/nuevo-proyecto', [DashboardController::class, 'nuevoProyecto']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiarPassword']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiarPassword']);

// API para las tareas
$router->get('/api/tareas', [TareasController::class, 'index']);
$router->post('/api/tarea', [TareasController::class, 'crear']);
$router->post('/api/tarea/actualizar', [TareasController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TareasController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();