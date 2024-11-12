<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['id'];
    $task_text = $_POST['text'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("UPDATE tasks SET text = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param("ssi", $task_text, $due_date, $task_id);
    if ($stmt->execute()) {
        echo "Task updated!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
