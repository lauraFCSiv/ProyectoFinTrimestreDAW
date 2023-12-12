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

        <!-- Temática color claro por defecto  -->
    <link rel="stylesheet" href="../styles/StylesClaro.css?v=2" id="claro">
    <!-- Temáticas adicionales deshabilitadas inicialmente -->
    <link rel="stylesheet" href="../styles/StylesOscuro.css?v=2" id="oscuro" disabled>
    <link rel="stylesheet" href="../styles/StylesCalido.css?v=2" id="calido" disabled>
    <title>TurronTasker: Tareas Asignadas</title>
</head>

<body>
    <?php
    include("../includes/header.php");
    ?>
    <div class="container">
        <!-- //*buscador  -->
        <div class="row mt-5">
            <div class="col">
            <form method="post" action="">
        <div class="input-group mb-3">
            <form method="post">
                <input type="search" class="form-control rounded" name="search" placeholder="Buscar por nombre de tarea">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary rounded mx-1" type="submit" name="submit">Buscar</button>
                </div>
            </form>
        </div>
    </form>
            </div>
        </div>
        <div>
            <?php
                include('../controller/controllerDataBase.php');

                // Formulario para el filtro de ordenación
                echo '<form method="post" action="">';
                    echo '<div class="input-group input-group-sm mb-3">';
                        echo '<select class="custom-select rounded" name="sort">';
                            echo '<option value="category_name">Ordenar por categoria</option>';
                            echo '<option value="due_date">Ordenar por fecha</option>';
                            echo '<option value="user_name">Ordenar por usuario</option>';
                        echo '</select>';
                        echo '<div class="input-group-append">';
                            echo '<button class="btn btn-outline-primary rounded mx-1" type="submit" name="submit">Buscar</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</form>';
            ?>
        </div>
        <!-- //*Cartas con tareas  -->
        <div class="row mt-5 align-items-center">
            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                    // Obtener la consulta de búsqueda del formulario
                    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])){
                        $query = $_POST["search"];
                        // Realizar la búsqueda en la base de datos y obtener los resultados
                        $result = searchTasksInDatabase($query, "assigned");
                    }else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sort"])){
                        $query = $_POST["sort"];                            
                        $result = searchByFilter($query, "assigned");
                    }
                }else{
                    // Obtener todas las tareas
                    $result = getAllTasks("assigned");            
                }
            
                // Imprimir carta por cada tarea
                foreach ($result as $task){
                    echo '
                        <!-- //*Diseño carta -->
                        <div class="col-3 card-container" data-bs-toggle="modal" data-bs-target="#exampleModal'.$task['id'].'">
                            <div class="card text-center border border-black m-2" id="idCard'.$task['id'].'">
                                <div class="card-header text-dark">
                                    <h5>'.$task['name'].'</h5>
                                    <h6>'.$task['category_name'].'</h6>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <p>Fecha Limite: '.$task['due_date'].'</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- //*Popup de la carta (Modal) -->
                            <div class="modal fade" id="exampleModal'.$task['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">'.$task['name'].'</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            '.$task['description'].'
                                        </div>
                                    <div class="modal-footer">';
                                    if ($task['user_id'] == $_SESSION['userid']){
                                        echo '<form method="post" action="">
                                            <input type="hidden" name="task_id" value="' . $task['id'] . '">
                                            <button type="submit" name="finish_task" class="btn btn-primary">Finalizar tarea</button>
                                        </form>';
                                    }
                                        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        } 
                        
                    //Solicitar finalizar tarea:
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['finish_task'])) {
                        if (isset($_SESSION['userid'])) {
                            $taskId = $_POST['task_id'];
                            finishTask($taskId);
                            echo "<script>window.location.href='assignedTasks.php'</script>";
                        }
                    }
            ?>
        </div>        
    </div>
    <?php
    include("../includes/footer.php");
    ?>
    </div>
    <script src="../js/profile.js"></script>
    <script src="../js/tasks.js"></script>
</body>
