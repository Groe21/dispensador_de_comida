<?php
// Configuración de la conexión a PostgreSQL
$host = "autorack.proxy.rlwy.net";
$port = "11026";
$dbname = "railway";
$user = "postgres";
$password = "ahkeeWCgaSncnVuWeZCzwSZZckRTfmQw";

// Cadena de conexión
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Establecer la conexión
$conn = pg_connect($conn_string);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Procesar el formulario para cambiar el estado del LED
if (isset($_POST['toggle_LED'])) {
    $sql = "SELECT * FROM estado WHERE id = 1;";
    $result = pg_query($conn, $sql);

    if ($result) {
        $row = pg_fetch_assoc($result);

        if ($row['estado'] == 0) {
            $update = pg_query($conn, "UPDATE estado SET estado = 1 WHERE id = 1;");
        } else {
            $update = pg_query($conn, "UPDATE estado SET estado = 0 WHERE id = 1;");
        }
    }
}

// Obtener el estado actual del LED
$sql = "SELECT * FROM estado WHERE id = 1;";
$result = pg_query($conn, $sql);
$row = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .wrapper {
            width: 100%;
            padding-top: 50px;
        }
        .col_3 {
            width: 33.3333333%;
            float: left;
            min-height: 1px;
        }
        #submit_button {
            background-color: #2bbaff;
            color: #FFF;
            font-weight: bold;
            font-size: 40px;
            border-radius: 15px;
            text-align: center;
        }
        .led_img {
            height: 400px;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }
        @media only screen and (max-width: 600px) {
            .col_3 {
                width: 100%;
            }
            .wrapper {
                width: 100%;
                padding-top: 5px;
            }
            .led_img {
                height: 300px;
                width: 80%;
                margin-right: 10%;
                margin-left: 10%;
                object-fit: cover;
                object-position: center;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper" id="refresh">
        <div class="col_3"></div>
        <div class="col_3">
            <?php echo '<h1 style="text-align: center;">The status of the LED is: ' . $row['estado'] . '</h1>'; ?>
            <div class="col_3"></div>
            <div class="col_3" style="text-align: center;">
                <form action="index.php" method="post" id="LED" enctype="multipart/form-data">
                    <input id="submit_button" type="submit" name="toggle_LED" value="Toggle LED" />
                </form>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var updater = setTimeout(function () {
                            $('div#refresh').load('index.php', 'update=true');
                        }, 1000);
                    });
                </script>
                <br><br>
                <?php if ($row['estado'] == 0) { ?>
                    <div class="led_img">
                        <img id="contest_img" src="led_off.png" width="100%" height="100%">
                    </div>
                <?php } else { ?>
                    <div class="led_img">
                        <img id="contest_img" src="led_on.png" width="100%" height="100%">
                    </div>
                <?php } ?>
            </div>
            <div class="col_3"></div>
        </div>
        <div class="col_3"></div>
    </div>
</body>
</html>