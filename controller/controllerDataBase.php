<?php

/**
 * @package ConnectionDatabase
 */

include('../connection/connectionDataBase.php');

/**
 * @version 1.0.
 * @author Pablo A.
 * @param String $user Nombre de usuario.
 * @param String $password Contrasena de usuario.
 * @return mixed
 * Funcion de inicio de sesion de un usuario.
 */
function login($user, $password)
{

    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta donde intenta buscar un usuario con ese nombre de usuario
    $query = "SELECT * FROM `users` WHERE `username` = '$user'";
    $result = $conn->query($query);

    // Cerrar conexion una vez utilizada.
    closeConnectionDB($conn);

    if (mysqli_num_rows($result) == 1) {
        // En caso de encontrar un usuario, buscar si el usuario esta activo o no.
        foreach ($result as $user) {
            // Verificar si la contrasena introducida coincide con la contrasena en el servidor (esta esta hasheada).
            if (password_verify($password, $user['password'])) {
                if ($user['active'] == 1) {
                    // Si el usuario esta activo, devolver usuario.
                    return $result;
                } else {
                    // Si el usuario no esta activo, devolver mensaje de error.
                    return 'Usuario deshabilitado';
                }
            } else {
                // En caso de que la contrasena no sea asi, devolver mensaje de error.
                return 'Usuario/Contraseña no valido/s';
            }
        }
    } else {
        // En caso de no en contrar un usuario, devolver mensaje de error.
        return 'Usuario/Contraseña no valido/s';
    }
}

/**
 * @version 1.0.
 * @author Pablo A.
 * @param String $user Nombre de usuario.
 * @param String $email Email de usuario.
 * @param String $password Contrasena de usuario.
 * @return mixed
 * Funcion de registro de un usuario a la aplicacion.
 */
function register($user, $email, $password)
{

    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Hashear la contraseña.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Query 1: Busca un usuario con ese nombre de usuario para verificar si ya esta creado
    $query1 = "SELECT * FROM `users` WHERE `username` = '$user'";
    $result1 = $conn->query($query1);

    // Query 2: Busca un usuario con ese email para verificar si ese correo electronico ya esta dentro de la base de datos
    $query2 = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result2 = $conn->query($query2);

    if (mysqli_num_rows($result1) == 0 && mysqli_num_rows($result2) == 0) {
        // En caso de que no se haya encontrado ningun usuario con ese nombre de usuario y ese correo, insertar en base de datos el nuevo usuario
        $query3 = "INSERT INTO `users` (`username`, `email`, `password`, `active`) VALUES ('$user', '$email', '$passwordHash', 1)";
        $result3 = $conn->query($query3);
        // Cerrar conexion una vez utilizada.
        closeConnectionDB($conn);
        // Devolver resultado.
        return $result3;
    } else {
        // Cerrar conexion una vez utilizada.
        closeConnectionDB($conn);
        // Mensaje error
        $error = "";
        if (mysqli_num_rows($result1) >= 1) {
            $error = "Nombre de usuario ya utilizado.<br>";
        }
        if (mysqli_num_rows($result2) >= 1) {
            $error = $error . "Correo electronico ya utilizado.";
        }
        return $error;
    }
}

/**
 * @version 1.0.
 * @author Pablo A.
 * @param String $type Tipo de filtro.
 * @return mysqli_result $result Resultado de la consulta.
 * Obtener todas las tareas alamcenadas en base de datos, y teniendo en cuenta de si se quieren filtrar segun su estado (No asignadas, asignadas y finalizadas).
 * Hace una subconsulta con la tabla categorias para obtener a parte el nombre de la categoria asignada.
 */
function getAllTasks($type)
{

    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta que obtiene todas tareas de base de datos, y en funcion de si queremos buscar todas las tareas o unas tareas segun su estado (No asignadas, asignadas y finalizadas).
    $query = "SELECT `tasks`.*, `categories`.`name` as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id`";
    switch ($type) {
        case 'all':
            break;
        case 'finished':
            $query .= " WHERE `tasks`.`status` = 'Finalizada'";
            break;
        case 'assigned':
            $query .= " WHERE `tasks`.`status` = 'Asignada'";
            break;
    }

    $result = $conn->query($query);

    // Devolver resultado
    return $result;
}
/**
 * @version 1.0.
 * @author Eusebio U.
 * @return mixed
 * Funcion para buscar las tareas en la base de datos.
 */
