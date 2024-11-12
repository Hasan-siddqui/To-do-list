<?php
session_start();
require 'db.php';

$user_id = $_GET['user_id'];
$filter = $_GET['filter'];

$query = "SELECT * FROM tasks WHERE user_id = ?";
if ($filter === "completed") {
    $query .= " AND completed = 1";
} elseif ($filter === "pending") {
    $query .= " AND completed = 0";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($task = $result->fetch_assoc()) {
    $tasks[] = $task;
}

echo json_encode($tasks);
?>
