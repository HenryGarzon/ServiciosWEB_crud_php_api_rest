<?php
require_once "Rutas.php";

$rutas = new Rutas();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registro = [];

if ($id > 0) {
    $url = $rutas->dameUrlBase() . '/servidor/tareasAPI.php?action=tareas&id=' . $id;
    $response = file_get_contents($url);
    if ($response !== false) {
        $registro = json_decode($response, true);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $rutas->dameUrlBase() . '/servidor/tareasAPI.php?action=tareas&id=' . $id;
    $data = array(
        'titulo' => $_POST['titulo'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'prioridad' => $_POST['prioridad'] ?? ''
    );
    $postdata = json_encode($data);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    
    $registro = $data;
    echo "Registro modificado correctamente.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modificar Tarea</title>
    </head>
    <body>
        <?php
        echo $rutas->dameMenuInicio() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rutas->dameMenuNuevo();
        ?>
        <br>
        <form action="" method="post">
            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($registro['titulo'] ?? ''); ?>"><br>
            <label for="descripcion">Descripción:</label><br>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($registro['descripcion'] ?? ''); ?>"><br>
            <label for="prioridad">Prioridad:</label><br>
            <select name="prioridad" id="prioridad">
                <option value="1" <?php echo ($registro['prioridad'] ?? '') == 1 ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo ($registro['prioridad'] ?? '') == 2 ? 'selected' : ''; ?>>2</option>
                <option value="3" <?php echo ($registro['prioridad'] ?? '') == 3 ? 'selected' : ''; ?>>3</option>
            </select>
            <br>
            <button type="submit">Guardar</button>
        </form>
    </body>
</html>
