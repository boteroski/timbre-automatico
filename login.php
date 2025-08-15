<?php
// login.php
session_start();
include 'conexion.php'; // contiene conexión a la BD

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    
    // Cargar preferencias del usuario
    $prefQuery = "SELECT theme, default_sound FROM user_preferences WHERE user_id = ?";
    $prefStmt = $conn->prepare($prefQuery);
    $prefStmt->bind_param("i", $user['id']);
    $prefStmt->execute();
    $prefResult = $prefStmt->get_result();
    
    if ($prefResult->num_rows === 1) {
        $preferences = $prefResult->fetch_assoc();
        $_SESSION['user_theme'] = $preferences['theme'];
        $_SESSION['user_sound'] = $preferences['default_sound'];
    } else {
        // Crear preferencias por defecto si no existen
        $createPrefQuery = "INSERT INTO user_preferences (user_id, theme, default_sound) VALUES (?, 'light', 'img/timbre.mp3')";
        $createPrefStmt = $conn->prepare($createPrefQuery);
        $createPrefStmt->bind_param("i", $user['id']);
        $createPrefStmt->execute();
        $createPrefStmt->close();
        
        $_SESSION['user_theme'] = 'light';
        $_SESSION['user_sound'] = 'img/timbre.mp3';
    }
    
    $prefStmt->close();
    
    header("Location: timbre_unificado.html");
    exit();
} else {
    header("Location: index.php?error=1");
    exit();
}

$stmt->close();
$conn->close();
?>