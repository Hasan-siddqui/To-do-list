<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    if ($stmt->execute()) {
        echo "Task deleted!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
