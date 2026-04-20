<?php
require_once 'assets/db.php';

// Para una API, retornamos JSON en vez de redirigir si no hay sesión
if (!isset($_SESSION['socio_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

$socio_id = $_SESSION['socio_id'];
$action = $_REQUEST['action'] ?? 'get';

header('Content-Type: application/json');

try {
    if ($action === 'get') {
        // Obtener historial de notificaciones (últimas 10)
        $stmt = $pdo->prepare("SELECT id, titulo, mensaje, leido, fecha_creacion FROM notificaciones WHERE socio_id = ? ORDER BY fecha_creacion DESC LIMIT 10");
        $stmt->execute([$socio_id]);
        $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener recuento de no leídas
        $stmtCount = $pdo->prepare("SELECT COUNT(*) as unread_count FROM notificaciones WHERE socio_id = ? AND leido = 0");
        $stmtCount->execute([$socio_id]);
        $unread = $stmtCount->fetch(PDO::FETCH_ASSOC)['unread_count'];

        echo json_encode([
            'status' => 'success',
            'notificaciones' => $notificaciones,
            'unread_count' => $unread
        ]);
        exit;
    }

    if ($action === 'mark_read') {
        $notif_id = $_REQUEST['id'] ?? 'all';
        if ($notif_id === 'all') {
            $stmt = $pdo->prepare("UPDATE notificaciones SET leido = 1 WHERE socio_id = ? AND leido = 0");
            $stmt->execute([$socio_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE notificaciones SET leido = 1 WHERE socio_id = ? AND id = ? AND leido = 0");
            $stmt->execute([$socio_id, $notif_id]);
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Notificaciones marcadas como leídas']);
        exit;
    }

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
    exit;
}

// Fallback
echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
