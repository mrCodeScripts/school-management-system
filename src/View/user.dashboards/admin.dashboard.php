<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* General Styles */
        body {
            width: 100vw;
            height: auto;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
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
        form textarea,
        form select {
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
            margin-right: 10px;
            transition: background 0.3s, color 0.3s;
        }

        form button:hover {
            background-color: #005fa3; /* Darker Accent */
        }

        /* Status Reports */
        .status-reports {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .report {
            background-color: #252526; /* Dark Report Background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .report h3 {
            border-bottom: 1px solid #007acc; /* VSCode Accent Color */
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #d4d4d4; /* Light Text Color */
        }

        .report p {
            margin: 10px 0;
            color: #d4d4d4; /* Light Text Color */
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <header class="header">
            <h1>Administrator Dashboard</h1>
        </header>
        <div class="sidebar">
            <ul>
                <li><a href="#assign-teachers">Assign Teachers</a></li>
                <li><a href="#manage-data">Manage Data</a></li>
                <li><a href="#school-status">School Status</a></li>
            </ul>
        </div>
        <div class="content">
            <section id="assign-teachers">
                <h2>Assign Teachers</h2>
                <form>
                    <label for="teacher-name">Teacher Name:</label>
                    <input type="text" id="teacher-name" name="teacher-name" required>
                    
                    <label for="classroom">Classroom/Advisory:</label>
                    <input type="text" id="classroom" name="classroom" required>
                    
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                    
                    <label for="section">Section:</label>
                    <input type="text" id="section" name="section" required>
                    
                    <label for="schedule">Schedule:</label>
                    <input type="text" id="schedule" name="schedule" required>
                    
                    <button type="submit">Assign</button>
                </form>
            </section>
            <section id="manage-data">
                <h2>Manage Data</h2>
                <form>
                    <label for="data-type">Data Type:</label>
                    <select id="data-type" name="data-type" required>
                        <option value="gender">Gender Types</option>
                        <option value="track">Track and Strand Types</option>
                        <option value="rules">Rules and Regulations</option>
                    </select>
                    <label for="data-entry">Data Entry:</label>
                    <input type="text" id="data-entry" name="data-entry" required>
                    
                    <button type="submit">Create</button>
                    <button type="submit">Read</button>
                    <button type="submit">Update</button>
                    <button type="submit">Delete</button>
                </form>
            </section>
            <section id="school-status">
                <h2>School Status</h2>
                <div class="status-reports">
                    <div class="report">
                        <h3>Registered Students and Teachers</h3>
                        <p>Students: 500</p>
                        <p>Teachers: 50</p>
                    </div>
                    <div class="report">
                        <h3>Student Violation Rates</h3>
                        <p>Violence: 2%</p>
                        <p>Offenses: 3%</p>
                        <p>Incidents: 1%</p>
                        <p>Accidents: 1%</p>
                    </div>
                    <div class="report">
                        <h3>Student Learning Status</h3>
                        <p>Academic Performance: 85%</p>
                        <p>Student Accomplishments: 70%</p>
                    </div>
                    <div class="report">
                        <h3>Teenage Pregnancy</h3>
                        <p>Rate: 5%</p>
                    </div>
                    <div class="report">
                        <h3>School Rating</h3>
                        <p>Rating: 90%</p>
                    </div>
                    <div class="report">
                        <h3>Student Mental Health</h3>
                        <p>Positive: 80%</p>
                        <p>Needs Improvement: 20%</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
