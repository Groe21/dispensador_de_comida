<?php
// Configuración de la conexión a PostgreSQL
$host = "autorack.proxy.rlwy.net"; // Host de Railway
$port = "11026"; // Puerto de Railway
$dbname = "railway"; // Nombre de la base de datos
$user = "postgres"; // Usuario de la base de datos
$password = "ahkeeWCgaSncnVuWeZCzwSZZckRTfmQw"; // Contraseña de la base de datos

// Cadena de conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Establecer la conexión
$conn = pg_connect($conn_string);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Leer el estado
if (isset($_POST['check_status'])) {
    $id = $_POST['check_status']; // ID del registro a consultar
    $sql = "SELECT * FROM public.estado WHERE id = '$id';";
    $result = pg_query($conn, $sql);

    if ($result) {
        $row = pg_fetch_assoc($result);
        if ($row['estado'] == 0) {
            echo "Estado_es_0"; // Estado apagado
        } else {
            echo "Estado_es_1"; // Estado encendido
        }
    } else {
        echo "Error al leer el estado: " . pg_last_error($conn);
    }
}

// Actualizar el estado
if (isset($_POST['toggle_status'])) {
    $id = $_POST['toggle_status']; // ID del registro a actualizar
    $sql = "SELECT * FROM public.estado WHERE id = '$id';";
    $result = pg_query($conn, $sql);

    if ($result) {
        $row = pg_fetch_assoc($result);
        if ($row['estado'] == 0) {
            $update = pg_query($conn, "UPDATE public.estado SET estado = 1 WHERE id = 1;");
            echo "Estado_es_1"; // Nuevo estado: encendido
        } else {
            $update = pg_query($conn, "UPDATE public.estado SET estado = 0 WHERE id = 1;");
            echo "Estado_es_0"; // Nuevo estado: apagado
        }
    } else {
        echo "Error al actualizar el estado: " . pg_last_error($conn);
    }
}

?>