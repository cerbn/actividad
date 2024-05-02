<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Tarea como Completada</title>
</head>

<body>
    <h1>Marcar Tarea como Completada</h1>

    <form action="completar.php" method="post">
        <ul>
            <?php
            // Función para leer las tareas desde el archivo de texto
            function leerTareas($archivo)
            {
                $tareas = [];
                // Verificar si el archivo existe
                if (file_exists($archivo)) {
                    // Leer el contenido del archivo línea por línea
                    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
                    foreach ($lineas as $indice => $linea) {
                        // Dividir la línea en tarea y estado (completada o pendiente)
                        list($tarea, $estado) = explode('|', $linea);
                        // Mostrar la tarea con un checkbox
                        echo '<li><input type="checkbox" name="tareas_completas[]" value="' . $indice . '"> ' . $tarea . '</li>';
                    }
                }
            }

            // Ruta al archivo donde se almacenan las tareas
            $archivoTareas = 'tareas.txt';

            // Mostrar las tareas
            leerTareas($archivoTareas);
            ?>
        </ul>
        <input type="submit" value="Marcar como Completadas">
    </form>

    <a href="index.php">Volver a la Lista de Tareas</a>
</body>

</html>