function searchTasksInDatabase($query, $type) {
   
    // Abrir conexión con la base de datos
    $conn = openConnectionDB();

    // Escapar caracteres especiales en la consulta
    $query = $conn->real_escape_string($query);

    // Realizar la consulta SQL para buscar tareas por nombre, y en funcion de si queremos buscar todas las tareas o unas tareas segun su estado (No asignadas, asignadas y finalizadas)
    $sql = "SELECT `tasks`.*, `categories`.`name` as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id` WHERE `tasks`.`name` LIKE '%$query%'";
    switch ($type) {
        case 'all':
            // Si no se selecciona ninguna opción de categoria, la consulta permanece igual
            break;
        case 'finished':
            $sql .= " AND `tasks`.`status` = 'Finalizada'";
            break;
        case 'assigned':
            $sql .= " AND `tasks`.`status` = 'Asignada'";
            break;
    }

    $result = $conn->query($sql);

    // Almacenar los resultados en un array
    $tasks = array();

    // Recorrer los resultados y almacenar en el array
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver tareas
    return $tasks;
}

function searchByFilter($query, $type)
{

    // Abrir conexión con la base de datos
    $conn = openConnectionDB();

    // Escapar caracteres especiales en la consulta
    $query = $conn->real_escape_string($query);

    // Construir la consulta SQL para buscar tareas por nombre y ordenar según el criterio seleccionado, y teniendo en cuenta 
    $sql = "SELECT `tasks`.*, `categories`.`name` as 'category_name', `users`.`username` as 'username' FROM `tasks` LEFT JOIN `categories` ON `tasks`.`category_id` = `categories`.`id` LEFT JOIN `users` ON `tasks`.`user_id` = `users`.`id`";
    switch ($type) {
        case 'all':
            break;
        case 'finished':
            $sql .= " WHERE `tasks`.`status` = 'Finalizada'";
            break;
        case 'assigned':
            $sql .= " WHERE `tasks`.`status` = 'Asignada'";
            break;
    }

    switch ($query) {
        case 'category_name':
            $sql .= " ORDER BY `category_name` ASC, `tasks`.`name` ASC";
            break;
        case 'due_date':
            $sql .= " ORDER BY `tasks`.`due_date` ASC, `tasks`.`name` ASC";
            break;
        case 'user_name':
            $sql .= " ORDER BY `username` ASC, `tasks`.`name` ASC";
            break;
        default:
            // Si no se selecciona ninguna opción de orden, la consulta permanece igual
            break;
    }

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Almacenar los resultados en un array
    $tasks = array();

    // Recorrer los resultados y almacenar en el array
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver tareas
    return $tasks;
}
/**
 * @version 1.0.
 * @author Eusebio U.
 * @return mixed
 * Funcion para eliminar las tareas.
 */
function eliminarTarea($taskId) {
    $conn = openConnectionDB();

    // Utilizamos una consulta preparada para evitar la inyección de SQL
    $sql = "DELETE FROM tasks WHERE id = ?";

    // Preparamos la consulta
    $stmt = $conn->prepare($sql);

    // Vinculamos el parámetro
    $stmt->bind_param("i", $taskId);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Éxito al eliminar la tarea

    } else {
        // Manejar el error si es necesario
        echo "Error al eliminar la tarea: " . $stmt->error;
    }

    // Cerramos la consulta y la conexión a la base de datos
    $stmt->close();
    closeConnectionDB($conn);
}

function getNextTasksDate()
{
    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta donde intenta buscar un usuario con ese nombre de usuario
    $query = "SELECT `tasks`.*, `categories`.`name`as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id` WHERE `end_date` IS NULL ORDER BY `due_date` ASC LIMIT 0,3;";
    $result = $conn->query($query);

    // Cerrar la conexión a la base de datos
    $conn->close();

    return $result;
}

