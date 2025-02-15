<?php
$existing_email = $_SESSION["email-address"] ?? null;
$existing_password = $_SESSION["password"] ?? null;

$email = $_SESSION["email-address"] ?? "<span color='red'>No email address from session.</span>";
$password = $_SESSION["password"] ?? "<span color='red'>No password from session.</span>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Page</title>
</head>

<body>
    <h1>Welcome to your main account!</h1>

    <p>Email address:
        <span><b><?= $email ?></b></span>
    <p>

    <p>Password:
        <span><b><?= $password ?></b></span>
    </p>
    <button type="button" id="logout-btn" style="padding: 10px; font-size: 1em; color: white; background: red;">Logout</button>
</body>
<script>
    'use strict';
    const logout = document.getElementById("logout-btn");
    logout.addEventListener("click", (e) => {
        e.preventDefault();
        fetch("/req/test-logout-request", {
                method: "POST"
            })
            .then(_res => _res.json())
            .then(_res => {
                if (_res.message) location.reload();
            });
    });
</script>

</html>