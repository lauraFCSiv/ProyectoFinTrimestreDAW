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
    <link rel="stylesheet" href="StyleClaro.css">
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
                <form method="POST">
                    <div class="form-group">
                        <input type="search" class="form-control border border-dark-subtle" id="" name="" placeholder="Buscar tareas">
                    </div>
                </form>
            </div>
        </div>

            <!-- //*Cartas con tareas  -->
        <div class="row mt-5 align-items-center">
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark bg-warning">
                        <h5>Título de ejemplo + fecha</h5>
                    </div>
                    
                    <div class="card-body">
                        <div class="card-text">
                            Categoría:
                        </div>
                        <button class="btn btn-primary mt-2 text-bg-warning btn-outline-dark">Detalles</button>
                    </div>

                </div>
            </div>
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark bg-warning">
                        <h5>Título de ejemplo + fecha</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            Categoría
                        </div>
                        <button class="btn btn-primary mt-2 text-bg-warning btn-outline-dark">Detalles</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center border border-black">
                    <div class="card-header text-dark bg-warning">
                        <h5>Título de ejemplo  + fecha</h5>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            Categoría
                        </div>
                        <button class="btn btn-primary mt-2 text-bg-warning btn-outline-dark">Detalles</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- //*Primera fila de cartas acaba aquí  -->
        
        </div>
    <?php
    include("../includes/footer.php");
    ?>
    </div>
</body>

</html>