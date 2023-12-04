<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Tabla Bootstrap</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <form method="post" action="">
        <div class="input-group mb-3">
            <input type="search" class="form-control" name="search" placeholder="Buscar por nombre de tarea">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="submit">Buscar</button>
            </div>
        </div>
    </form>

    <?php
// Conectar a tu base de datos aquí
require_once 'controllerDataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Obtener la consulta de búsqueda del formulario
    $query = $_POST["query"];

    // Realizar la búsqueda en la base de datos y obtener los resultados
    $results = searchTasksInDatabase($query);

    // Mostrar los resultados de la búsqueda
    foreach ($results as $task) {
        echo '<div class="row mt-5 align-items-center">';
        echo '<div class="col">';
        echo '<div class="card text-center border border-black">';
        echo '<div class="card-header text-dark">';
        echo '<h5>' . $task['name'] . ' - ' . $task['due_date'] . '</h5>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<div class="card-text">';
        echo 'Categoría: ' . $task['category_id']; // Ajusta según la columna real en tu base de datos
        echo '</div>';
        echo '<button class="buttonCards btn btn-primary mt-2 btn-outline-dark">Detalles</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
</div>
    
</body>
</html>