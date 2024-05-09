<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

    <style>
        
        /* Estilos simples para resaltar las tareas pendientes */
        .pendiente {
            font-weight: bold;
        }

        .eliminar {
            color: #ff0000; /* Color rojo */
            cursor: pointer;
            float: right; /* Flotar el icono hacia la derecha */
        }
    </style>
    <link rel="stylesheet" href="index.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Agregar la librería Font Awesome para los iconos -->
</head>

<body>
    
    <h1 id="titulo">Lista de Tareas</h1>

    <div id="botones">
        <!-- Botón para ir a agregar.php -->
        <form action="agregar1.php" method="get">
            <input type="submit" value="Agregar Tarea">
        </form>

        <form action="completar1.php" method="get">
            <input type="submit" value="Completar Tarea">
        </form>

    </div>

    <div id="tareass">
        <div id="subtitulo1">
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

                // Verificar si se ha enviado un formulario para eliminar una tarea
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tarea'])) {
                    // Tarea a eliminar
                    $tarea_a_eliminar = $_POST['tarea'];

                    // Obtener todas las tareas del archivo
                    $tareas = leerTareas($archivoTareas);

                    // Eliminar la tarea del array de tareas
                    foreach ($tareas as $indice => $tarea) {
                        if ($tarea['tarea'] === $tarea_a_eliminar) {
                            unset($tareas[$indice]);
                        }
                    }

                    // Guardar las tareas actualizadas en el archivo
                    $contenido = '';
                    foreach ($tareas as $tarea) {
                        $contenido .= $tarea['tarea'] . '|' . ($tarea['completada'] ? 'completada' : 'pendiente') . PHP_EOL;
                    }

                    file_put_contents($archivoTareas, $contenido);
                }

                // Obtener las tareas pendientes
                $tareasPendientes = array_filter(leerTareas($archivoTareas), function ($tarea) {
                    return !$tarea['completada'];
                });

                // Mostrar las tareas pendientes con icono de eliminar
                foreach ($tareasPendientes as $tarea) {
                    echo '<li class="pendiente">' . $tarea['tarea'] . ' <span class="eliminar"><i class="fas fa-trash-alt"></i></span><form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post"><input type="hidden" name="tarea" value="' . $tarea['tarea'] . '"></form></li>';
                }
                ?>
            </ul>
        </div>

        <div id="subtitulo2">
            <h2>Tareas Completadas</h2>
            <ul>
                <?php
                // Obtener las tareas completadas
                $tareasCompletadas = array_filter(leerTareas($archivoTareas), function ($tarea) {
                    return $tarea['completada'];
                });

                // Mostrar las tareas completadas con icono de eliminar
                foreach ($tareasCompletadas as $tarea) {
                    echo '<li class="Completada"> ' . $tarea['tarea'] . '<span class="ticket">&#10003;</span> <span class="eliminar"><i class="fas fa-trash-alt"></i></span><form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post"><input type="hidden" name="tarea" value="' . $tarea['tarea'] . '"></form></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        // Script para eliminar tarea al hacer clic en el icono de eliminación
        document.querySelectorAll('.eliminar').forEach(item => {
            item.addEventListener('click', event => {
                item.parentElement.querySelector('form').submit();
            })
        });
    </script>
    
</body>

</html>

