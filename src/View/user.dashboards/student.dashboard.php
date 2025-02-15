<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* General Styles */
        body {
            width: 100vw;
            height: auto;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            background: #1e1e1e; /* VSCode Dark Mode Background */
            color: #d4d4d4; /* Light Text Color */
            transition: background 0.3s, color 0.3s;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
        }

        /* Header Styles */
        .header {
            background-color: #252526; /* VSCode Dark Mode Side Bar */
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #007acc; /* VSCode Accent Color */
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #252526; /* VSCode Dark Mode Side Bar */
            padding: 20px;
            width: 250px;
            min-height: 100vh;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #d4d4d4; /* Light Text Color */
            text-decoration: none;
            font-weight: bold;
        }

        .sidebar a:hover {
            color: #007acc; /* VSCode Accent Color */
        }

        /* Content Styles */
        .content {
            flex: 1;
            padding: 20px;
            background-color: #1e1e1e; /* VSCode Dark Mode Background */
        }

        h2 {
            border-bottom: 2px solid #007acc; /* VSCode Accent Color */
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #d4d4d4; /* Light Text Color */
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #d4d4d4; /* Light Text Color */
        }

        form input[type="text"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #d4d4d4; /* Light Border Color */
            border-radius: 5px;
            background-color: #333; /* Dark Input Background */
            color: #d4d4d4; /* Light Text Color */
        }

        form button {
            background-color: #007acc; /* VSCode Accent Color */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
        }

        form button:hover {
            background-color: #005fa3; /* Darker Accent */
        }

        /* Learning Materials */
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li a {
            color: #007acc; /* VSCode Accent Color */
            text-decoration: none;
        }

        ul li a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="header">
            <h1>Student Dashboard</h1>
        </header>
        <div class="sidebar">
            <ul>
                <li><a href="#submit-assignments">Submit Assignments</a></li>
                <li><a href="#complete-tasks">Complete Tasks</a></li>
                <li><a href="#message-teachers">Message Teachers</a></li>
                <li><a href="#learning-materials">Learning Materials</a></li>
            </ul>
        </div>
        <div class="content">
            <section id="submit-assignments">
                <h2>Submit Assignments</h2>
                <form>
                    <label for="assignment-title">Assignment Title:</label>
                    <input type="text" id="assignment-title" name="assignment-title" required>
                    <label for="assignment-file">File Attachment:</label>
                    <input type="file" id="assignment-file" name="assignment-file">
                    <button type="submit">Submit Assignment</button>
                </form>
            </section>
            <section id="complete-tasks">
                <h2>Complete Tasks</h2>
                <form>
                    <label for="task-title">Task Title:</label>
                    <input type="text" id="task-title" name="task-title" required>
                    <label for="task-details">Details:</label>
                    <textarea id="task-details" name="task-details" required></textarea>
                    <button type="submit">Complete Task</button>
                </form>
            </section>
            <section id="message-teachers">
                <h2>Message Teachers</h2>
                <form>
                    <label for="teacher-name">Teacher Name:</label>
                    <input type="text" id="teacher-name" name="teacher-name" required>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </section>
            <section id="learning-materials">
                <h2>Learning Materials</h2>
                <ul>
                    <li>Material 1: <a href="#">Download</a></li>
                    <li>Material 2: <a href="#">Download</a></li>
                    <li>Material 3: <a href="#">Download</a></li>
                </ul>
            </section>
        </div>
    </div>
</body>
</html>
