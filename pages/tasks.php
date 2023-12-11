<?php
include("../includes/header.php");
include('../controller/controllerDataBase.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTask"])) {
    $taskIdToDelete = $_POST["deleteTask"];
    eliminarTarea($taskIdToDelete);
}

$result = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        $query = $_POST["search"];
        $result = searchTasksInDatabase($query, "all");
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sort"])) {
        $query = $_POST["sort"];
        $result = searchByFilter($query, "all");
    }
} else {
    $result = getAllTasks("all");
}
?>

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

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <form method="post" action="">
                    <div class="input-group mb-3">
                        <form method="post">
                            <input type="search" class="form-control rounded" name="search"
                                placeholder="Buscar por nombre de tarea">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary rounded mx-1" type="submit" name="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <form method="post" action="">
                <div class="input-group input-group-sm mb-3">
                    <select class="custom-select rounded" name="sort">
                        <option value="category_name">Ordenar por categoria</option>
                        <option value="due_date">Ordenar por fecha</option>
                        <option value="user_name">Ordenar por usuario</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary rounded mx-1" type="submit" name="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mt-5 align-items-center">
            <?php
                include('../controller/controllerDataBase.php');
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                    // Obtener la consulta de búsqueda del formulario
                    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])){
                    $query = $_POST["search"];
                        // Realizar la búsqueda en la base de datos y obtener los resultados
                        $result = searchTasksInDatabase($query, "all");
                    }else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sort"])){
                        $query = $_POST["sort"];                            
                        $result = searchByFilter($query, "all");
                    }
                }else{
                    // Obtener todas las tareas
                    $result = getAllTasks("all");            
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
                        <form method="post" action="">
                            <button type="button" class="btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $task['id'] ?>">Detalles</button>
                            <button type="button" class="btn btn-danger mt-2 btn-outline-dark" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?= $task['id'] ?>">Eliminar</button>

                            <!-- Modal de confirmación de eliminación -->
                            <div class="modal fade" id="confirmDeleteModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="submit" class="btn btn-danger" name="deleteTask" value="<?= $task['id'] ?>">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <!-- Modal de la tarea -->
                        <div class="modal fade" id="exampleModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?= $task['name'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?= $task['description'] ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
                                        //Comprobamos si el usuario está con sesión activa para poder agregar dicha tarea:
                                        if (isset($_SESSION['userid'])) {
                                        //Comprobamos si la tarea ya está asignada a un usuario
                                        $taskAssignedAlready = isTaskAssigned($task['id']);
                                            if($taskAssignedAlready){
                                                //en caso de estar asignada, el botón estará deshabilitado
                                                echo '<button type="button" class="btn btn-primary disabled">Asignada</button>';
                                            }else{
                                                //de lo contrario, eres libre de asignarte la tarea
                                                echo '<form method="post" action="">
                                                        <input type="hidden" name="task_id" value="' . $task['id'] . '">
                                                        <button type="submit" name="assign_task" class="btn btn-primary">Asignar tarea</button>
                                                    </form>';
                                            }
                                        }else{
                                        //En caso de no tener sesión activa, el botón estará deshabilitado
                                            echo '<button type="button" class="btn btn-primary disabled">Agregar tarea</button>';
                                        }
                                        echo '
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }

                    //Solicitar asignar tarea:
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_task'])) {
                        // Verificamos si el usuario ha iniciado sesión
                        if (isset($_SESSION['userid'])) {
                            // Obtenemos la tarea ID del formulario
                            $taskId = $_POST['task_id'];
                    
                            // Llamamos a la función para asignar la tarea
                            assignTaskToUser($_SESSION['userid'], $taskId);
                            //Actualizamos la página para que una vez asignado, no pueda volver a asignarse
                            echo "<script>window.location.href='tasks.php'</script>";
                        }
                    }
            ?>
        </div>        
    </div>
    <?php
    include("../includes/footer.php");
    ?>
    </div>

    <?php include("../includes/footer.php"); ?>
    <script src="../js/tasks.js"></script>

</body>

</html>
