<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Manage your tasks and stay organized with our To-Do List App. Create, update, and track your tasks effortlessly.">
    <meta name="keywords" content="to-do list, task manager, productivity, tasks, personal organizer">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Your Name">
    
    <!-- Open Graph Meta Tags for Social Sharing -->
    <meta property="og:title" content="To-Do List App - Manage Tasks Effectively">
    <meta property="og:description" content="Easily manage your tasks with our to-do list app. Stay organized and never forget a task again!">
    <meta property="og:image" content="path/to/image.jpg">
    <meta property="og:url" content="http://yourwebsite.com">
    <meta name="twitter:card" content="summary_large_image">
    <title>Task Manager & To-Do List App - Stay Organized and Productive</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div id="app">
        <h1>To-Do List</h1>
        <p class="login-info">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a
                href="logout.php">Logout</a></p>

        <div class="input-group">
            <input type="text" id="taskInput" placeholder="Add a new task...">
            <input type="date" id="taskDate">
            <button id="addTaskBtn">Add Task</button>
        </div>

        <div class="filter-group">
            <button class="filter-btn" data-filter="all">All</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
        </div>

        <ul id="taskList"></ul>
    </div>

    <script>
    const user_id = <?php echo json_encode($user_id); ?>;

    document.addEventListener('DOMContentLoaded', () => {
        fetchTasks();
        setupEventListeners();
        requestNotificationPermission();
        setInterval(checkTaskDueDates, 60000);
    });

    const fetchTasks = async (filter = 'all') => {
        try {
            const response = await fetch(`fetch_tasks.php?user_id=${user_id}&filter=${filter}`);
            if (!response.ok) throw new Error("Failed to fetch tasks");

            const tasks = await response.json();

            // Ensure tasks is an array before passing it to renderTasks
            if (Array.isArray(tasks)) {
                renderTasks(tasks);
            } else {
                console.error("Unexpected data format:", tasks);
            }
        } catch (error) {
            console.error(error);
            alert("Error fetching tasks. Check console for details.");
        }
    };


    const addTask = async () => {
        const taskText = document.getElementById('taskInput').value.trim();
        const dueDate = document.getElementById('taskDate').value;

        if (!taskText) return alert("Please enter a task");

        try {
            await fetch('save_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `user_id=${user_id}&task_text=${encodeURIComponent(taskText)}&due_date=${encodeURIComponent(dueDate)}`
            });

            fetchTasks();
            clearTaskInputs();
        } catch (error) {
            console.error("Error adding task:", error);
        }
    };

    const deleteTask = async (id) => {
        try {
            await fetch('delete_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            });
            fetchTasks();
        } catch (error) {
            console.error("Error deleting task:", error);
        }
    };

    const toggleTask = async (id) => {
        try {
            await fetch('toggle_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            });
            fetchTasks();
        } catch (error) {
            console.error("Error toggling task:", error);
        }
    };

    const filterTasks = (event) => {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        fetchTasks(event.target.dataset.filter);
    };

    const checkTaskDueDates = async () => {
        const today = new Date().toISOString().split("T")[0];
        try {
            const response = await fetch(`check_due_dates.php?user_id=${user_id}&date=${today}`);
            const tasks = await response.json();

            tasks.forEach(task => {
                if (!task.notified) {
                    showNotification(task.text);
                    markTaskAsNotified(task.id);
                }
            });
        } catch (error) {
            console.error("Error checking due dates:", error);
        }
    };

    const showNotification = (taskText) => {
        if (Notification.permission === "granted") {
            new Notification("Task Reminder", {
                body: `Your task "${taskText}" is due today!`
            });
        }
    };

    const markTaskAsNotified = async (id) => {
        try {
            await fetch('update_notified.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&notified=true`
            });
        } catch (error) {
            console.error("Error marking task as notified:", error);
        }
    };

    const setupEventListeners = () => {
        document.getElementById('addTaskBtn').addEventListener('click', addTask);
        document.querySelectorAll('.filter-btn').forEach(btn => btn.addEventListener('click', filterTasks));
    };

    const requestNotificationPermission = () => {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
    };

    const renderTasks = (tasks) => {
        const taskList = document.getElementById('taskList');
        taskList.innerHTML = '';
        tasks.forEach(task => {
            const taskItem = document.createElement('li');
            const taskText = task.text || '';
            const dueDate = task.due_date || '';
            const completed = task.completed ? 'completed' : '';

            taskItem.classList.add('task-item');
            if (completed) taskItem.classList.add(completed);

            taskItem.innerHTML = `
            <span class="task-text">${taskText} ${dueDate ? ` - Due: ${dueDate}` : ''}</span>
            <input type="text" class="edit-input" style="display:none;" value="${taskText}">
            <input type="date" class="edit-date" style="display:none;" value="${dueDate}">
            <div class="crud-btn">
            <input type="checkbox" ${task.completed ? 'checked' : ''} onclick="toggleTask(${task.id})">
            <button class="edit-btn" onclick="editTask(${task.id}, this)"><i class="fa fa-edit"></i></button>
            <button class="delete-btn" onclick="deleteTask(${task.id})">&times;</button>
            </div>
        `;
            taskList.appendChild(taskItem);
        });
    };

    function editTask(id, editBtn) {
        const taskItem = editBtn.closest('.task-item');
        const taskText = taskItem.querySelector('.task-text');
        const editInput = taskItem.querySelector('.edit-input');
        const editDate = taskItem.querySelector('.edit-date');

        // Toggle between edit and view mode
        if (editInput.style.display === 'none') {
            editInput.style.display = 'inline';
            editDate.style.display = 'inline';
            taskText.style.display = 'none';
            editBtn.innerHTML  = '<i class="fa fa-save"></i>';
        } else {
            // Save the updated task text and due date
            const newText = editInput.value.trim();
            const newDueDate = editDate.value;

            if (newText === '') {
                alert("Task text cannot be empty!");
                return;
            }

            updateTask(id, newText, newDueDate).then(() => {
                fetchTasks(); // Refresh the list after editing
            });

            editInput.style.display = 'none';
            editDate.style.display = 'none';
            taskText.style.display = 'inline';
            editBtn.textContent = 'Edit';
        }
    }
    const updateTask = async (id, newText, newDueDate) => {
        try {
            await fetch('update_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&text=${encodeURIComponent(newText)}&due_date=${encodeURIComponent(newDueDate)}`
            });
        } catch (error) {
            console.error("Error updating task:", error);
        }
    };


    const clearTaskInputs = () => {
        document.getElementById('taskInput').value = '';
        document.getElementById('taskDate').value = '';
    };
    </script>
</body>

</html>