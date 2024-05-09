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
    <link rel="stylesheet" href="completar.css">
    <title>Marcar Tarea como Completada</title>
</head>

<body>
    <h1 id="titulo">Marcar Tarea como Completada</h1>

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
            echo '<p class="mensaje exito" >Tareas marcadas como completadas correctamente.</p>';
        } else {
            echo '<p class="mensaje error" >No se han seleccionado tareas para marcar como completadas.</p>';
        }
    }
    ?>

<form action="completar1.php" method="post">
    <h2 class="subtitulo1">Tareas Pendientes</h2>
    <ul class="lista-tareas">
        <?php
        // Mostrar solo las tareas pendientes
        leerTareasPendientes($archivoTareas);
        ?>
    </ul>
    <button type="submit">Marcar como Completadas</button>
</form>


    <button onclick="window.location.href='index1.php'">Volver a la Lista de Tareas</button>
</body>



</html>