function countTasks($type)
{

    // Abrir conexion con la base de datos.
    $conn = openConnectionDB();

    // Consulta que obtiene todas tareas de base de datos, y en funcion de si queremos contar todas las tareas o unas tareas segun su estado (No asignadas, asignadas y finalizadas).
    $query = "SELECT COUNT(*) as 'count' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id`";
    switch ($type) {
        case 'all':
            break;
        case 'finished':
            $query .= " WHERE `tasks`.`status` = 'Finalizada'";
            break;
        default:
            break;
    }

    // Ejecutar la consulta.
    $result = mysqli_query($conn, $query);

    // Obtener el resultado como un array asociativo.
    $row = mysqli_fetch_assoc($result);

    // Devolver el número de tareas.
    return $row['count'];
}

/**
 * @version 1.0.
 * @author Marco
 * Comprueba si un usuario ya tiene la tarea asignada
 * @param int $taskIdID id de una tarea seleccionada.
 * @return mixed
 */
function isTaskAssigned($taskId)
{
    $conn = openConnectionDB();

    $query = "SELECT * FROM `tasks` WHERE `id` = '$taskId' AND `user_id` IS NOT NULL";
    $result = $conn->query($query);

    closeConnectionDB($conn);

    return mysqli_num_rows($result) > 0;
}

//Asignamos tarea a un usuario
function assignTaskToUser($userId, $taskId)
{
    $conn = openConnectionDB();

    $query = "UPDATE tasks SET user_id = $userId, status = 'Asignada' WHERE id = $taskId";
    $conn->query($query);

    closeConnectionDB($conn);
}

/**
 * @version 1.0.
 * @author Marco
 * Función que se encarga de "eliminar" el usuario actual cambiando valores en la columna "active"
 * con un 1 por defecto a 0
 * @param int $userid ID del usuario actual.
 */
function deleteAccount($userId)
{
    $conn = openConnectionDB();
    // Se actualiza la columna 'active' a 0 para el usuario actual
    $query = "UPDATE users SET active = 0 WHERE id = $userId";
    $conn->query($query);

        closeConnectionDB($conn);
      }
    /**
 * @version 1.0.
 * @author Eusebio U.
 * @return mixed
 * Funcion para cambiar los datos de un usuario.
 */
   function changeProfile($userId, $newDates) {
        $conn = openConnectionDB();
    
        // Asegúrate de escapar los datos para prevenir inyección SQL
        $nuevosDatosEscapados = array_map(function ($value) use ($conn) {
            return mysqli_real_escape_string($conn, $value);
        }, $newDates);
    
        // Construye la consulta para actualizar los datos del usuario
        $sql = "UPDATE users SET 
                username = '{$nuevosDatosEscapados['nombre']}',  
                email = '{$nuevosDatosEscapados['email']}' 
                WHERE id = '$userId'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Datos del usuario actualizados con éxito";
        } else {
            echo "Error al actualizar los datos del usuario: " . $conn->error;
        }
    
        // Cerrar la conexión a la base de datos
        closeConnectionDB($conn);
    }
    
    /**
 * @version 1.0.
 * @author Eusebio U.
 * @return mixed
 * Funcion para saber que usuario creo las tareas.
 */
    function getTaskCreatorId($taskId) {
        $conn = openConnectionDB();
    
        // Utilizamos una consulta preparada para evitar la inyección de SQL
        $sql = "SELECT user_id FROM tasks WHERE id = user_creator";
        
        // Preparamos la consulta
        $stmt = $conn->prepare($sql);
        
        // Vinculamos el parámetro
        $stmt->bind_param("i", $taskId);
        
        // Ejecutamos la consulta
        $stmt->execute();
    
        // Vinculamos el resultado a una variable
        $stmt->bind_result($taskCreatorId);
    
        // Obtenemos el resultado
        $stmt->fetch();
    
        // Cerramos la consulta y la conexión a la base de datos
        $stmt->close();
        closeConnectionDB($conn);
    
        return $taskCreatorId;
    }

 /**
 * Obtener las tareas asignadas al usuario actual.
    closeConnectionDB($conn);
}
/**
 * @version 1.0.
 * @author Marco
 * Función que se encarga de "cambiar" el usuario actual cambiando valores en la columna "admin"
 * con un 0 por defecto a 1.
 * @param int $userid ID del usuario actual.
 */
