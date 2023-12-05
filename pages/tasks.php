<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/StylesClaro.css">
    <title>TurronTasker: Todas las tareas</title>
</head>

<body>
    <?php
    include("../includes/header.php");
    ?>

    <div class="container">
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

        <div class="row mt-5 align-items-center">
            <?php
            include('../controller/controllerDataBase.php');

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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
                    $query = $_POST["search"];
                    $result = searchTasksInDatabase($query);
                } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sort"])) {
                    $query = $_POST["sort"];
                    $result = searchByFilter($query);
                }
            } else {
                $result = getAllTasks();
            }

            foreach ($result as $task) {
                echo '
                    <div class="col-3">
                        <div class="card text-center border border-black m-2" id="idCard' . $task['id'] . '">
                            <div class="card-header text-dark">
                                <h5>' . $task['name'] . '</h5>
                            </div>
                            <div class="card-body">
                                <div class="card-text">
                                    <p>Fecha Limite: ' . $task['due_date'] . '</p>
                                </div>
                                <form method="post" action="">
                                    <button class="btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal' . $task['id'] . '">Detalles</button>
                                    <button type="button" class="btn btn-danger mt-2 btn-outline-dark" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal' . $task['id'] . '">Eliminar</button>
                                    <!-- Formulario de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal' . $task['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar la tarea?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger" name="deleteTask" value="' . $task['id'] . '">Eliminar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin del formulario de confirmación de eliminación -->
                                </form>
                            </div>
                        </div>
                    </div>';

                // Popup de la carta (Modal)
                echo '
                    <div class="modal fade" id="exampleModal' . $task['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">' . $task['name'] . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ' . $task['description'] . '
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Agregar tarea</button>
                                </div>
                            </div>
                        </div>
                    </div>';
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTask"])) {
                $taskIdToDelete = $_POST["deleteTask"];
                eliminarTarea($taskIdToDelete);
            }
            ?>
        </div>
    </div>

    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>
