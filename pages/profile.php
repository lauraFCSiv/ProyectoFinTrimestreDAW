<!-- En el archivo profile.php -->

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

    <title>Perfil de usuario</title>
</head>

<body>
    <!-- header  -->
    <?php
    include("../includes/header.php");
    include('../controller/controllerDataBase.php');
    ?>
    <!-- Contenedor principal  -->
    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <!-- Botones para cambiar los colores de la página -->
                <p>Cambiar tema:</p>
                <button class="btn btn-outline-primary" onclick="changeTheme('claro')">Modo Claro</button>
                <button class=" btn btn-outline-primary" onclick="changeTheme('oscuro')">Modo Oscuro</button>
                <button class=" btn btn-outline-primary" onclick="changeTheme('calido')">Modo Cálido</button>
            </div>
        </div>

        <div class="row">
            <div class="col mt-5">
                <!-- Formulario para actualizar datos del usuario -->
                <form method="POST" action="profile.php">
                    <label for="nuevo_nombre">Nuevo Nombre:</label>
                    <input type="text" name="nuevo_nombre" required>

                    <label for="nuevo_apellido">Nuevo Apellido:</label>
                    <input type="text" name="nuevo_apellido" required>

                    <label for="nuevo_email">Nuevo Email:</label>
                    <input type="email" name="nuevo_email" required>

                    <button type="submit" name="actualizarDatos">Actualizar Datos</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col mt-5">
                <p>Eliminar cuenta:</p>
                <!-- Enlace para abrir la ventana modal -->
                <a href="#" class="btn btn-danger text-center" data-bs-toggle="modal"
                    data-bs-target="#deleteAccountModal">
                    Eliminar
                </a>

                <!-- Modal para confirmar la eliminación de cuenta -->
                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">Eliminar cuenta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" action="profile.php">
                                <div class="modal-body text-center">
                                    ¿Estás seguro de que deseas borrar esta cuenta?
                                </div>
                                <div class="modal-footer">
                                    <!-- Botón de "Sí, eliminar cuenta" -->
                                    <button type="submit" name="deleteAccount" class="btn btn-danger">Sí, eliminar
                                        cuenta</button>
                                    <!-- Botón para cerrar el modal -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizarDatos'])) {
                    // Verificar si el usuario ha iniciado sesión
                    if (isset($_SESSION['userid'])) {
                        // Obtener los nuevos datos del formulario (asegúrate de validar y sanitizar estos datos)
                        $newDates = array(
                            'nombre' => $_POST['nuevo_nombre'],
                            'apellido' => $_POST['nuevo_apellido'],
                            'email' => $_POST['nuevo_email']
                        );

                        // Llamar a la función para cambiar los datos del usuario
                        changeProfile($_SESSION['userid'], $newDates);
                    }
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteAccount'])) {
                    // Verificar si el usuario ha iniciado sesión
                    if (isset($_SESSION['userid'])) {
                        // Una vez con la sesión activa, se decide borrar la cuenta y se cierra sesión
                        deleteAccount($_SESSION['userid']);
                        session_unset();
                        session_destroy();
                        // Redirigir a Login.
                        echo "<script>window.location.href='login.php'</script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- footer  -->
    <?php
    include("../includes/footer.php");
    ?>
    <script src="../js/profile.js"></script>
</body>

</html>
