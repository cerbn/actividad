<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <style>
        /* Estilos simples para resaltar las tareas pendientes */
        .pendiente {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Botón para ir a agregar.php -->
    <form action="agregar.php" method="get">
        <input type="submit" value="Agregar Tarea">
    </form>

    <h1>Lista de Tareas</h1>
    <h2>Tareas Pendientes</h2>
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
                foreach ($lineas as $linea) {
                    // Dividir la línea en tarea y estado (completada o pendiente)
                    list($tarea, $estado) = explode('|', $linea);
                    // Agregar la tarea al array de tareas
                    $tareas[] = ['tarea' => $tarea, 'completada' => $estado == 'completada'];
                }
            }
            return $tareas;
        }

        // Ruta al archivo donde se almacenan las tareas
        $archivoTareas = 'tareas.txt';

        // Obtener las tareas pendientes
        $tareasPendientes = array_filter(leerTareas($archivoTareas), function ($tarea) {
            return !$tarea['completada'];
        });

        // Mostrar las tareas pendientes
        foreach ($tareasPendientes as $tarea) {
            echo '<li class="pendiente">' . $tarea['tarea'] . '</li>';
        }
        ?>
    </ul>

    <h2>Tareas Completadas</h2>
    <ul>
        <?php
        // Obtener las tareas completadas
        $tareasCompletadas = array_filter(leerTareas($archivoTareas), function ($tarea) {
            return $tarea['completada'];
        });

        // Mostrar las tareas completadas
        foreach ($tareasCompletadas as $tarea) {
            echo '<li>' . $tarea['tarea'] . '</li>';
        }
        ?>
    </ul>
</body>

</html>