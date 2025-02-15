<?php
declare(strict_types=1);
include_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/Config.php";
require_once __DIR__ . "/Middleware.php";
require_once __DIR__ . "/Controllers/AdminController.php";
require_once __DIR__ . "/Controllers/RegularUserController.php";
require_once __DIR__ . "/Controllers/StudentController.php";
require_once __DIR__ . "/Controllers/TeacherController.php";
require_once __DIR__ . "/Models/DatabaseModel.php";
require_once __DIR__ . "/Models/AdminModel.php";
require_once __DIR__ . "/Models/RegularUserModel.php";
require_once __DIR__ . "/Models/StudentModel.php";
require_once __DIR__ . "/Models/TeacherModel.php";
require_once __DIR__ . "/Router.php";

Router::init();
$middleware = new Middleware();
$adminController = new AdminController();
$regularUserController = new RegularUserController();
$studentController = new StudentController();
$teacherController = new TeacherController();
$adminModel = new AdminModel();
$regularUserModel = new RegularUserModel();
$studentModel = new StudentModel();
$teacherModel = new TeacherModel();
$middleware->initiateSessionCookies();
$middleware->startSession();
$middleware->setRegenerateSessionId();

$_SESSION["username"] = null;