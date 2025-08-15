<?php
include 'conexion.php';

$horario_id = $_POST['horario_id'];
$tipo = $_POST['tipo'];
$horas = $_POST['horas']; // Ya es un array

$stmt = $conn->prepare("INSERT INTO horarios (tipo, horario_id, hora) VALUES (?, ?, ?)");

foreach ($horas as $hora) {
    $hora = trim($hora);
    if (!empty($hora) && preg_match('/^\d{2}:\d{2}$/', $hora)) {
        $stmt->bind_param("sis", $tipo, $horario_id, $hora);
        $stmt->execute();
    }
}

$stmt->close();
$conn->close();

header("Location: timbre_primaria.html");
exit();
?>
