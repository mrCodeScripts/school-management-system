<?php

declare(strict_types=1);
$CSS = Config::generateResourcePack("CSSFiles");
$ICONS = Config::generateResourcePack("SVGIcons");
$JS = Config::generateResourcePack("JSFiles");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $CSS[2]; ?>
    <title>Signup Form</title>
</head>

<body>
    <div class="form-container">
        <h1 class="form-greet">Signup</h1>
        <form>
            <div class="rowed-input-wrappers">
                <div class="form-elements-wrapper blured-animation">
                    <input type="email" name="signup-firstname" id="signup-firstname" placeholder="Firstname" autocomplete="off" spellcheck="false" />
                    <div class="icons">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icons user-icon"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                        </svg>
                    </div>
                </div>
                <div class="form-elements-wrapper blured-animation">
                    <input type="text" name="signup-lastname" id="signup-lastname" placeholder="Lastname" autocomplete="off" spellcheck="false" />
                    <div class="icons">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icons user-icon"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                            <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="form-elements-wrapper blured-animation">
                <input type="email" name="signup-email" id="signup-email" placeholder="Email address" autocomplete="off" spellcheck="false" />
                <div class="icons">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icons-envelope icons">
                        <path d="M63 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                    </svg>
                </div>
            </div>
            <div class="rowed-input-wrappers">
                <div class="form-elements-wrapper blured-animation">
                    <input type="password" name="signup-create-password" id="signup-create-password" placeholder="Create password" spellcheck="false" autocomplete="off" />
                    <div class="icons">
                        <svg xmlns="http://www.w2.org/2000/svg" class="eyes" viewBox="0 0 576 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                        </svg>
                    </div>
                </div>
                <div class="form-elements-wrapper blured-animation">
                    <input type="password" name="signup-confirm-password" id="signup-confirm-password" placeholder="Confirm password" spellcheck="false" autocomplete="off" />
                    <div class="icons">
                        <svg xmlns="http://www.w2.org/2000/svg" class="eyes" viewBox="0 0 576 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="rowed-input-wrappers">
                <div class="form-elements-wrapper blured-animation">
                    <select name="signup-gender" id="signup-gender">
                        <option value="" hidden selected>Select gender</option>
                    </select>
                </div>
                <div class="form-elements-wrapper blured-animation">
                    <input type="number" name="signup-age" id="signup-age" placeholder="Age" />
                </div>
            </div>
            <button type="submit">Signup</button>
            <p class="notif-p-btm">Already have an account? <a href="/login">Login here</a></p>

            <!-- <label for="signup-lastname">Last Name:</label>
            <input type="text" id="signup-lastname" name="signup-lastname" required>
            <label for="signup-email">Email:</label>
            <input type="email" id="signup-email" name="signup-email" required>
            <label for="signup-password">Create Password:</label>
            <input type="password" id="signup-password" name="signup-password" required>
            <label for="signup-confirm-password">Confirm Password:</label>
            <input type="password" id="signup-confirm-password" name="signup-confirm-password" required>
            <label for="signup-gender">Gender:</label>
            <select id="signup-gender" name="signup-gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <label for="signup-age">Age:</label> -->
            <!-- <input type="number" id="signup-age" name="signup-age" min="1" required> -->
            <!-- <button type="submit">Sign Up</button> -->
        </form>
    </div>
</body>
<?php echo $JS[0]; ?>
<?php echo $JS[1]; ?>
<?php echo $JS[2]; ?>
<?php echo $JS[3]; ?>


</html>