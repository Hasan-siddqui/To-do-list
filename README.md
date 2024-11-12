To-Do List App with Task Reminders
Overview
This application allows users to manage their tasks by adding, updating, deleting, and filtering tasks. It also sends email reminders to users about tasks that are due on the current day. The app is built using PHP, MySQL, JavaScript (for the frontend), and PHPMailer for email functionality.

Requirements
1. Software Requirements:
PHP version 7.4 or higher
MySQL or MariaDB database server
XAMPP or WAMP (for running PHP and MySQL locally)
PHPMailer (for sending emails)
2. Email Setup:
Gmail account or an app-specific password (for sending emails securely via Gmail SMTP)
3. Folder Structure:
index.php: Main page where the to-do list and task management interface is displayed.
save_task.php: Handles saving new tasks to the database.
fetch_tasks.php: Fetches tasks from the database to be displayed on the main page.
delete_task.php: Handles deleting a task from the database.
toggle_task.php: Marks a task as completed or pending.
send_reminders.php: Sends email reminders for tasks that are due today.
update_notified.php: Marks tasks as notified after sending email reminders.
login.php and logout.php: Handle user login and logout functionality.
style.css: Custom CSS file for styling the application.

Step-by-Step Installation Guide
Step 1: Clone or Download the Repository
If you are using a version control system like Git:

bash
Copy code
git clone https://your-repository-url.git
Alternatively, you can download the ZIP file and extract it into your local server directory (e.g., htdocs for XAMPP).

Step 2: Set Up the Database
Create a Database: Open phpMyAdmin (or any MySQL management tool) and create a new database called todo_app.

Create the Users Table: Execute the following SQL to create the users table:

sql
Copy code
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
Create the Tasks Table: Execute the following SQL to create the tasks table:

sql
Copy code
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    text VARCHAR(255) NOT NULL,
    due_date DATE DEFAULT NULL,
    completed TINYINT(1) DEFAULT 0,
    notified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
Insert Sample Data (Optional): You can manually add some users and tasks into the users and tasks tables.

Step 3: Configure PHP Mailer
Download PHPMailer: Download PHPMailer from the official GitHub repository or use Composer to install it:

bash
Copy code
composer require phpmailer/phpmailer
Gmail Configuration: To send emails, you'll need a Gmail account with an app-specific password. Follow these steps:

Go to your Google Account settings.
Navigate to Security and enable 2-Step Verification.
Create an App Password (under App passwords) specifically for this app.
Replace the Username and Password values in the send_reminders.php script with your Gmail address and the generated app password.
Note: Make sure you replace 'your_email@gmail.com' and 'your_app_specific_password' in send_reminders.php.

Step 4: Set Up the PHP Application
Database Connection:
Ensure your database connection details are correct in send_reminders.php and other PHP files where database interaction is required.

Example:

