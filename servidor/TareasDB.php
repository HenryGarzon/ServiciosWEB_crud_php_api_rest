<?php

class TareasDB {

    protected $mysqli;
    
    const LOCALHOST = 'localhost'; 
    const USER = 'root';
    const PASSWORD = 'henry';
    const DATABASE = 'agenda';

    public function __construct() {
        try {
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
            if ($this->mysqli->connect_error) {
                throw new Exception("Error de conexión: " . $this->mysqli->connect_error);
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }

    public function dameUnoPorId($id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM tareas WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tarea = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $tarea;
    }

    public function dameLista() {
        $result = $this->mysqli->query('SELECT * FROM tareas');
        $tareas = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $tareas;
    }

    public function guarda($titulo, $descripcion, $prioridad) {
        $stmt = $this->mysqli->prepare("INSERT INTO tareas(titulo, descripcion, prioridad) VALUES(?, ?, ?)");
        $stmt->bind_param('ssi', $titulo, $descripcion, $prioridad);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }

    public function elimina($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM tareas WHERE id = ?");
        $stmt->bind_param('i', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }

    public function actualiza($id, $titulo, $descripcion, $prioridad) {
        if ($this->verificaExistenciaPorId($id)) {
            $stmt = $this->mysqli->prepare("UPDATE tareas SET titulo=?, descripcion=?, prioridad=? WHERE id = ?");
            $stmt->bind_param('ssii', $titulo, $descripcion, $prioridad, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }

    public function verificaExistenciaPorId($id) {
        $stmt = $this->mysqli->prepare("SELECT 1 FROM tareas WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
}
?>
