<?php
require_once "Rutas.php";

$rutas = new Rutas();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $url = $rutas->dameUrlBase() . "/servidor/tareasAPI.php?action=tareas&id=" . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $resultado = ($httpCode == 200) ? "Registro eliminado exitosamente" : "No fue posible eliminar el registro";
} else {
    $resultado = "ID inválido";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Eliminar Tarea</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <p><?php echo $resultado; ?></p>
    </body>
</html>
