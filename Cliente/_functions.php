<?php
include '../includes/_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $fecha_hora = $fecha . ' ' . $hora;
    $mesaId = $_POST['mesaId'];

    $sqlReserva = "INSERT INTO reservas (cliente_nombre, cliente_email, cliente_telefono, fecha_hora_reserva, mesa_id) VALUES ('$nombre', '$email', '$telefono', '$fecha_hora', '$mesaId')";
    $query = "UPDATE mesas SET estado = 'reservado' WHERE id = $mesaId;";
    $conexion->query($query);
    if ($conexion->query($sqlReserva) === TRUE) {
        // La reserva se ha insertado correctamente en la base de datos
        header("Location: index.php"); // Redirigir a una página de confirmación
        exit();
    } else {
        // Hubo un error al insertar la reserva
        echo "Error al insertar la reserva: " . $conexion->error;
    }
}

?>