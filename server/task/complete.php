<?php
require '../commons/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $db->prepare("SELECT complete FROM task.task WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        $newStatus = $task['complete'] ? 0 : 1;

        $update = $db->prepare("UPDATE task.task SET complete = :newStatus WHERE id = :id");
        $update->execute(['newStatus' => $newStatus, 'id' => $id]);

        echo json_encode(['status' => 'ok', 'newStatus' => $newStatus]);
    } else {
        echo json_encode(['status' => 'error', 'error' => 'Tarea no encontrada']);
    }
} else {
    echo json_encode(['status' => 'error', 'error' => 'ID no proporcionado']);
}
?>