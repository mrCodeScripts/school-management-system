<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <h1>You are not logged in yet. <span style="color: green;">Login Now!</span></h1>
    <div>
        <form id="form-login">
            <input type="email" name="login-email" id="login-email" placeholder="Email address" />
            <input type="password" name="login-password" id="login-password" placeholder="Password" />
            <button type="submit">Continue</button>
        </form>
    </div>
</body>
<script>
    'use strict';

    const form = document.getElementById("form-login");

    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const t = e.target;
        const formData = new FormData(t);

        fetch("/req/test-login-request", {
                method: "POST",
                body: formData,
            })
            .then(_res => _res.json())
            .then(_res => {
                console.log(_res);
                if (_res.refresh) location.reload();
            })
            .catch(err => {
                console.log(err);
            });
    });
</script>

</html>