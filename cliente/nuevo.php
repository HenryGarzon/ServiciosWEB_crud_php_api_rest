<?php
require_once "Rutas.php";

$rutas = new Rutas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $rutas->dameUrlBase() . '/servidor/tareasAPI.php?action=tareas';

    $data = array(
        'titulo' => $_POST['titulo'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'prioridad' => $_POST['prioridad'] ?? ''
    );

    $postdata = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    echo "Registro guardado correctamente.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nuevo Tarea</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <form action="" method="post">
            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo" required><br>
            <label for="descripcion">Descripción:</label><br>
            <input type="text" id="descripcion" name="descripcion" required><br>
            <label for="prioridad">Prioridad:</label><br>
            <select name="prioridad" id="prioridad" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <br>
            <button type="submit">Guardar</button>
        </form>
    </body>
</html>
