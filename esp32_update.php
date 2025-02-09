<?php
// Verificar variables de entorno
echo "PGHOST: " . getenv('PGHOST') . "<br>";
echo "PGPORT: " . getenv('PGPORT') . "<br>";
echo "PGDATABASE: " . getenv('PGDATABASE') . "<br>";
echo "PGUSER: " . getenv('PGUSER') . "<br>";
echo "PGPASSWORD: " . getenv('PGPASSWORD') . "<br>";

// Configuración de la conexión a PostgreSQL
$host = getenv('PGHOST'); 
$port = getenv('PGPORT'); 
$dbname = getenv('PGDATABASE'); 
$user = getenv('PGUSER'); 
$password = getenv('PGPASSWORD');

// Cadena de conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Establecer la conexión
$conn = pg_connect($conn_string);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . pg_last_error());
} else {
    echo "Conexión exitosa a la base de datos.<br>";
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