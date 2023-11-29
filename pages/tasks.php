<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LIBRERÍAS  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/StylesClaro.css">
    <title>Tareas completadas</title>
</head>

<body>

    <!-- //! Cosas extra a tener en cuenta: dialog
    //*Buscar cómo hacer funcional un pop up por cada pestaña
    //* Que cada card responda ante el cursor si pasa por encima (hover) cambiando el tamaño -->
    <!-- //*usar CSS para colores específicos -->
    <?php
        include("../includes/header.php");
    ?>

    <div class="container">
        <!-- //*buscador  -->
        <div class="row mt-5">
            <div class="col">
            <form method="post" action="">
        <div class="input-group mb-3">
            <input type="search" class="form-control" name="search" placeholder="Buscar por nombre de tarea">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="submit">Buscar</button>
            </div>
        </div>
    </form>
            </div>
        </div>

            <!-- //*Cartas con tareas  -->
        <div class="row mt-5 align-items-center">
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo + fecha</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="card-text">
                            Categoría:
                        </div>
                        <button class="buttonCards btn btn-primary mt-2 btn-outline-dark">Detalles</button>
                    </div>

                </div>
            </div>
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo + fecha</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            Categoría
                        </div>
                        <button class="buttonCards btn btn-primary mt-2 btn-outline-dark">Detalles</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo  + fecha</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            Categoría
                        </div>
                        <button class="buttonCards btn btn-primary mt-2 btn-outline-dark">Detalles</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- //*Primera fila de cartas acaba aquí  -->
        <?php
// Conectar a tu base de datos aquí
require_once 'controllerDataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Obtener la consulta de búsqueda del formulario
    $query = $_POST["query"];

    // Obtener el criterio de ordenación seleccionado
    $sortCriteria = isset($_POST["sort"]) ? $_POST["sort"] : "name"; // Predeterminado: ordenar por nombre

    // Realizar la búsqueda en la base de datos y obtener los resultados ordenados
    $results = searchTasksInDatabase($query, $sortCriteria);

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

// Formulario para el filtro de ordenación
echo '<form method="post" action="">';
echo '<div class="input-group input-group-sm mb-3">';
echo '<select class="custom-select" name="sort">';
echo '<option value="category_name">Order by category</option>';
echo '<option value="due_date">Order by date</option>';
echo '<option value="user_name">Order by user</option>';
echo '</select>';
echo '<div class="input-group-append">';
echo '<button class="btn btn-primary" type="submit" name="submit">Apply</button>';
echo '</div>';
echo '</div>';
echo '</form>';
?>
        </div>
    <?php
    include("../includes/footer.php");
    ?>
    </div>
</body>
