<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurronTasker: Iniciar Sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/StylesClaro.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php
        include("../includes/header.php");
    ?>
    <main class="mt-5">
         <!-- //*Cartas con tareas  -->
         <div class="d-flex flex-column mt-5 align-items-center">
            <?php
                include('../controller/controllerDataBase.php');
                
                // Obtener todas las tareas
                $result = getNextTasksDate();

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
                                            }                                        
                                    echo '</div>
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
                            echo "<script>window.location.href='index.php'</script>";
                        }
                    }
            ?>
        </div> 
    </main>
    <?php
        include("../includes/footer.php");
    ?>
</body>
    <script src="../js/tasks.js"></script>
</html>