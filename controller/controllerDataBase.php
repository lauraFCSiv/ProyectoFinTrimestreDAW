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

    // Consulta donde intenta buscar un usuario con ese nombre de usuario y esa contrasena.
    $query = "SELECT * FROM `users` WHERE `username` = '$user' AND `password` = '$password'";
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
function searchTasksInDatabase($query) {
   
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection fail: " . $conn->connect_error);
    }

    // Escapar caracteres especiales en la consulta
    $query = $conn->real_escape_string($query);

    // Realizar la consulta SQL para buscar tareas por nombre
    $sql = "SELECT * FROM tasks WHERE name LIKE '%$query%'";
    $result = $conn->query($sql);

    // Almacenar los resultados en un array
    $tasks = array();

    // Recorrer los resultados y almacenar en el array
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    return $tasks;
}

?>