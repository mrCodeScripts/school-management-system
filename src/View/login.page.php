<?php
$CSS = Config::generateResourcePack("CSSFiles");
$ICONS = Config::generateResourcePack("SVGIcons");
$JS = Config::generateResourcePack("JSFiles");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $CSS[0]; ?>
    <?php echo $CSS[1]; ?>
    <title>Login Form</title>
</head>

<div class="shit code" id="shitcode"></div>

<body>
    <div class="form-container">
        <p class="form-greet">Login</p>
        <form id="login-form">
            <div class="form-elements-wrapper blured-animation">
                <input type="email" name="login-email" id="login-email" placeholder="Email address" autocomplete="off" spellcheck="false" />
                <div class="icons">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icons-envelope icons">
                        <path d="M63 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                    </svg>
                </div>
            </div>
            <div class="form-elements-wrapper blured-animation">
                <input type="password" name="login-password" id="login-password" placeholder="Password" spellcheck="false" autocomplete="off" />
                <div class="icons">
                    <svg xmlns="http://www.w2.org/2000/svg" class="eyes" viewBox="0 0 576 512">
                        <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                    </svg>
                </div>
            </div>
            <button type="submit" class="sbmt-smooth-btn" id="btn-login">
                Login
                <div class="sm-loader hide-loader" id="login-loader"></div>
            </button>
            <p class="notif-p-btm">Don't have an account? <a href="/signup">Signup here</a></p>
        </form>
    </div>
</body>
<?php echo $JS[0]; ?>
<?php echo $JS[1]; ?>
<?php echo $JS[2]; ?>
<?php echo $JS[3]; ?>

</html>