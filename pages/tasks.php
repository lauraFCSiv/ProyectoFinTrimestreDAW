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
    <title>TurronTasker: Todas las tareas</title>
</head>

<body>
    <?php
    include("../includes/header.php");
    ?>
    <!-- //! Cosas extra a tener en cuenta:
    //* Que cada card responda ante el cursor si pasa por encima (hover) cambiando el tamaño -->
    <div class="container">
        <!-- //*buscador  -->
        <div class="row mt-5">
            <div class="col">
                <form method="POST">
                    <div class="form-group">
                        <input type="search" class="form-control border border-dark-subtle" id="" name=""
                            placeholder="Buscar tareas">
                    </div>
                </form>
            </div>
        </div>
        <!-- //*Cartas con tareas  -->
        <div class="row mt-5 align-items-center">
            <div class="col">
                <div class="card text-center border border-black" id="idCard1">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            <p>Categoría:</p>
                            <p>Fecha</p>
                        </div>
                        <!-- <button class="buttonCardsTasks btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1">Detalles</button> -->
                    </div>

                </div>
            </div>
            <!-- //*Popup de la carta (Modal) -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Título de la tarea</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Todo el contenido de la tarea
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <!-- <button type="button" class="btn btn-primary">Agregar tarea</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- //*Fin del Popup de la carta -->
                    <!-- //*Primera fila de cartas acaba aquí  -->
            <!-- 2 cartas más solo para ver como queda, esto se borra luego  -->
            <div class="col">
                <div class="card text-center border border-black" id="idCard2">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            <p>Categoría:</p>
                            <p>Fecha</p>
                        </div>
                        <!-- <button class="buttonCardsTasks btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1">Detalles</button> -->
                    </div>

                </div>
            </div>
            <div class="col">
                <div class="card text-center border border-black" id="idCard3">
                    <div class="card-header text-dark">
                        <h5>Título de ejemplo</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            <p>Categoría:</p>
                            <p>Fecha</p>
                        </div>
                        <!-- <button class="buttonCardsTasks btn btn-primary mt-2 btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#exampleModal1">Detalles</button> -->
                    </div>

                </div>
            </div>
        </div>        
    </div>
    <?php
    include("../includes/footer.php");
    ?>
    </div>
    <!-- <script src="../js/tasks.js"></script> -->
</body>

</html>