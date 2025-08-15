<?php
// save_preferences.php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['type']) || !isset($input['value'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$type = $input['type'];
$value = $input['value'];

// Validar tipos permitidos
$allowedTypes = ['theme', 'sound'];
if (!in_array($type, $allowedTypes)) {
    echo json_encode(['success' => false, 'error' => 'Tipo de preferencia no válido']);
    exit;
}

try {
    // Verificar si ya existe una preferencia para este usuario
    $checkStmt = $conn->prepare("SELECT id FROM user_preferences WHERE user_id = ?");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        // Actualizar preferencia existente
        if ($type === 'theme') {
            $updateStmt = $conn->prepare("UPDATE user_preferences SET theme = ?, last_updated = NOW() WHERE user_id = ?");
            $updateStmt->bind_param("si", $value, $user_id);
        } else if ($type === 'sound') {
            $updateStmt = $conn->prepare("UPDATE user_preferences SET default_sound = ?, last_updated = NOW() WHERE user_id = ?");
            $updateStmt->bind_param("si", $value, $user_id);
        }
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Crear nueva preferencia
        $insertStmt = $conn->prepare("INSERT INTO user_preferences (user_id, theme, default_sound) VALUES (?, ?, ?)");
        $defaultTheme = ($type === 'theme') ? $value : 'light';
        $defaultSound = ($type === 'sound') ? $value : 'img/timbre.mp3';
        $insertStmt->bind_param("iss", $user_id, $defaultTheme, $defaultSound);
        $insertStmt->execute();
        $insertStmt->close();
    }
    
    $checkStmt->close();
    echo json_encode(['success' => true, 'message' => 'Preferencia guardada correctamente']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error guardando preferencia: ' . $e->getMessage()]);
}

$conn->close();
?>