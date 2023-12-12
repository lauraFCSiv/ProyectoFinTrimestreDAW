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
    <link rel="stylesheet" href="../styles/StylesClaro.css">
</head>

<body>
    <?php
    include("../includes/header.php"); // Asumo que la sesión se inicia en header.php
    ?>
    <div class="container">
        <div class="row mt-5 align-items-center">
            <?php
            // Obtener el ID del usuario logeado desde la sesión (debería estar ya iniciada)
            $userid = $_SESSION['userid'];

            // Obtener las tareas asignadas al usuario logeado
            $tasks = getMytasks($userid);

            foreach ($tasks as $task) {
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
                                <button class="buttonCardsTasks btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal' . $task['id'] . '">Detalles</button>
                            </div>
                        </div>
                    </div>
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
            ?>
        </div>
    </div>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>
