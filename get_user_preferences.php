<?php
// get_user_preferences.php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false, 
        'error' => 'Usuario no autenticado',
        'preferences' => [
            'theme' => 'light',
            'default_sound' => 'img/timbre.mp3'
        ]
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT theme, default_sound, last_updated FROM user_preferences WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $preferences = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'preferences' => [
                'theme' => $preferences['theme'],
                'default_sound' => $preferences['default_sound'],
                'last_updated' => $preferences['last_updated']
            ]
        ]);
    } else {
        // Crear preferencias por defecto
        $insertQuery = "INSERT INTO user_preferences (user_id, theme, default_sound) VALUES (?, 'light', 'img/timbre.mp3')";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("i", $user_id);
        $insertStmt->execute();
        $insertStmt->close();
        
        echo json_encode([
            'success' => true,
            'preferences' => [
                'theme' => 'light',
                'default_sound' => 'img/timbre.mp3',
                'last_updated' => date('Y-m-d H:i:s')
            ]
        ]);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error obteniendo preferencias: ' . $e->getMessage(),
        'preferences' => [
            'theme' => 'light',
            'default_sound' => 'img/timbre.mp3'
        ]
    ]);
}

$conn->close();
?>