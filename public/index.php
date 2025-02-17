<?php

declare(strict_types=1);
require __DIR__ . "/../src/Bootstrap.php";
Router::init();




# ======================= PAGE ROUTERS ======================= #
Router::get("/", function ($studentModel) {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (!empty($existingAccount)) {
		header("Location: /account");
	}
	include __DIR__ . "/../src/View/main.page.php";
	die();
}, $studentModel);

Router::get("/login", function () {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (!empty($existingAccount)) {
		header("Location: /account");
	} else {
		include __DIR__ . "/../src/View/login.page.php";
	}
	die();
});

Router::get("/account", function (
	$middleware,
	$regularUserController
) {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (empty($existingAccount)) {
		header("Location: /login");
	}
	$regularUserController->updateAccountInformation();
	include __DIR__
		. "/../src/View/user.dashboards/regular.dashboard.php";
	die();
}, $middleware, $regularUserController);

Router::get(
	"/signup",
	function (
		$regularUserModel,
		$middleware
	) {
		$userExist = $_SESSION["userAccount"] ?? null;
		if ($userExist) {
			header("Location: /account");
		}
		$_SESSION["genderTypes"] =
			$regularUserModel->getAllGenderTypes();
		include __DIR__ . "/../src/View/signup.page.php";
		die();
	},
	$regularUserModel,
	$middleware
);

Router::get("/account/dashboard", function () {
	if (empty($_SESSION["userAccount"])) {
		header("Location: /login");
	};
	include __DIR__
		. "/../src/View/user.dashboards/regular.subdashb/account.dashboard.php";
	die();
});

Router::get("/acc/personal-informations", function () {
	include __DIR__
		. "/../src/View/user.dashboards/regular.dashboard.php";
	die();
});

Router::get("/acc/my-files", function () {
	include __DIR__
		. "/../src/View/user.dashboards/regular.subdashb/myfiles.dashb.php";
	die();
});

Router::get("/dashb/teacher", function () {
	include __DIR__
		. "/../src/View/user.dashboards/teacher.dashboard.php";
	die();
});

Router::get("/dashb/student", function () {
	include __DIR__
		. "/../src/View/user.dashboards/student.dashboard.php";
	die();
});

Router::get("/dashb/admin", function () {
	include __DIR__
		. "/../src/View/user.dashboards/admin.dashboard.php";
	die();
});
# ===================================================== #















# ======================= AUTHENTICATION REQUEST ======================= #
Router::post(
	"/api/auth/login",
	function (
		$middleware,
		$regularUserController
	) {
		header("Content-Type: application/json");
		if (!$middleware->isSessionAvailable()) {
			die(json_encode([
				"message" => "Session is not available!",
				"type" => "SESSION_ERR",
				"status" => "unsuccessful",
			]));
		}

		if ($middleware->isAnyColumnEmpty([
			$_POST["login-email"],
			$_POST["login-password"],
		])) {
			die(json_encode([
				"message" => "Incomplete data!",
				"type" => "LOGIN_ERR",
				"status" => "successful",
			]));
		};

		if (!$middleware->isValidEmailFormat(
			$_POST["login-email"]
		)) {
			die(json_encode([
				"message" => "Invalid email format",
				"type" => "EMAIL_FORMAT_ERR",
				"status" => "unsuccessful",
			]));
		}

		$regularUserController->loginAccount(
			$_POST["login-email"],
			$_POST["login-password"]
		);
	},
	$middleware,
	$regularUserController
);

Router::post(
	"/api/logout",
	function (
		$middleware,
		$regularUserController
	) {
		$regularUserController->logoutAccount();
		die(json_encode([
			"message" => "Successfuly logged out account!",
			"type" => "LOGOUT_SUCCESS",
			"status" => "successful",
		]));
	},
	$middleware,
	$regularUserController
);