php
Copy code
$conn = new mysqli("localhost", "root", "", "todo_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
Frontend (HTML, CSS, JS): The index.php file contains the front-end logic of the app. Ensure that the user interface has the following elements:

A task input form to add tasks.
A list displaying the tasks with options to edit, delete, or mark tasks as completed.
Task filters to view all, completed, or pending tasks.
In style.css, you can customize the design to your liking.

Step 5: Test the Application
Start Your Server: If you are using XAMPP or WAMP, start the Apache and MySQL services.

Run the Application: Navigate to http://localhost/todo_app/ in your web browser to see the To-Do List app in action.

Step 6: Email Reminders
Automate Email Reminders: Set up a cron job (Linux/Mac) or Task Scheduler (Windows) to run send_reminders.php at a specific time every day (e.g., at 9 AM) to send task reminders.

Cron Job Example (Linux/Mac): Add the following cron job to send email reminders every day at 9 AM:

bash
Copy code
0 9 * * * /usr/bin/php /path/to/your/todo_app/send_reminders.php
Windows Task Scheduler: Create a new task to run send_reminders.php daily at your desired time.

Troubleshooting
Error: SMTP Error: Could not authenticate:

Ensure that you’re using the correct Gmail address and app password.
Make sure that Less Secure Apps is enabled in your Google Account settings (if not using 2-Step Verification).
Error: Unknown column 'tasks.task_text':

Ensure that the column names in your database match the ones referenced in the queries. For example, use tasks.text instead of tasks.task_text.
Task Reminders Not Sending:

Double-check that send_reminders.php is being run correctly either via the browser or as part of a cron job.
Ensure that tasks have a due_date set to today's date in the database.
Contributing
If you want to contribute to this project, feel free to submit a pull request or open an issue.

License
This project is open source and available under the MIT License.

Conclusion
This application allows users to manage tasks, set due dates, and receive email notifications for tasks that are due. You can extend this app by adding features such as user registration, authentication, and more advanced filtering options.

Let me know if you need further clarification or assistance!

Database Details
1. Database Name: todo_app
This is the main database for the application. It stores users and tasks data.

2. Tables:
The application uses two main tables: users and tasks.

a. users Table
This table stores the user information for the To-Do List App.

Column Name	Data Type	Description
id	INT(11)	Primary key, Auto Increment
email	VARCHAR(255)	User's email address
password	VARCHAR(255)	User's hashed password
SQL to create the users table:

sql
Copy code
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
b. tasks Table
This table stores the tasks associated with each user.

Column Name	Data Type	Description
id	INT(11)	Primary key, Auto Increment
user_id	INT(11)	Foreign key, links to users.id
text	VARCHAR(255)	The text/description of the task
due_date	DATE	The date the task is due
completed	TINYINT(1)	Status of task (0 = Pending, 1 = Completed)
notified	TINYINT(1)	Flag to indicate if reminder email was sent (0 = No, 1 = Yes)
created_at	TIMESTAMP	Timestamp of when the task was created
SQL to create the tasks table:

sql
Copy code
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    text VARCHAR(255) NOT NULL,
    due_date DATE DEFAULT NULL,
    completed TINYINT(1) DEFAULT 0,
    notified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
3. Database Sample Data
You can manually insert some sample data into the database to test the application:

Sample Users:
sql
Copy code
INSERT INTO users (email, password) VALUES 
('user1@example.com', 'password1'), 
('user2@example.com', 'password2');
Sample Tasks:
sql
Copy code
INSERT INTO tasks (user_id, text, due_date, completed, notified) VALUES
(1, 'Complete the PHP project', '2024-11-12', 0, 0),
(2, 'Attend the team meeting', '2024-11-12', 0, 0),
(1, 'Submit the report', '2024-11-13', 0, 0);
4. Foreign Key Relationships
The tasks table has a foreign key (user_id) that references the id column in the users table. This establishes a relationship between users and their tasks, ensuring that each task is associated with a specific user.


PHPMailer Setup
To enable email notifications for task reminders, this application uses PHPMailer to send email reminders. Here are the steps to configure and use PHPMailer:

1. Install PHPMailer
To use PHPMailer, you need to have the PHPMailer library in your project. You can either manually download it or use Composer to install it.

Using Composer:
Run the following command in the terminal to install PHPMailer via Composer:

bash
Copy code
composer require phpmailer/phpmailer
This will install PHPMailer and its dependencies in your project.

Manual Installation:
You can download the latest PHPMailer from the official GitHub repository:

GitHub: https://github.com/PHPMailer/PHPMailer
Once downloaded, include the PHPMailer files in your project.

2. Configure PHPMailer
In order to send emails, you need to configure the PHPMailer SMTP settings correctly. The following code snippet should be placed in your send_reminders.php or equivalent script to send task reminders.

SMTP Configuration for Gmail:

php
Copy code
$mail = new PHPMailer(true);
try {
    // Set mailer to use SMTP
    $mail->isSMTP();

    // Define SMTP server settings
    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
    $mail->SMTPAuth = true;          // Enable SMTP authentication
    $mail->Username = 'your_email@gmail.com';  // Your Gmail address
    $mail->Password = 'your_app_password';     // App-specific password generated by Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use STARTTLS encryption
    $mail->Port = 587;  // Use port 587 for TLS encryption

    // Set sender and recipient details
    $mail->setFrom('your_email@gmail.com', 'To-Do List App');  // From email address
    $mail->addAddress($email);  // Add recipient email

    // Set email content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Task Reminder';
    $mail->Body = "Hello,<br><br>Your task \"<strong>$taskText</strong>\" is due today.<br><br>Best Regards,<br>To-Do List App";

    // Send the email
    $mail->send();

    echo 'Reminder email sent!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
3. Google App Passwords
Since Gmail no longer supports basic authentication (username and password), you'll need to use App Passwords for better security. Follow these steps to create an app password:

Enable 2-Step Verification: Go to your Google Account and enable 2-Step Verification if it’s not already enabled.
Generate App Password:
Go to the App Passwords page.
Under "Select app", choose "Mail", and under "Select device", choose "Other (Custom name)".
Enter a custom name like "PHP Mailer", and click "Generate".
You’ll be given a 16-character app password that you will use in place of your Gmail account password in the $mail->Password field.
4. Email Body Customization
You can customize the email body by editing the $mail->Body property. You can use HTML tags to make the email content more readable or add custom branding.

For example:

php
Copy code
$mail->Body = "<h1>Task Reminder</h1><p>Your task <strong>$taskText</strong> is due today.</p>";
5. Testing PHPMailer Configuration
Before running the live reminders, you should test your PHPMailer configuration. You can create a simple PHP script to check if PHPMailer sends emails correctly. Use the following script for testing:

php
Copy code
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
    $mail->addAddress('test_recipient@example.com');

    $mail->isHTML(true);
    $mail->Subject = 'Test PHPMailer';
    $mail->Body = 'This is a test email to check PHPMailer configuration.';

    $mail->send();
    echo 'Test email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
This will help you verify that the email settings are working before you deploy the reminder emails.

6. Security Considerations
Never expose sensitive credentials: Make sure your Gmail password and app password are not hard-coded in the source code. You can store them securely using environment variables or a configuration file outside of your web root.
Gmail sending limits: Be aware of Gmail’s sending limits. If you plan to send a lot of emails, you might hit a sending quota. Google has limits on how many emails can be sent per day using SMTP. If you are sending reminders to many users, you might want to consider using a dedicated email sending service such as SendGrid or Mailgun.
7. Troubleshooting PHPMailer Errors
If PHPMailer is not sending emails, check for the following common issues:

Incorrect username or password: Ensure your Gmail username and app-specific password are correct.
Two-step verification: Make sure 2-step verification is enabled for your Google account.
Less secure apps: Make sure "Less secure app access" is enabled, or better yet, use app passwords as described above.
Blocked ports: Make sure your hosting provider is not blocking the SMTP ports required for email sending (587 for TLS).







