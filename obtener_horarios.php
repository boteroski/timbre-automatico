<?php
include 'conexion.php';

$tipo = $_GET['tipo'];
$response = [];

$query = "SELECT horario_id, GROUP_CONCAT(hora ORDER BY hora SEPARATOR ',') as horas 
          FROM horarios 
          WHERE tipo = ? 
          GROUP BY horario_id";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $tipo);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $response[] = [
        'horario_id' => $row['horario_id'],
        'horas' => explode(',', $row['horas'])
    ];
}

echo json_encode($response);
?>
