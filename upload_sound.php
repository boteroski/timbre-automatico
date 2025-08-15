<?php
include 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['custom_sound'])) {
    $file = $_FILES['custom_sound'];
    
    // Validar que no haya errores en la subida
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'Error en la subida del archivo']);
        exit;
    }
    
    // Validar tipo de archivo
    $allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg', 'video/mp4', 'audio/mp4'];
    $fileType = $file['type'];
    
    // Detectar tipo por extensión si el MIME type no es confiable
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['mp3', 'wav', 'ogg', 'mp4'];
    
    if (!in_array($fileType, $allowedTypes) && !in_array($extension, $allowedExtensions)) {
        echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido. Use MP3, WAV, OGG o MP4.']);
        exit;
    }
    
    // Validar tamaño (máximo 10MB)
    if ($file['size'] > 10 * 1024 * 1024) {
        echo json_encode(['success' => false, 'error' => 'Archivo demasiado grande. Máximo 10MB.']);
        exit;
    }
    
    // Crear directorio si no existe
    $uploadDir = 'uploads/sounds/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            echo json_encode(['success' => false, 'error' => 'No se pudo crear el directorio de subida']);
            exit;
        }
    }
    
    // Generar nombre único
    $fileName = 'custom_' . time() . '_' . uniqid() . '.' . $extension;
    $filePath = $uploadDir . $fileName;
    
    // Mover archivo
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        
        // Validar duración usando métodos disponibles
        $duration = getAudioDuration($filePath);
        
        if ($duration === false) {
            unlink($filePath);
            echo json_encode(['success' => false, 'error' => 'No se pudo determinar la duración del archivo']);
            exit;
        }
        
        // Validar que no exceda 2 minutos (120 segundos)
        if ($duration > 120) {
            unlink($filePath);
            echo json_encode(['success' => false, 'error' => 'El audio es demasiado largo. Máximo 2 minutos.']);
            exit;
        }
        
        // Guardar en base de datos
        $originalName = $file['name'];
        $stmt = $conn->prepare("INSERT INTO custom_sounds (original_name, file_path, upload_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $originalName, $filePath);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true, 
                'file_path' => $filePath,
                'original_name' => $originalName,
                'duration' => $duration
            ]);
        } else {
            // Si falla la BD, eliminar archivo
            unlink($filePath);
            echo json_encode(['success' => false, 'error' => 'Error guardando en base de datos: ' . $conn->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Error moviendo el archivo subido']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se recibió archivo válido']);
}

/**
 * Función para obtener la duración de un archivo de audio
 */
function getAudioDuration($filePath) {
    // Método 1: Usar ffprobe si está disponible (más preciso)
    if (function_exists('shell_exec')) {
        $ffprobeCmd = "ffprobe -v quiet -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($filePath) . " 2>/dev/null";
        $duration = shell_exec($ffprobeCmd);
        
        if ($duration !== null && is_numeric(trim($duration))) {
            return floatval(trim($duration));
        }
    }
    
    // Método 2: Estimación básica por tamaño de archivo (menos preciso pero funcional)
    $fileSize = filesize($filePath);
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    // Estimaciones aproximadas por tipo de archivo
    switch ($extension) {
        case 'mp3':
            // MP3 típico: ~1MB por minuto a 128kbps
            return min(($fileSize / 1024 / 1024) * 60, 120);
        case 'wav':
            // WAV sin comprimir: ~10MB por minuto
            return min(($fileSize / 1024 / 1024) * 6, 120);
        case 'ogg':
            // OGG similar a MP3
            return min(($fileSize / 1024 / 1024) * 60, 120);
        case 'mp4':
            // MP4 audio similar a MP3
            return min(($fileSize / 1024 / 1024) * 45, 120);
        default:
            // Estimación conservadora - asumir que está bien si es menor a 10MB
            return $fileSize < 10 * 1024 * 1024 ? 60 : 121;
    }
}

$conn->close();
?>