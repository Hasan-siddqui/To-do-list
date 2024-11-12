<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Signup for the To-Do List App to manage and organize your tasks efficiently.">
    <meta name="keywords" content="signup, to-do list, task manager, productivity, register">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Your Name">

    <!-- Open Graph Meta Tags for Social Sharing -->
    <meta property="og:title" content="Signup - To-Do List App">
    <meta property="og:description" content="Sign up to create your account and start managing your tasks.">
    <meta property="og:image" content="path/to/your/logo.jpg">
    <meta property="og:url" content="http://yourwebsite.com/signup">
    <meta name="twitter:card" content="summary_large_image">

    <title>Signup - To-Do List App</title>

    <!-- CSS Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            max-width: 400px;
            margin: 40px auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h2>Signup</h2>
    <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">Signup</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>

</body>

</html>

<?php
if (isset($_POST['signup'])) {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "todo_app");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkQuery = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists. <a href='signup.php'>Try again</a>";
    } else {
        // Insert new user if no duplicate found
        $sql = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $username, $email, $password);
        
        if ($sql->execute()) {
            echo "Registration successful. <a href='login.php'>Login now</a>";
        } else {
            echo "Error: " . $sql->error;
        }

        $sql->close(); // Close only if $sql is defined
    }

    // Close other connections
    $checkQuery->close();
    $conn->close();
}
?>
