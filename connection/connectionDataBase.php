<?php
/**
 * @package ConnectionDatabase
 */

/**
 * @version 1.0.
 * @author Pablo A.
 * @return mixed
 * Metodo que abre la conexion con el servidor de base de datos.
 */
function openConnectionDB() {
    // Parametros de la conexion.
    $servername = "localhost:3306";
    $username = "root";
    $password = "";

    $db = "taskmanager";

    // Intento de conexion.
    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
        // Fallo de conexion: lanzar excepcion.
        die("Conexion fallada: " . $conn->connect_error . " \n");
    } else {
        // Conexion correcta: Devolver conexion activa.
        return $conn;
    }
}

/**
 * @version 1.0.
 * @author Pablo A.
 * Metodo que cierra la conexion con el servidor de base de datos.
 */
function closeConnectionDB($conn){
    try {
        $conn->close();
    } catch (Exception $e) {
        // Puedes loggear o imprimir el mensaje de la excepción.
        echo "Error al cerrar la conexión: " . $e->getMessage();
    }
}

?>
