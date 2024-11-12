<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $task_text = $_POST['task_text'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, text, due_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $task_text, $due_date);
    if ($stmt->execute()) {
        echo "Task added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
