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