function changeAccountToAdminMode($userId)
{
    $conn = openConnectionDB();
    //Se actualiza la columna "admin" a 1 para el usuario actual
    $query = "UPDATE users SET admin = 1 WHERE id = $userId";
    $conn->query($query);
    closeConnectionDB($conn);
}


/**
 * @author Eusebio U.
 * @param int $userid ID del usuario actual.
 * @return array Array de tareas asignadas al usuario.
 * Obtener las tareas asignadas al usuario actual.
 */
function getMyAsignedTasks($userid)
{
    // Abrir conexión con la base de datos.
    $conn = openConnectionDB();

    // Escapar el ID del usuario para evitar inyecciones SQL.
    $userid = $conn->real_escape_string($userid);

    // Consulta para obtener las tareas asignadas al usuario.
    $query = "SELECT `tasks`.*, `categories`.`name`as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id` WHERE `user_id` = '$userid' AND `status` = 'Asignada'";
    $result = $conn->query($query);

    // Almacenar los resultados en un array.
    $tasks = array();

    // Recorrer los resultados y almacenar en el array.
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Cerrar la conexión a la base de datos.
    $conn->close();

    // Devolver tareas asignadas al usuario.
    return $tasks;
}

/**
 * @version 1.0.
 * @author Eusebio U.
 * @param int $userid ID del usuario actual.
 * @return array Array de tareas asignadas al usuario.
 * Obtener las tareas finalizadas al usuario actual.
 */
function getMyFinishedTasks($userid)
{
    // Abrir conexión con la base de datos.
    $conn = openConnectionDB();

    // Escapar el ID del usuario para evitar inyecciones SQL.
    $userid = $conn->real_escape_string($userid);

    // Consulta para obtener las tareas asignadas al usuario.
    $query = "SELECT `tasks`.*, `categories`.`name`as 'category_name' FROM `tasks` INNER JOIN `categories` ON `tasks`.`category_id` = `categories`.`id` WHERE `user_id` = '$userid' AND `status` = 'Finalizada'";
    $result = $conn->query($query);

    // Almacenar los resultados en un array.
    $tasks = array();

    // Recorrer los resultados y almacenar en el array.
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Cerrar la conexión a la base de datos.
    $conn->close();

    // Devolver tareas asignadas al usuario.
    return $tasks;
}

/**
 * @version 1.0.
 * @author Pablo A.
 * @param int $taskId ID de la tarea actual.
 * Funcion de actualizar el estado de una tarea de asignada a finalizada.
 */
function finishTask($taskId)
{
    $conn = openConnectionDB();
    $query = "UPDATE tasks SET status = 'Finalizada', end_date = CURRENT_DATE WHERE id = $taskId";
    $conn->query($query);

    closeConnectionDB($conn);
}


function getCategories()
{
    // Abrir conexión con la base de datos.
    $conn = openConnectionDB();

    // Consulta para obtener todas las categorías.
    $query = "SELECT `categories`.*, `categories`.`id` as 'id' FROM `categories`";

    // Ejecutar la consulta.
    $result = $conn->query($query);

    // Cerrar la conexión
    closeConnectionDB($conn);

    // Devolver resultado
    return $result;
}


function insertTask($taskName, $description, $dueDate, $category, $user_creator)
{
    // Abrir conexión con la base de datos
    $conn = openConnectionDB();

    // Consulta SQL corregida
    $sql = "INSERT INTO `tasks` (`name`, `description`, `category_id`, `status`, `start_date`, `end_date`, `due_date`, `user_creator`, `user_id`)
            VALUES ('$taskName', '$description', '$category', 'Nueva', 'CURRENT_DATE', NULL, '$dueDate', '$user_creator', NULL)";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Cerrar la conexión
    closeConnectionDB($conn);

    // Devolver el resultado de la consulta (true si se insertó correctamente, false si hubo un error)
    return $result;
}
