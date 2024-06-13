<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?" media="all">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="imagenes/favicon.png" rel="icon">
    <script type="text/javascript" src="js/conexion.js"></script>
    <script type="text/javascript" src="js/entradas.js"></script>
</head>

<body>
    <?php
    session_start();
    if (empty($_SESSION["rol"]) || !isset($_GET['butaca']) || !isset($_GET['pelicula']) || !isset($_GET['sala']) || !isset($_GET['fecha'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <div class="container">
        <div id="navbar" class="row">
            <div class="col-4 d-flex justify-content-center"><a href="index.php" class="activo" class="a">Inicio</a>
            </div>
            <div class="col-4 d-flex justify-content-center"><a href="cineWiki.php" class="a">CineWiki</a></div>
            <div class="col-4 d-flex justify-content-center"><a href="perfil.php" class="a">Perfil</a></div>
        </div>
        <div class="row">
        </div>
    </div>
</body>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/Exception.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";

$butaca = $_GET['butaca'];
$idPelicula = $_GET['pelicula'];
$sala = intval($_GET['sala']);
$fecha = $_GET['fecha'];

$inserEntrada = "INSERT INTO ENTRADAS (IDAPIPELICULA, IDSALA, CORREO, BUTACA, FECHA) VALUES (?, ?, ?, ?, ?)";

include ("conexion/conexion.php");
$c = new mysqli($servidor, $usuario, $contraseña, $basededatos);

if ($stmt = $c->prepare($inserEntrada)) {
    // Vincular parámetros y comprobar si hay errores
    $stmt->bind_param("sisss", $idPelicula, $sala, $_SESSION['correo'], $butaca, $fecha);

    if ($stmt->execute()) {

        // $mail = new PHPMailer(true);
        // $correo = $_SESSION['correo'];
        // try {
            // // Configuración del servidor
            // $mail->isSMTP();
            // $mail->Host = 'ssmtp.****.com'; // Servidor SMTP
            // $mail->SMTPAuth = true;
            // $mail->Username = '***********@gmail.com'; // SMTP username
            // $mail->Password = '********'; // SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // $mail->Port = 587; // Puerto TCP para conectarse

            // // Remitente
            // $mail->setFrom(''**********@@gmail.com', ''***********');

            // // Destinatarios
            // $mail->addAddress($correo, strstr($correo, '@', true));

            // // Contenido del correo
            // $mail->isHTML(true);
            // $mail->Subject = 'Entrada';
            // $mail->Body = 'Este es el contenido del correo en HTML <b>con formato</b>.';
            // $mail->AltBody = 'Este es el contenido del correo en texto plano para clientes que no soportan HTML.';

            // $mail->send();
            // echo 'Correo enviado correctamente';
            echo "<h3>Pago realizado correctamente, se ha enviado el código de tu entrada a " . $_SESSION['correo'] . "</h3>";
            echo "<h3>En breves instantes serás redirigido de vuelta al inicio</h3>";

            // Cerrar la conexión
            $stmt->close();
            $c->close();

            echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 5000);
              </script>';
        // } catch (Exception $e) {
        //     echo "Error al enviar el correo: {$mail->ErrorInfo}";
        // }


    } else {
        // Manejar el error en la ejecución de la consulta
        echo "<h3>Algo salió mal: " . $stmt->error . "</h3>";

        // Cerrar la conexión
        $stmt->close();
        $c->close();

        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 5000);
              </script>';
    }
} else {
    // Manejar el error en la preparación de la consulta
    echo "<h3>Algo salió mal</h3>";

    // Cerrar la conexión
    $c->close();

    echo '<script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 5000);
          </script>';
}
?>

</html>