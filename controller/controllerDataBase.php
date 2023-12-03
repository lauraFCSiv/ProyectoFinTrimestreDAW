<?php
/**
 * @package ConnectionDatabase
 */

 include('../connection/connectionDataBase.php');

/**
 * @version 1.0.
 * @author Pablo A.
 * @return mixed
 * Funcion de inicio de sesion de un usuario.
 */
function login($user, $password){

    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta donde intenta buscar un usuario con ese nombre de usuario
    $query = "SELECT * FROM `users` WHERE `username` = '$user'";
    $result = $conn->query($query);

    // Cerrar conexion una vez utilizada.
    closeConnectionDB($conn);

    if (mysqli_num_rows($result) == 1){
        // En caso de encontrar un usuario, buscar si el usuario esta activo o no.
        foreach ($result as $user){
            if ($user['active'] == 1){
                // Si el usuario esta activo, devolver usuario.
                return $result;
            }else{
                // Si el usuario no esta activo, devolver mensaje de error.
                return 'Usuario deshabilitado';
            }
        }
    }else{
        // En caso de no en contrar un usuario, devolver mensaje de error.
        return 'Usuario/Contraseña no valido/s';
    }
}

/**
 * @version 1.0.
 * @author Pablo A.
 * @return mixed
 * Funcion de registro de un usuario a la aplicacion.
 */
function register($user, $email, $password){

        // Abrir conexion con la base de datos.
        $conn = openConnectionDB();
        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        // Query 1: Busca un usuario con ese nombre de usuario para verificar si ya esta creado
        $query1 = "SELECT * FROM `users` WHERE `username` = '$user'";
        $result1 = $conn->query($query1);

        // Query 2: Busca un usuario con ese email para verificar si ese correo electronico ya esta dentro de la base de datos
        $query2 = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result2 = $conn->query($query2);

        if (mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) == 0){
            // En caso de que no se haya encontrado ningun usuario con ese nombre de usuario y ese correo, insertar en base de datos el nuevo usuario
            $query3 = "INSERT INTO `users` (`username`, `email`, `password`, `active`) VALUES ('$user', '$email', '$passwordHash', 1)";
            $result3 = $conn->query($query3);
            // Cerrar conexion una vez utilizada.
            closeConnectionDB($conn);
            // Devolver resultado.
            return $result3;
        }else{
            // Cerrar conexion una vez utilizada.
            closeConnectionDB($conn);
            // Mensaje error
            $error = "";
            if (mysqli_num_rows($result1) >= 1){
                $error = "Nombre de usuario ya utilizado.<br>";
            } 
            if (mysqli_num_rows($result2) >= 1){
                $error = $error."Correo electronico ya utilizado.";
            }
            return $error;
        }
}

/**
 * @version 1.0.
 * @author Pablo A.
 * Obtener todas las tareas alamcenadas en base de datos. Hace una subconsulta con la tabla categorias para obtener a parte el nombre de la categoria asignada.
 */
function getAllTasks(){
   
    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta que obtiene todas tareas de base de datos
    $query = "SELECT `tasks`.*, `categories`.`name` as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id`";
    $result = $conn->query($query);

    // Devolver resultado
    return $result;

}

?>