ROUTER::post(
	"/api/auth/signup",
	function (
		$regularUserController,
		$middleware,
	) {
		$data = [
			"firstname" => $_POST["signup-firstname"] ?? null,
			"lastname" => $_POST["signup-lastname"] ?? null,
			"email" => $_POST["signup-email"] ?? null,
			"age" => $_POST["signup-age"] ?? null,
			"gender" => $_POST["signup-gender"] ?? null,
			"confirm_password" => $_POST["signup-confirm-password"] ?? null,
			"create_password" => $_POST["signup-create-password"] ?? null,
			"role" => 1,
		];

		if ($middleware->isAnyColumnEmpty($data)) {
			$msg = $middleware->msg("SERVER_ERR");
			die(json_encode([
				"message" => $msg["message"][0],
				"type" => $msg["messageName"],
				"status" => "unsuccessful",
			]));
		}

		if (
			$data["confirm_password"] !== $data["create_password"]
		) {
			$msg = $middleware->msg("PASSWORD_ERR");
			die(json_encode([
				"message" => $msg["message"][0],
				"type" => $msg["messageName"],
				"status" => "unsuccessful",
			]));
		}

		if (!$middleware->isValidEmailFormat($data["email"])) {
			$msg = $middleware->msg("EMAIL_ERR");
			die(json_encode([
				"message" => $msg["message"][0],
				"type" => $msg["messageName"],
				"status" => "unsuccessful",
			]));
		}

		$data = [
			"UUID" => $middleware->getUUID(),
			"fn" => $middleware->stringSanitization($data["firstname"]),
			"ln" => $middleware->stringSanitization($data["lastname"]),
			"email" => $data["email"],
			"pwd" => $middleware->getPasswordHashing(
				$middleware->sanitizePassword($data["confirm_password"])
			),
			"age" => intval($data["age"]),
			"gender_type" => $data["gender"],
			"role" => $data["role"],
		];

		$regularUserController->signupAccount($data);
		$msg = $middleware->getMsg("SIGNUP_SUCCESS");
		die(json_encode([
			"message" => $msg["message"],
			"type" => $msg["messageName"],
			"status" => "successful",
			"refresh" => true,
			"stop_load" => true,
		]));
	},
	$regularUserController,
	$middleware
);

