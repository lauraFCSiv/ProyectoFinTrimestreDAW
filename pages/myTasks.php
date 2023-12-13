<?php
include('../controller/controllerDataBase.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurronTasker: Mis tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Temática color claro por defecto  -->
    <link rel="stylesheet" href="../styles/StylesClaro.css?v=2" id="claro">
    <!-- Temáticas adicionales deshabilitadas inicialmente -->
    <link rel="stylesheet" href="../styles/StylesOscuro.css?v=2" id="oscuro" disabled>
    <link rel="stylesheet" href="../styles/StylesCalido.css?v=2" id="calido" disabled>
</head>

<body>
    <?php
    include("../includes/header.php"); // Asumo que la sesión se inicia en header.php
    ?>
    <div class="container">
        <div class="row mt-5 align-items-center">
            <div>
                <h3>Mis Tareas Asignadas</h3>
                <?php
                // Obtener el ID del usuario logeado desde la sesión (debería estar ya iniciada)
                $userid = $_SESSION['userid'];

                // Obtener las tareas asignadas al usuario logeado
                $tasks = getMyAsignedTasks($userid);

                foreach ($tasks as $task) {
                    echo '
                        <!-- //*Diseño carta -->
                        <div class="col-3 card-container" data-bs-toggle="modal" data-bs-target="#exampleModal'.$task['id'].'">
                            <div class="card text-center border border-black m-2" id="idCard'.$task['id'].'">
                                <div class="card-header">
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                ?>
            </div>
            <div>
                <h3>Mis Tareas Finalizadas</h3>
                <?php
                // Obtener el ID del usuario logeado desde la sesión (debería estar ya iniciada)
                $userid = $_SESSION['userid'];

                // Obtener las tareas asignadas al usuario logeado
                $tasks = getMyFinishedTasks($userid);

                foreach ($tasks as $task) {
                    echo '
                        <!-- //*Diseño carta -->
                        <div class="col-3 card-container" data-bs-toggle="modal" data-bs-target="#exampleModal'.$task['id'].'">
                            <div class="card h-100 w-100 text-center border border-black m-2" id="idCard'.$task['id'].'">
                                <div class="card-header">
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                ?>
            </div>
            <div>
                <h3>Mis Tareas Creadas</h3>
            </div>
        </div>
    </div>
    <?php
    include("../includes/footer.php");
    ?>
    <script src="../js/tasks.js"></script>
    <script src="../js/profile.js"></script>
</body>

</html>