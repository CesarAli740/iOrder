<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if($rol != '4'){
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>
<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Empleado</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .welcome-message {
            font-size: 5rem;
            text-align: center;
            color:white;
        }
    </style>
</head>

<body>
    <div class="welcome-message">
        <p>¡Bienvenido Empleado!</p>
    </div>
</body>

</html>