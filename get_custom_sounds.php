<?php
include 'conexion.php';

header('Content-Type: application/json');

$query = "SELECT id, original_name, file_path FROM custom_sounds WHERE is_active = 1 ORDER BY upload_date DESC";
$result = $conn->query($query);

$sounds = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sounds[] = [
            'id' => $row['id'],
            'name' => $row['original_name'],
            'path' => $row['file_path']
        ];
    }
}

echo json_encode($sounds);
$conn->close();
?>