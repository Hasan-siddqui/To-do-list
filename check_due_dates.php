<?php
session_start();
require 'db.php';

$user_id = $_GET['user_id'];
$today = $_GET['date'];

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND due_date = ? AND notified = 0");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($task = $result->fetch_assoc()) {
    $tasks[] = $task;
}

echo json_encode($tasks);
?>
