<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurronTasker: Registro</title>
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
        <div class="w-100 p-4 pb-4 justify-content-center align-items-center">
            <div class="col-auto text-center">
                <h2 class="mb-4">Registro</h2>
                <form class="input-group d-flex flex-column align-items-center" method="POST">
                    <input class="form-control rounded w-50 m-2" name="usersignup" type="text" placeholder="Usuario">
                    <input class="form-control rounded w-50 m-2" name="emailsignup" type="email" placeholder="Correo Electronico">
                    <input class="form-control rounded w-50 m-2" name="passwordsignup" type="password" placeholder="Contraseña">      
                    <button class="btn btn-outline-primary rounded m-2" type="submit">Crear Cuenta</button>             
                </form>
                <?php
                ?>
            </div>
        </div>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
</body>
</html>