<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/StylesClaro.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php
        include("../includes/header.php");
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center justify-content-center">
                <h2>Iniciar Sesion</h2>
                <form method="POST">
                    <label>Usuario</label>
                    <input name="userlogin" type="text">
                    <br>
                    <label>Contraseña</label>
                    <input name="passwordlogin" type="password">      
                    <br>
                    <button type="submit">Iniciar Sesion</button>             
                </form>
                <?php
                    include('../controller/controllerDataBase.php');

                    if ($_SERVER["REQUEST_METHOD"] == "POST"){

                        $result = login($_POST['userlogin'], $_POST['passwordlogin']);

                        if (is_string($result)){
                            echo $result;
                        }else{
                            foreach ($result as $user){
                                $_SESSION['userid'] = $user['id'];
                                $_SESSION['username'] = $user['username'];
                            }
                            header("Location: index.php");
                        }
                    }
                ?>
            </div>
        </div>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
</body>
</html>