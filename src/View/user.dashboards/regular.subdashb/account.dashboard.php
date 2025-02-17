<?php

declare(strict_types=1);
$middleware = new Middleware();
$userAccDetails = $_SESSION["userAccount"]["currentAccountBasicInfo"][0];
$userAccLogs = $_SESSION["userAccount"]["currentAccountLogsInfo"];
$ICONS = Config::generateResourcePack("SVGIcons");
$CSS = Config::generateResourcePack("CSSFiles");
$IMG = Config::generateResourcePack("dummyImg");
$JS = Config::generateResourcePack("JSFiles");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $CSS[0] ?>
    <?php echo $CSS[3] ?>
    <?php echo $CSS[5] ?>
    <title>Personal Dashboard</title>
</head>

<body>
    <div class="sidebar-left-wrapper ui_scrollbar_lightmode">
        <div class="sidebar-left-inner-wrapper">
            <div class="sidebar-left-first-bar">
                <div class="profile-picture-wrapper">
                    <?php echo $IMG[1] ?>
                </div>
                <div class="profile-name-email-rowed">
                    <p class="profile-name">
                        <?php echo $userAccDetails["user_firstname"] . " " . $userAccDetails["user_lastname"]; ?>
                    </p>
                    <div class="extra-info">
                        <p class="profile-email"><?php echo $userAccDetails["user_email"]; ?></p>
                    </div>
                </div>
            </div>
            <div class="sidebar-left-second-bar">
                <ul>
                    <li><a href="/account">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                    <path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
                                </svg>
                            </div>
                            Personal informations
                        </a></li>
                    <li><a href="/account/dashboard" class="current-pg">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                    <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
                                </svg>
                            </div>
                            Personal dashboard
                        </a></li>
                    <li><a href="/account/task-manager">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32l288 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-288 0c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                </svg>
                            </div>
                            Task manager
                        </a></li>
                    <li><a href="/account/my-files">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                    <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z" />
                                </svg>
                            </div>
                            My Files
                        </a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="main-content">
        <div class="main-content-header">
            <button type="button" id="logout-acc">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                        <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                    </svg>
                </div>
                <p>
                    Logout
                </p>
            </button>
            <div class="icon" title="Dark Theme or Light Theme">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                    <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm40-83q119-15 199.5-104.5T800-480q0-123-80.5-212.5T520-797v634Z" />
                </svg>
            </div>
        </div>

        <div class="main-content-container ui_scrollbar_lightmode">
            <div class="main-content-container-wrapper">
                <div class="greetings">
                    <p class="access-dashb-greetings">
                        Welcome bitch, lets access you're dashboard
                    </p>
                    <div class="access-register-btns">
                        <button>Access</button>
                        <button>Register</button>
                    </div>
                </div>

                <div class="informations">
                    <div class="info-bx-card">
                        <div class="bx-card-inner">
                            <p class="placeholder">Steps to register: </p>
                        </div>
                    </div>

                    <div class="info-bx-card">
                        <div class="bx-card-inner">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php echo $JS[0]; ?>
<?php echo $JS[1]; ?>
<?php echo $JS[2]; ?>
<?php echo $JS[3]; ?>

</html>