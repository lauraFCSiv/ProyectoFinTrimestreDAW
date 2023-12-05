<?php
session_start();
?>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M9.197 10a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm-2.382 4a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm-1.581 4a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z"></path>
                    <path d="M4.125 0h15.75a4.11 4.11 0 0 1 2.92 1.205A4.11 4.11 0 0 1 24 4.125c0 1.384-.476 2.794-1.128 4.16-.652 1.365-1.515 2.757-2.352 4.104l-.008.013c-.849 1.368-1.669 2.691-2.28 3.97-.614 1.283-.982 2.45-.982 3.503a2.625 2.625 0 1 0 4.083-2.183.75.75 0 1 1 .834-1.247A4.126 4.126 0 0 1 19.875 24H4.5a4.125 4.125 0 0 1-4.125-4.125c0-2.234 1.258-4.656 2.59-6.902.348-.586.702-1.162 1.05-1.728.8-1.304 1.567-2.553 2.144-3.738H3.39c-.823 0-1.886-.193-2.567-1.035A3.647 3.647 0 0 1 0 4.125 4.125 4.125 0 0 1 4.125 0ZM15.75 19.875c0-1.38.476-2.786 1.128-4.15.649-1.358 1.509-2.743 2.343-4.086l.017-.028c.849-1.367 1.669-2.692 2.28-3.972.614-1.285.982-2.457.982-3.514A2.615 2.615 0 0 0 19.875 1.5a2.625 2.625 0 0 0-2.625 2.625c0 .865.421 1.509 1.167 2.009A.75.75 0 0 1 18 7.507H7.812c-.65 1.483-1.624 3.069-2.577 4.619-.334.544-.666 1.083-.98 1.612-1.355 2.287-2.38 4.371-2.38 6.137A2.625 2.625 0 0 0 4.5 22.5h12.193a4.108 4.108 0 0 1-.943-2.625ZM1.5 4.125c-.01.511.163 1.008.487 1.403.254.313.74.479 1.402.479h12.86a3.648 3.648 0 0 1-.499-1.882 4.11 4.11 0 0 1 .943-2.625H4.125A2.625 2.625 0 0 0 1.5 4.125Z"></path>
                </svg>
                TurrónTasker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#listaEnlaces" aria-controls="listaEnlaces">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" data-bs-backdrop="static" id="listaEnlaces">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title">Menú</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body justify-content-center">
                    <ul class="navbar-nav">
                        <li class="nav-item px-2"><a class="nav-link" href="tasks.php">Tareas</a></li>
                        <li class="nav-item px-2"><a class="nav-link" href="assignedTasks.php">Tareas asignadas</a></li>
                        <li class="nav-item px-2"><a class="nav-link" href="finishedTasks.php">Tareas Finalizadas</a></li>
                        <?php
                        if (isset($_SESSION['userid'])) {
                            echo '<li class="nav-item px-2"><a class="nav-link" href="myTasks.php">Mis Tareas</a></li>';
                            echo '
                                        <li class="nav-item px-lg-5 dropdown">
                                            <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                                </svg>' .
                                $_SESSION['username'] . '
                                            </button>
                                            <ul class="dropdown-menu">
                                            <li>
                                            <button class="dropdown-item" type="submit" name="profile">
                                            <a class="dropdown-item" type="button" href="profile.php">
                                            Configuración                                                   
                                        </a>
                                                        </button>
                                            </li>
                                                <li>
                                                    <form method="POST">
                                                        <button class="dropdown-item" type="submit" name="logout">
                                                            Cerrar Sesion
                                                        </button>                           
                                                    </form>';
                            if (isset($_POST['logout'])) {
                                // Destruir sesion del usuario.
                                session_unset();
                                session_destroy();
                                // Reedirigir a Login.
                                echo "<script>window.location.href='login.php'</script>";
                            };
                            echo '</li>                            
                                            </ul>
                                        </li>
                                    ';
                        } else {
                            echo '
                                        <li class="nav-item px-lg-5 dropdown">
                                            <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                                </svg>
                                                Usuario
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" type="button" href="login.php">
                                                        Iniciar Sesion                                                   
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    ';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>