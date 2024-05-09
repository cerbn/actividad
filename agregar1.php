<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agregar.css">
    <title>Agregar Nueva Tarea</title>

    
</head>
<body>
    <h1 id="titulo">Agregar Nueva Tarea</h1>
    <form action="agregar1.php" method="post">
        <label for="tarea" class="subtitulo1">Tarea:</label>
        <input type="text" id="tarea" name="tarea" required>
        <input type="submit" value="Agregar">
    </form>

    <?php
        // Ruta al archivo donde se almacenan las tareas
        $archivoTareas = 'tareas.txt';

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener la tarea del formulario
            $nuevaTarea = $_POST["tarea"];

            // Validar que la tarea no esté vacía
            if (!empty($nuevaTarea)) {
                // Abrir el archivo de tareas en modo escritura (append)
                $archivo = fopen($archivoTareas, "a");

                // Escribir la nueva tarea en el archivo
                fwrite($archivo, $nuevaTarea . "|pendiente\n");

                // Cerrar el archivo
                fclose($archivo);

                // Agregar 'tareas.txt' al .gitignore si no está presente
                $gitignore = '.gitignore';
                $contenidoGitignore = file_get_contents($gitignore);
                if (strpos($contenidoGitignore, $archivoTareas) === false) {
                    file_put_contents($gitignore, $archivoTareas . PHP_EOL, FILE_APPEND);
                }

                // Mostrar un mensaje de éxito
                echo '<p class="mensaje exito" >Tarea agregada correctamente.</p>';
            } else {
                // Mostrar un mensaje de error si la tarea está vacía
                echo '<p class="mensaje error">Por favor, ingresa una tarea válida.</p>';
            }
        }
    ?>

<button onclick="window.location.href='index1.php'">Volver a la lista de tareas</button>

</body>
</html>
