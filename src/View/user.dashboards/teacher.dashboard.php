<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
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
        form input[type="number"],
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

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #d4d4d4; /* Light Border Color */
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #333; /* Dark Table Header Background */
        }

        table td {
            background-color: #252526; /* Dark Table Row Background */
            color: #d4d4d4; /* Light Text Color */
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="header">
            <h1>Teacher Dashboard</h1>
        </header>
        <div class="sidebar">
            <ul>
                <li><a href="#assignments">Assignments</a></li>
                <li><a href="#materials">Learning Materials</a></li>
                <li><a href="#grades">Grades</a></li>
                <li><a href="#attendance">Attendance</a></li>
            </ul>
        </div>
        <div class="content">
            <section id="assignments">
                <h2>Assignments</h2>
                <form>
                    <label for="assignment-title">Title:</label>
                    <input type="text" id="assignment-title" name="assignment-title" required>
                    <label for="assignment-description">Description:</label>
                    <textarea id="assignment-description" name="assignment-description" required></textarea>
                    <label for="assignment-file">File Attachment:</label>
                    <input type="file" id="assignment-file" name="assignment-file">
                    <button type="submit">Add Assignment</button>
                </form>
            </section>
            <section id="materials">
                <h2>Learning Materials</h2>
                <form>
                    <label for="material-title">Title:</label>
                    <input type="text" id="material-title" name="material-title" required>
                    <label for="material-description">Description:</label>
                    <textarea id="material-description" name="material-description" required></textarea>
                    <label for="material-file">File Attachment:</label>
                    <input type="file" id="material-file" name="material-file">
                    <button type="submit">Add Material</button>
                </form>
            </section>
            <section id="grades">
                <h2>Grades</h2>
                <form>
                    <label for="student-name">Student Name:</label>
                    <input type="text" id="student-name" name="student-name" required>
                    <label for="task-title">Task:</label>
                    <input type="text" id="task-title" name="task-title" required>
                    <label for="grade">Grade:</label>
                    <input type="number" id="grade" name="grade" required min="0" max="100">
                    <button type="submit">Add Grade</button>
                </form>
            </section>
            <section id="attendance">
                <h2>Attendance</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>Present</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Absent</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>
