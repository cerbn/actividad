<?php
// Función para leer las tareas pendientes desde el archivo de texto
function leerTareasPendientes($archivo)
{
    // Verificar si el archivo existe
    if (file_exists($archivo)) {
        // Leer el contenido del archivo línea por línea
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $indice => $linea) {
            // Dividir la línea en tarea y estado (completada o pendiente)
            list($tarea, $estado) = explode('|', $linea);
            // Mostrar la tarea solo si está pendiente
            if ($estado == 'pendiente') {
                echo '<li><input type="checkbox" name="tareas_pendientes[]" value="' . $indice . '"> ' . $tarea . '</li>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Tarea como Completada</title>
</head>

<body>
    <h1>Marcar Tarea como Completada</h1>

    <?php
    // Ruta al archivo donde se almacenan las tareas
    $archivoTareas = 'tareas.txt';

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se han seleccionado tareas para marcar como completadas
        if (isset($_POST["tareas_pendientes"]) && is_array($_POST["tareas_pendientes"])) {
            // Leer todas las tareas del archivo
            $tareas = file($archivoTareas, FILE_IGNORE_NEW_LINES);
            // Marcar las tareas seleccionadas como completadas
            foreach ($_POST["tareas_pendientes"] as $indice) {
                if (isset($tareas[$indice])) {
                    $tareas[$indice] = str_replace("pendiente", "completada", $tareas[$indice]);
                }
            }
            // Guardar las tareas actualizadas en el archivo
            file_put_contents($archivoTareas, implode("\n", $tareas) . "\n");
            echo "<p>Tareas marcadas como completadas correctamente.</p>";
        } else {
            echo "<p>No se han seleccionado tareas para marcar como completadas.</p>";
        }
    }
    ?>

    <form action="completar.php" method="post">
        <h2>Tareas Pendientes</h2>
        <ul>
            <?php
            // Mostrar solo las tareas pendientes
            leerTareasPendientes($archivoTareas);
            ?>
        </ul>
        <input type="submit" value="Marcar como Completadas">
    </form>

    <a href="index.php">Volver a la Lista de Tareas</a>
</body>

</html>

