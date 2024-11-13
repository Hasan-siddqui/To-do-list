# To-Do List App

## Special Features
The To-Do List App allows users to manage tasks with the following key features:
- **User Authentication**: Login and Registration functionality.
- **Task Management**: Users can add, edit, delete, and mark tasks as completed.
- **Due Date Reminders**: Task reminders are sent via email when a task is due today.
- **Task Filtering**: Tasks can be filtered by status (All, Pending, Completed).
- **Real-time Notifications**: Task due reminders are sent through email.

## Set Up the Database

To set up the database for the To-Do List App, follow these steps:

1. **Create a Database**:
   - Open your MySQL database management tool (like phpMyAdmin).
   - Create a new database called `todo_app`.

2. **Create Users Table**:
   Run the following SQL command to create a `users` table for storing user credentials and email information.

   ```sql
   CREATE TABLE users (
       id INT(11) AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(255) NOT NULL,
       password VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
3. Create Tasks Table: Run the following SQL command to create a tasks table to store the tasks.<br>
  ```sql
  CREATE TABLE tasks (<br>
    id INT(11) AUTO_INCREMENT PRIMARY KEY,<br>
    user_id INT(11) NOT NULL,<br>
    task_text VARCHAR(255) NOT NULL,<br>
    due_date DATE NULL,<br>
    completed TINYINT(1) DEFAULT 0,<br>
    notified TINYINT(1) DEFAULT 0,<br>
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,<br>
    FOREIGN KEY (user_id) REFERENCES users(id)<br>
);

**Table Details:**

**id:** Primary key, auto-incremented.<br>
**user_id:** Foreign key referencing users.id.<br>
**task_text:** The task description.<br>
**due_date:** The due date of the task.<br>
**completed:** A flag indicating whether the task is completed (1 for true, 0 for false).<br>
**notified:** A flag to track whether the task has been notified via email (1 for notified, 0 for not notified).<br>
**created_at:** Timestamp for when the task was created.<br>
**Import Database:** If you're using phpMyAdmin, simply copy and paste the above SQL commands into the SQL tab and execute them.<br>

**Set Up PHPMailer**
The app uses PHPMailer to send email reminders for tasks that are due today. Here’s how to set up PHPMailer:

**1. Install PHPMailer**
You can install PHPMailer using Composer (recommended) or manually.

**Using Composer:**
Run the following command to install PHPMailer:

composer require phpmailer/phpmailer

**Manual Installation:**
Download the latest release of PHPMailer from GitHub and place the files in your project.

**2. Configure PHPMailer**
In your PHP scripts (e.g., send_reminders.php), configure PHPMailer to use SMTP for sending emails.

Example PHPMailer Configuration (Gmail SMTP):
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com'; // Replace with your Gmail address
    $mail->Password = 'your_app_password'; // Replace with your Gmail App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'To-Do List App');
    $mail->addAddress($email); // Recipient's email

    $mail->isHTML(true);
    $mail->Subject = 'Task Reminder';
    $mail->Body = "Hello,<br><br>Your task \"<strong>$taskText</strong>\" is due today.<br><br>Best Regards,<br>To-Do List App";

    $mail->send();
    echo 'Reminder email sent!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

**3. Enable Gmail SMTP and App Passwords**
Gmail requires two-step verification and the use of App Passwords for sending emails via SMTP.

**Steps to Enable:**
Enable 2-Step Verification:
Go to Google's Account Settings and enable 2-Step Verification.

**Generate App Password:**

**Go to the App Passwords page.**
Select "Mail" under "Select app" and "Other" for the device.
Enter a custom name (e.g., "PHPMailer") and click "Generate".
Use the generated 16-character password in place of your regular Gmail password in the $mail->Password field.

**4. Test PHPMailer Configuration**
You can test the PHPMailer configuration by sending a test email using a small script:

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
    $mail->Password = 'your_app_password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'Test Email');
    $mail->addAddress('recipient_email@example.com');

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email to check PHPMailer configuration.';

    $mail->send();
    echo 'Test email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
