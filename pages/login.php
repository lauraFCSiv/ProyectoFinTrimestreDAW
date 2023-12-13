<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurronTasker: Iniciar Sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Temática color claro por defecto  -->
    <link rel="stylesheet" href="../styles/StylesClaro.css?v=2" id="claro">
    <!-- Temáticas adicionales deshabilitadas inicialmente -->
    <link rel="stylesheet" href="../styles/StylesOscuro.css?v=2" id="oscuro" disabled>
    <link rel="stylesheet" href="../styles/StylesCalido.css?v=2" id="calido" disabled>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    include("../includes/header.php");
    ?>
    <main class="mt-5">
        <div class="w-100 p-4 pb-4 justify-content-center align-items-center">
            <div class="col-auto text-center">
                <h2 class="mb-4">Iniciar Sesion</h2>
                <form class="input-group d-flex flex-column align-items-center" method="POST">
                    <input class="form-control rounded w-50 m-2" name="userlogin" type="text" placeholder="Usuario"
                        maxlength="20">
                    <input class="form-control rounded w-50 m-2" name="passwordlogin" type="password"
                        placeholder="Contraseña" maxlength="18">
                    <button class="btn btn-outline-primary rounded m-2" type="submit">Iniciar Sesion</button>
                </form>
                <?php
                include('../controller/controllerDataBase.php');

                // Verificar si se ha enviado una peticion.
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userlogin']) && isset($_POST['passwordlogin'])) {

                    // Obtener usuario o error.
                    $result = login($_POST['userlogin'], $_POST['passwordlogin']);

                    if (is_string($result)) {
                        // En caso de obtener error, mostrar el error debajo del formulario.
                        echo $result;
                    } else {
                        // En caso de obtener el usuario, almacenar la sesion del usuario y cambiar a la pagina principal.
                        foreach ($result as $user) {
                            //Comprobamos si la contraseña escrita coincide en la base de datos (hasheada)
                            if (password_verify($_POST['passwordlogin'], $user['password'])) {

                                $_SESSION['userid'] = $user['id'];
                                $_SESSION['username'] = $user['username'];
                                // Verifica si el usuario es administrador
                                $isAdmin = $user['admin'] == 1;

                                // Se almacena la variable de administrador en sesión
                                $_SESSION['is_admin'] = $isAdmin;
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
    <script src="../js/profile.js"></script>
</body>

</html>