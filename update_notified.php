<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['id'];
    $notified = $_POST['notified'] === 'true' ? 1 : 0;

    $stmt = $conn->prepare("UPDATE tasks SET notified = ? WHERE id = ?");
    $stmt->bind_param("ii", $notified, $task_id);
    if ($stmt->execute()) {
        echo "Task notification updated!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
