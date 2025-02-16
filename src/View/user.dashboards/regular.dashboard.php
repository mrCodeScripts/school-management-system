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
    <title>Personal Informations</title>
</head>

<body>
    <div class="sidebar-left-wrapper ui_scrollbar_lightmode">
        <div class="sidebar-left-inner-wrapper">
            <div class="sidebar-left-first-bar">
                <div class="profile-picture-wrapper">
                    <?php echo $IMG[1] ?>
                </div>
                <!-- <button type="button" title="Edit profile" class="icons">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343"><path d="M80 0v-160h800V0H80Zm160-320h56l312-311-29-29-28-28-311 312v56Zm-80 80v-170l448-447q11-11 25.5-17t30.5-6q16 0 31 6t27 18l55 56q12 11 17.5 26t5.5 31q0 15-5.5 29.5T777-687L330-240H160Zm560-504-56-56 56 56ZM608-631l-29-29-28-28 57 57Z"/></svg>
                </button> -->
                <div class="profile-name-email-rowed">
                    <p class="profile-name">Jayrald Deniega</p>
                    <div class="extra-info">
                        <p class="profile-email">schooladmin@gmail.com </p>
                    </div>
                </div>
            </div>
            <div class="sidebar-left-second-bar">
                <ul>
                    <li><a href="/p/acc/personal-informations" class="current-pg">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                    <path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
                                </svg>
                            </div>
                            Personal informations
                        </a></li>
                    <li><a href="/p/acc/access-dashboard">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                    <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
                                </svg>
                            </div>
                            Personal dashboard
                        </a></li>
                    <li><a href="/p/acc/task-manager">
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-224 0c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32l288 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-288 0c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                </svg>
                            </div>
                            Task manager
                        </a></li>
                    <li><a href="/p/acc/my-files">
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
                <p class="p-1-h1">Personal Informations</p>
                <p class="p-2-p">Manage your personal information, including log records, email address, names, and where you can be contacted.</p>
                <div class="personal-informations-containers">
                    <div class="col-rowed">
                        <div class="personal-inf-bx bx-wrapper-entrance-animation">
                            <div class="inf-bx-header">
                                <p class="inf-name">
                                    Basic Informations
                                </p>
                                <div class="inf-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="inf-bx-main">
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Firstname
                                        </p>
                                        <button class="editable-icon" title="Edit firstname">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-firstname" class="info">
                                        <?= $userAccDetails["user_firstname"] ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Lastname
                                        </p>
                                        <button class="editable-icon" title="Edit lastname">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-lastname" class="info">
                                        <?= $userAccDetails["user_lastname"] ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Age
                                        </p>
                                        <button class="editable-icon" title="Edit age">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-age" class="info">
                                        <?= $userAccDetails["user_age"] ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Gender
                                        </p>
                                        <button class="editable-icon" type="button" title="Edit gender">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-gender" class="info">
                                        <?= $userAccDetails["gender_name"] ?>
                                    </p>
                                </div>

                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Birthday
                                        </p>
                                        <button class="editable-icon" title="Edit age">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-age" class="info">
                                        April 19, 2007 (not set)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-rowed">
                        <div class="personal-inf-bx bx-wrapper-entrance-animation">
                            <div class="inf-bx-header">
                                <p class="inf-name">
                                    Email Adress
                                </p>
                                <div class="inf-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                        <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="inf-bx-main">
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Primary email address
                                        </p>
                                        <button class="editable-icon" type="button" title="Edit email address">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-firstname" class="info">
                                        <?= $userAccDetails["user_email"] ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="personal-inf-bx bx-wrapper-entrance-animation">
                            <div class="inf-bx-header">
                                <p class="inf-name">
                                    Pin and Password
                                </p>
                                <div class="inf-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                        <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="inf-bx-main">
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Current password
                                        </p>
                                        <button class="editable-icon" type="button" title="Change current password">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-gender" class="info">
                                        *********
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Current pin
                                        </p>
                                        <button class="editable-icon" type="button" title="Change current password">
                                            <svg width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21L12 21H21" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.2218 5.82839L15.0503 2.99996L20 7.94971L17.1716 10.7781M12.2218 5.82839L6.61522 11.435C6.42769 11.6225 6.32233 11.8769 6.32233 12.1421L6.32233 16.6776L10.8579 16.6776C11.1231 16.6776 11.3774 16.5723 11.565 16.3847L17.1716 10.7781M12.2218 5.82839L17.1716 10.7781" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="user-acc-gender" class="info">
                                        Not applicable...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-rowed min-width-exception">
                        <div class="personal-inf-bx bx-wrapper-entrance-animation">
                            <div class="inf-bx-header">
                                <p class="inf-name">
                                    Account Informations
                                </p>
                                <div class="inf-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                        <path d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="inf-bx-main">
                                <div class="row">
                                    <div class="inf-name-subname">
                                        <p>
                                            Account was created on
                                        </p>
                                    </div>
                                    <p id="user-acc-firstname" class="info">
                                        <?= $middleware->getModifiedTime($userAccDetails["account_created"]); ?>
                                    </p>
                                </div>

                                <div class="row" style="margin-top: 10px;">
                                    <div class="inf-name-subname">
                                        <p>
                                            Log records
                                        </p>
                                    </div>
                                    <div id="user-acc-log-records" class="info">
                                        <div class="top-table-header">
                                            <div class="t-table-headers">
                                                <div class="main-icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                    </svg>
                                                </div>
                                                <p>4 columns hidden</p>
                                            </div>
                                            <div class="t-table-headers selectable-headers">
                                                <div class="main-icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                        <path d="M3.9 54.9C10.5 40.9 24.5 32 40 32l432 0c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9 320 448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6l0-79.1L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                                                    </svg>
                                                </div>
                                                <p>7 days ago</p>
                                                <div class="icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                        <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="t-table-headers selectable-headers">
                                                <div class="main-icons">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                        <path d="M151.6 469.6C145.5 476.2 137 480 128 480s-17.5-3.8-23.6-10.4l-88-96c-11.9-13-11.1-33.3 2-45.2s33.3-11.1 45.2 2L96 365.7 96 64c0-17.7 14.3-32 32-32s32 14.3 32 32l0 301.7 32.4-35.4c11.9-13 32.2-13.9 45.2-2s13.9 32.2 2 45.2l-88 96zM320 480c-17.7 0-32-14.3-32-32s14.3-32 32-32l32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-96 0zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32l160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-160 0zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32l224 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L320 96z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="acc-log-records">
                                            <tr class="log-records-header">
                                                <th>Status</th>
                                                <th>Activity</th>
                                                <th>Time</th>
                                                <th>Date</th>
                                            </tr>
                                            <tbody class="log-record-data">
                                                <tr class="record-data">
                                                    <td class="data t-successful-1">Successful</td>
                                                    <td class="data">Login</td>
                                                    <td class="data">2 hours ago...</td>
                                                    <td class="data">April 19</td>
                                                </tr>
                                                <tr class="record-data">
                                                    <td class="data t-successful-1">Successful</td>
                                                    <td class="data">Login</td>
                                                    <td class="data">2 hours ago...</td>
                                                    <td class="data">April 19</td>
                                                </tr>
                                                <tr class="record-data">
                                                    <td class="data t-successful-1">Successful</td>
                                                    <td class="data">Login</td>
                                                    <td class="data">2 hours ago...</td>
                                                    <td class="data">April 19</td>
                                                </tr>
                                                <tr class="record-data">
                                                    <td class="data t-successful-1">Successful</td>
                                                    <td class="data">Login</td>
                                                    <td class="data">2 hours ago...</td>
                                                    <td class="data">April 19</td>
                                                </tr>
                                                <tr class="record-data">
                                                    <td class="data t-unsuccessful-1">Failed</td>
                                                    <td class="data">Login</td>
                                                    <td class="data">2 hours ago...</td>
                                                    <td class="data">April 19</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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