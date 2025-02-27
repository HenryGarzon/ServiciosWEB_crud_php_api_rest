<?php

class Rutas {

    protected $urlBase = "http://localhost/trabajo";

    public function __construct() {
        // Constructor vacío
    }

    public function dameUrlBase() {
        return rtrim($this->urlBase, '/'); // Elimina barra final si existe
    }

    public function dameMenuInicio() {
        return '<a href="' . $this->dameUrlBase() . '/cliente/index.php">Inicio</a>';
    }

    public function dameMenuNuevo() {
        return "<a href='" . $this->dameUrlBase() . "/cliente/nuevo.php'>Nuevo</a>";
    }

    public function dameMenuModificar($id) {
        return "<a href='" . $this->dameUrlBase() . "/cliente/modificar.php?id=" . $id . "'>Modificar</a>";
    }

    public function dameMenuEliminar($id) {
        return "<a href='" . $this->dameUrlBase() . "/cliente/eliminar.php?id=" . $id . "'>Eliminar</a>";
    }
}

?>
