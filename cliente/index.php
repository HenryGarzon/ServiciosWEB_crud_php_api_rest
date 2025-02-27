<?php
require_once "Rutas.php";

$rutas = new Rutas();
$url = $rutas->dameUrlBase() . "/servidor/tareasAPI.php?action=tareas";

$response = file_get_contents($url);
if ($response === false) {
    die("Error al obtener datos de la API");
}

$registros = json_decode($response, true);
if ($registros === null) {
    die("Error al decodificar JSON");
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listado de Tareas</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TÍTULO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PRIORIDAD</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($registros as $registro) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($registro['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($registro['prioridad']) . "</td>";
                    echo "<td>" . $rutas->dameMenuModificar($registro['id']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuEliminar($registro['id']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
