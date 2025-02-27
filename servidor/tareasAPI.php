<?php

require_once "TareasDB.php";

class TareasAPI {

    public function API() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        
        switch ($method) {
            case 'GET':
                $this->procesaListar();
                break;
            case 'POST':
                $this->procesaGuardar();
                break;
            case 'PUT':
                $this->procesaActualizar();
                break;
            case 'DELETE':
                $this->procesaEliminar();
                break;
            default:
                $this->response(405, "error", "Método no permitido");
                break;
        }
    }

    function response($code, $status, $message) {
        http_response_code($code);
        echo json_encode(["status" => $status, "message" => $message], JSON_PRETTY_PRINT);
    }

    function procesaListar() {
        if ($_GET['action'] == 'tareas') {
            $tareasDB = new TareasDB();
            if (isset($_GET['id'])) {
                $response = $tareasDB->dameUnoPorId($_GET['id']);
                echo json_encode($response, JSON_PRETTY_PRINT);
            } else {
                $response = $tareasDB->dameLista();
                echo json_encode($response, JSON_PRETTY_PRINT);
            }
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaGuardar() {
        if ($_GET['action'] == 'tareas') {
            $obj = json_decode(file_get_contents('php://input'));
            if (!$obj || !isset($obj->titulo)) {
                $this->response(422, "error", "Datos incorrectos o incompletos");
                return;
            }
            $tareasDB = new TareasDB();
            $tareasDB->guarda($obj->titulo, $obj->descripcion, $obj->prioridad);
            $this->response(201, "success", "Registro agregado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaActualizar() {
        if ($_GET['action'] == 'tareas' && isset($_GET['id'])) {
            $obj = json_decode(file_get_contents('php://input'));
            if (!$obj || !isset($obj->titulo)) {
                $this->response(422, "error", "Datos incorrectos o incompletos");
                return;
            }
            $tareasDB = new TareasDB();
            $tareasDB->actualiza($_GET['id'], $obj->titulo, $obj->descripcion, $obj->prioridad);
            $this->response(200, "success", "Registro actualizado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }

    function procesaEliminar() {
        if ($_GET['action'] == 'tareas' && isset($_GET['id'])) {
            $tareasDB = new TareasDB();
            $tareasDB->elimina($_GET['id']);
            $this->response(200, "success", "Registro eliminado");
        } else {
            $this->response(400, "error", "Acción no válida");
        }
    }
}

$api = new TareasAPI();
$api->API();
