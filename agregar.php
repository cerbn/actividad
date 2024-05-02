<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Tarea</title>
</head>
<body>
    <h1>Agregar Nueva Tarea</h1>
    <form action="agregar.php" method="post">
        <label for="tarea">Tarea:</label>
        <input type="text" id="tarea" name="tarea" required>
        <input type="submit" value="Agregar">
    </form>

    <?php
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener la tarea del formulario
        $nuevaTarea = $_POST["tarea"];

        // Validar que la tarea no esté vacía
        if (!empty($nuevaTarea)) {
            // Abrir el archivo de tareas en modo escritura (append)
            $archivo = fopen("tareas.txt", "a");

            // Escribir la nueva tarea en el archivo
            fwrite($archivo, $nuevaTarea . "|pendiente\n");

            // Cerrar el archivo
            fclose($archivo);

            // Mostrar un mensaje de éxito
            echo "<p>Tarea agregada correctamente.</p>";
        } else {
            // Mostrar un mensaje de error si la tarea está vacía
            echo "<p>Por favor, ingresa una tarea válida.</p>";
        }
    }
    ?>
    
    <a href="index.php">Volver a la lista de tareas</a>
</body>
</html>
