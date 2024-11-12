<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "todo_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$today = date('Y-m-d');
$sql = "SELECT users.email, tasks.text AS task_text, tasks.id AS task_id FROM tasks 
        JOIN users ON tasks.user_id = users.id 
        WHERE tasks.due_date = '$today' AND tasks.notified = FALSE";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $taskText = $row['task_text'];
        $taskId = $row['task_id'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '<Add Your Email>'; // Replace with your Gmail address
            $mail->Password = '<Add Your Password>'; // Replace with your app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('<Add Your Email>', 'To-Do List App');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Task Reminder';
            $mail->Body = "Hello,<br><br>Your task \"<strong>$taskText</strong>\" is due today.<br><br>Best Regards,<br>To-Do List App";

            $mail->send();

            // Mark the task as notified
            $updateSql = "UPDATE tasks SET notified = TRUE WHERE id = $taskId";
            $conn->query($updateSql);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
} else {
    echo "No reminders to send today.";
}

$conn->close();
?>