Router::post(
	"/account/auth/student/enr",
	function (
		$middleware,
		$regularUserController,
		$studentController,
		$regularUserModel,
	) {
		# TODO NOW 
		header("Content-Type: application/json");

		# check if user is not logged in
		$existingUser = $_SESSION["userAccount"] ?? null;
		if (empty($existingUser)) {
			die(json_encode([
				"message" => "You are not logged in yet bitch!",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}

		# collect data from the database
		$userEmail = $existingUser["currentAccountBasicInfo"][0]["user_email"] ?? null;
		$generalAccData = $regularUserModel->getGeneralAccountInformations($userEmail) ?? null;
		$findAccPremium = $regularUserController->checkAccPremium($generalAccData[0]["UUID"]) ?? null;
		$UUID = $generalAccData[0]["UUID"];

		# find if account is already a premium account.
		if (!empty($findAccPremium)) {
			die(json_encode([
				"message" => "This account is already a premium account. 
				Please access account via PIN.",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}

		$studentController->studentFullRegistration($UUID);

		die(json_encode([
			"message" => "You are now fucking registered.",
			"type" => "STUDENT_REGISTRATION_SUCESS",
			"status" => "successful",
			"refresh" => true,
			"stop_reload" => true,
			"current_user" => $existingUser["currentAccountBasicInfo"],
			"general_user_data" => $generalAccData,
			// "registered_user" => $registered_user,
			// "student_information" => $student_informations,
		]));
	},
	$middleware,
	$regularUserController,
	$studentController,
	$regularUserModel,
);

Router::get(
	"/account/access-dashboard/access-student",
	function (
		$middleware,
		$regularUserController
	) {
		# check account if it has a premium access
		# if it has premium access, only receive pin
		# validate pin.
		# after validation, set session for the user data
	},
	$middleware,
	$regularUserController
);

Router::get("/account/task-manager", function () {
	if (empty($_SESSION["userAccount"])) {
		header("Location: /login");
	};
	include __DIR__
		. "/../src/View/user.dashboards/regular.subdashb/taskmanager.dashb.php";
	die();
});











/*

Router::post("/task/addTask", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/deleteTask", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/modifyTask/name", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/modifyTask/description", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/modifyTask/deadline", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/modifyTask/status", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::get("/task/getTask", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::get("/task/getAllTasks", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/assignTask", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);

Router::post("/task/completeTask", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
});

Router::get("/task/userTasks", function ($middleware) {
	if (!$middleware->isUserAlreadyLoggedIn()) {
		header("Location: /login");
	}
}, $middleware);





































### STUDENT DASHBOARD ROUTES
Router::get("/student/dashboard", function () {});
Router::get("/student/tasks", function () {});
Router::post("/student/submitTask", function () {});
Router::get("/student/grades", function () {});
Router::get("/student/schedule", function () {});

### TEACHER DASHBOARD ROUTES
Router::get("/teacher/dashboard", function () {});
Router::get("/teacher/classes", function () {});
Router::post("/teacher/addTask", function () {});
Router::get("/teacher/tasks", function () {});
Router::post("/teacher/gradeTask", function () {});
Router::get("/teacher/students", function () {});

### ADMIN DASHBOARD ROUTES
Router::get("/admin/dashboard", function () {});
Router::get("/admin/users", function () {});
Router::post("/admin/addUser", function () {});
Router::delete("/admin/removeUser", function () {});
Router::post("/admin/updateUser", function () {});
Router::get("/admin/systemLogs", function () {});
Router::get("/admin/settings", function () {});

### PARENT DASHBOARD ROUTES
Router::get("/parent/dashboard", function () {});
Router::get("/parent/studentProgress", function () {});
Router::get("/parent/schedule", function () {});
Router::get("/parent/messages", function () {});
Router::post("/parent/contactTeacher", function () {});
*/


















































/*
Router::post("/req/login", function ($regularUserController, $middleware) {

	include __DIR__ . "/../src/View/main.page.php";
	die();
}, $regularUserController, $middleware);
*/


/*
Router::post("/req/test-logout-request", function () {
	session_destroy();
	session_unset();
	die(json_encode(["message" => "Successfuly logged out!"]));
}, $middleware);

Router::post("/req/test-login-request", function ($middleware) {
	$userEmail = "administrator@gmail.com";
	$userPassword = "@dmin123";

	$sessionEmail = $_SESSION["email-address"] ?? null;
	$sessionPassword = $_SESSION["password"] ?? null;

	if (!empty($sessionEmail) && !empty($sessionPassword)) {
		die(json_encode([
			"message" => "Already logged in!",
			"refresh" => false,
			"user" => [
				"email-address" => $_SESSION["email-address"],
				"password" => $_SESSION["password"],
			]
		]));
	}

	$email = $_POST["login-email"] ?? null;
	$password = $_POST["login-password"] ?? null;

	if (empty($email) || empty($password)) {
		die(json_encode(["error" => "Incomplete data submitted!"]));
	}

	if ($userEmail !== $email || $userPassword !== $password) {
		die(json_encode([
			"error" => "Incorrect email or password."
		]));
	} else {
		$_SESSION["email-address"] = $email;
		$_SESSION["password"] = $password;
		die(json_encode([
			"message" => "Successfuly logged in!",
			"refresh" => true,
			"user" => [
				"email-address" => $email,
				"password" => $password,
			]
		]));
	}
}, $middleware);

Router::get("/p/main-account", function ($middleware) {
	$existing_email = $_SESSION["email-address"] ?? null;
	$existing_password = $_SESSION["password"] ?? null;
	if (empty($existing_email) && empty($existing_password)) {
		header("Location: /p/test-login");
	}
	include __DIR__ . "/../src/ViewTest/account.php";
	die();
}, $middleware);

Router::get("/p/test-login", function ($middleware) {
	$existing_email = $_SESSION["email-address"] ?? null;
	$existing_password = $_SESSION["password"] ?? null;
	if ($existing_email && $existing_password) {
		header("Location: /p/main-account");
	}
	include __DIR__ . "/../src/ViewTest/login.php";
	die();
}, $middleware);

Router::get("/", function ($middleware, $regularUserModel) {
	$existing_email = $_SESSION["email-address"] ?? null;
	$existing_password = $_SESSION["password"] ?? null;
	if ($existing_email && $existing_password) {
		header("Location: /p/main-account");
	}
	include __DIR__ . "/../src/View/main.page.php";
	echo "<a href='p/test-login'>LOGIN</a>";
	die();
}, $middleware, $regularUserModel);

*/













/*
Router::post("/req/logout", function ($regularUserController) {
}, $regularUserController);

Router::post("/req/acc/student/enrollment", function ($middleware) {
	# check if session is available
	if (!$middleware->isSessionAvailable()) {
		die(json_encode(["SESSION_ERR" => "Session is not available!"]));
	}

	# check if user is logged in

	# check if current account is already a premium user
	# get student data
	# sanitize student input
	# data insertion procedure...
	die();
}, $middleware);

Router::get("/p/login", function () {
	include __DIR__ . "/../src/View/login.page.php";
	die();
});

Router::get("/p/signup", function () {
	include __DIR__ . "/../src/View/signup.page.php";
	die();
});
Router::get("/p/acc/personal-informations", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.dashboard.php";
	die();
});


Router::get("/p/acc/my-files", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.subdashb/myfiles.dashb.php";
	die();
});
Router::get("/p/dashb/teacher", function () {
	include __DIR__ . "/../src/View/user.dashboards/teacher.dashboard.php";
	die();
});
Router::get("/p/dashb/student", function () {
	include __DIR__ . "/../src/View/user.dashboards/student.dashboard.php";
	die();
});
Router::get("/p/dashb/admin", function () {
	include __DIR__ . "/../src/View/user.dashboards/admin.dashboard.php";
	die();
});
*/




Router::dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
