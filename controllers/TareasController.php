<?php

namespace Controllers;

use Models\Proyecto;
use Models\Tareas;

class TareasController{

    public static function index(){
        $proyectoID = $_GET['url'];

        if(!$proyectoID) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $proyectoID);
        session_start();

        if(!$proyecto || $proyecto->propietarioID !== $_SESSION['id']) header('Location: /404');

        $tareas = Tareas::belongsTo('proyectoID', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }

    public static function crear(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();

            $proyectoID = $_POST['proyectoID'];
            $proyecto = Proyecto::where('url', $proyectoID);

            if(!$proyecto || $proyecto->propietarioID !== $_SESSION['id']){
                $respuesta = ['tipo' => 'error', 'mensaje' => 'Hubo un error al agregar la tarea'];

                echo json_encode($respuesta);
                return;
            }

            // Si todo esta bien, creamos e instanciamos la tarea.
            $tarea = new Tareas($_POST);
            $tarea->proyectoID = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = ['tipo' => 'exito', 'id' => $resultado['id'], 'mensaje' => 'Tarea Creada Correctamente', 'proyectoID' => $proyecto->id];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();

            // Validar que el proyecto existe.
            $proyectoID = $_POST['proyectoID'];
            $proyecto = Proyecto::where('url', $proyectoID);

            if(!$proyecto || $proyecto->propietarioID !== $_SESSION['id']){
                $respuesta = ['tipo' => 'error', 'mensaje' => 'Hubo un error al actualizar la tarea'];

                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tareas($_POST);
            $tarea->proyectoID = $proyecto->id;

            $resultado = $tarea->guardar();
            if($resultado){
                $respuesta = ['tipo' => 'exito', 'id' => $tarea->id, 'proyectoID' => $proyecto->id, 'mensaje' => 'Actualizado Correctamente'];

                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }

    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();

            // Validar que el proyecto existe.
            $proyectoID = $_POST['proyectoID'];
            $proyecto = Proyecto::where('url', $proyectoID);

            if(!$proyecto || $proyecto->propietarioID !== $_SESSION['id']){
                $respuesta = ['tipo' => 'error', 'mensaje' => 'Hubo un error al actualizar la tarea'];

                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tareas($_POST);
            $resultado = $tarea->eliminar();

            echo json_encode(['resultado' => $resultado]);
        }
    }
}