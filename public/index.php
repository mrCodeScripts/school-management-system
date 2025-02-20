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


Router::get(
	"/account/task-manager",
	function (
		$regularUserController,
		$regularUserModel
	) {

		if (empty($_SESSION["userAccount"])) {
			header("Location: /login");
		}

		$userExist = $_SESSION["userAccount"] ?? null;
		$userEmail = $userExist["currentAccountBasicInfo"][0]["user_email"] ?? null;
		$generalAccData = $regularUserModel->getGeneralAccountInformations($userEmail) ?? null;
		$UUID = $generalAccData[0]["UUID"];

		$regularUserController->updateTaskList($UUID);

		include __DIR__
			. "/../src/View/user.dashboards/regular.subdashb/taskmanager.dashb.php";
		die();
	},
	$regularUserController,
	$regularUserModel
);

Router::get("/account/dashboard", function () {
	if (empty($_SESSION["userAccount"])) {
		header("Location: /login");
	};
	include __DIR__
		. "/../src/View/user.dashboards/regular.subdashb/account.dashboard.php";
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
		# BASIC LOGIN AUTHENTICATION ROUTER
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
		# LOGOUT AUTHENTICATION ROUTER
		header("Content-Type: application/json");
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

		# SIGNUP AUTHENTICATION ROUTE

		header("Content-Type: application/json");

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
		$studentController,
		$regularUserModel,
	) {

		# STUDENT REIGISTRATION AUTHENTICATION ROUTE

		header("Content-Type: application/json");

		$existingUser = $_SESSION["userAccount"] ?? null;
		if (empty($existingUser)) {
			die(json_encode([
				"message" => "You are not logged in yet bitch!",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}

		$userEmail = $existingUser["currentAccountBasicInfo"][0]["user_email"] ?? null;
		$generalAccData = $regularUserModel
			->getGeneralAccountInformations($userEmail) ?? null;
		$UUID = $generalAccData[0]["UUID"];
		$findAccPremium = $regularUserModel
			->findPremiumRegsiteredAccount($UUID) ?? null;

		if (!empty($findAccPremium)) {
			die(json_encode([
				"message" => "This account is already a premium account. Please access account premium features via PIN (If this account is already approved by the addministrators.",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}

		$student_informations = [
			"LRN" => $_POST["register_lrn"] ?? null,
			"firstname" => $_POST["register_firstname"] ?? null,
			"lastname" => $_POST["register_lastname"] ?? null,
			"age" => $_POST["register_age"] ?? null,
			"hometown" => $_POST["register_hometown"] ?? null,
			"current_location" => $_POST["register_current_location"] ?? null,
		];

		if ($middleware->isAnyColumnEmpty($student_informations)) {
			die(json_encode([
				"message" => "Incomplete data.",
				"type" => "INCOMPLETE_DATA",
				"status" => "unsuccessful",
			]));
		}

		$studentController->studentFullRegistration($student_informations, $UUID);

		die(json_encode([
			"message" => "You are now fucking registered.",
			"type" => "STUDENT_REGISTRATION_SUCESS",
			"status" => "successful",
			"refresh" => true,
			"stop_reload" => true,
			"current_user" => $existingUser["currentAccountBasicInfo"],
			"general_user_data" => $generalAccData,
		]));
	},
	$middleware,
	$regularUserController,
	$studentController,
	$regularUserModel,
	$studentModel,
);

Router::post(
	"/account/auth/teacher/enr",
	function (
		$middleware,
		$teacherController,
		$regularUserModel,
	) {
		# TEACHER REIGISTRATION AUTHENTICATION ROUTE
		header("Content-Type: application/json");
		$existingUser = $_SESSION["userAccount"] ?? null;
		if (empty($existingUser)) {
			die(json_encode([
				"message" => "You are not logged in yet bitch!",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}
		$userEmail = $existingUser["currentAccountBasicInfo"][0]["user_email"] ?? null;
		$generalAccData = $regularUserModel
			->getGeneralAccountInformations($userEmail) ?? null;
		$UUID = $generalAccData[0]["UUID"];
		$findAccPremium = $regularUserModel
			->findPremiumRegsiteredAccount($UUID) ?? null;
		if (!empty($findAccPremium)) {
			die(json_encode([
				"message" => "This account is already a premium account. Please access account premium features via PIN (If this account is already approved by the addministrators.",
				"type" => "PREMIUM_REGISTRATION_ERR",
				"status" => "unsuccessful",
			]));
		}
		$teacher_informations = [
			"professional_id" => $_POST["register_professional_id"] ?? null,
			"firstname" => $_POST["register_firstname"] ?? null,
			"lastname" => $_POST["register_lastname"] ?? null,
			"age" => $_POST["register_age"] ?? null,
			"hometown" => $_POST["register_hometown"] ?? null,
			"current_location" => $_POST["register_current_location"] ?? null,
		];
		if ($middleware->isAnyColumnEmpty($teacher_informations)) {
			die(json_encode([
				"message" => "Incomplete data.",
				"type" => "INCOMPLETE_DATA",
				"status" => "unsuccessful",
			]));
		}
		$teacherController->teacherFullRegistration(
			$teacher_informations,
			$UUID
		);
		die(json_encode([
			"message" => "You are now fucking registered.",
			"type" => "TEACHER_REGISTRATION_SUCCESS",
			"status" => "successful",
			"refresh" => true,
			"stop_reload" => true,
			"current_user" => $existingUser["currentAccountBasicInfo"],
			"general_user_data" => $generalAccData,
		]));
	},
	$middleware,
	$regularUserController,
	$teacherController,
	$regularUserModel,
	$teacherModel,
);

# TASK MANAGER REQUEST ROUTES
Router::post(
	"/account/task/create",
	function (
		$middleware,
		$regularUserController,
	) {
		header("Content-Type: application/json");
		$clientData = $middleware->spillJSON();
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$middleware->validateCSRFToken($clientData["csrf_token"], true);
		$newTask = [
			"task_id" => $middleware->generateRandomToken() ?? null,
			"UUID" => $UUID ?? null,
			"task_title" => $clientData["data"]["task_title"] ?? null,
			"task_type" => $clientData["data"]["task_type"] ?? 1, # regular task - id:1
			"task_deadline" => $clientData["data"]["task_deadline"] ?? null,
			"task_priority" => $clientData["data"]["task_priority"] ?? null,
			"task_description" => $clientData["data"]["task_description"] ?? null,
		];
		$middleware->isAnyColumnEmpty($newTask, true);
		$regularUserController->createTask($newTask);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully created task.",
			"type" => "TASK_CREATE_SUCCESS",
			"status" => "successful",
			$_SESSION["userAccount"],
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/delete",
	function (
		$middleware,
		$regularUserController,
	) {
		header("Content-Type: application/json");
		$clientData = $middleware->spillJSON();
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$middleware->validateCSRFToken($clientData["csrf_token"], true);
		$deleteTask = [
			"UUID" => $UUID,
			"data" => [...$clientData["data"]],
		];
		$middleware->isAnyColumnEmpty($deleteTask["data"], true);
		$regularUserController->deleteTasks($deleteTask);
		$regularUserController->updateTaskList($UUID);
		/**
		 * THE JSON DATA OF THE TASKS SELECTED MUST BE:
		 * {
		 *	"csrf_token": "123",
		 *	"data": [
		 *		{
		 *			"task_id": "0f9b91b13db84a22",
		 *			"task_index": 1,
		 *			"task_name": "CODING SESSION AGAIN"
		 *		},
		 *		{
		 *			"task_id": "296cc91d2b3b010e",
		 *			"task_index": 2,
		 *			"task_name": "CODING SESSION"
		 *		},
		 *		{
		 *			"task_id": "522e61bf-fe8e-4e0f-b153-53136414fd14",
		 *			"task_index": 3,
		 *			"task_name": "REHAB PORNHUB ADDICTION"
		 *		}
		 *	]
		 *}
		 */
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/completed",
	function (
		$middleware,
		$regularUserController,
	) {
		header("Content-Type: application/json");
		$clientData = $middleware->spillJSON();
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$middleware->validateCSRFToken($clientData["csrf_token"], true);
		$completedTask = [
			"UUID" => $UUID,
			"data" => [...$clientData["data"]],
		];
		$middleware->isAnyColumnEmpty($completedTask, true);
		$regularUserController->completedTask($completedTask);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully set task as COMPLETED. Congratulations.",
			"type" => "TASK_COMPLETE_SUCCESS",
			"status" => "successful"
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/c/title",
	function (
		$middleware,
		$regularUserController,
		$regularUserModel,
	) {
		# DONE (still on development) -- overall: DONE
		header("Content-Type: application/json");
		$clientData = $middleware->spillJSON();
		$middleware->validateCSRFToken($clientData["csrf_token"], true);
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$newTaskTitle = [
			"UUID" => $UUID,
			"data" => [...$clientData["data"]],
		];
		$middleware->isAnyColumnEmpty($newTaskTitle, true);
		$regularUserController->changeTaskTitle($newTaskTitle);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully changed task title.",
			"type" => "TASK_MODIF_SUCCESS",
			"status" => "successful"
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/c/desc",
	function (
		$middleware,
		$regularUserController,
		$regularUserModel,
	) {
		# DONE (still on development) -- overall: DONE
		header("Content-Type: application/json");
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$newTaskDesc = [
			"task_id" => $_POST["task_id"] ?? null,
			"UUID" => $UUID,
			"task_description" => $_POST["new_task_description"] ?? null,
		];
		$middleware->isAnyColumnEmpty($newTaskDesc, true);
		$regularUserController->changeTaskDescription($newTaskDesc);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully changed task description.",
			"type" => "TASK_MODIF_SUCCESS",
			"status" => "successful"
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/c/endt",
	function (
		$middleware,
		$regularUserController,
		$regularUserModel,
	) {
		# DONE (still on development) -- overall: DONE
		header("Content-Type: application/json");
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$newTaskEndt = [
			"task_id" => $_POST["task_id"] ?? null,
			"UUID" => $UUID,
			"task_deadline" => $_POST["new_task_deadline"] ?? null,
		];
		$middleware->isAnyColumnEmpty($newTaskEndt, true);
		$regularUserController->changeTaskDeadline($newTaskEndt);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully changed task deadline.",
			"type" => "TASK_MODIF_SUCCESS",
			"status" => "successful"
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post(
	"/account/task/c/prior",
	function (
		$middleware,
		$regularUserController,
		$regularUserModel,
	) {
		# DONE (still on development) -- overall: DONE
		header("Content-Type: application/json");
		[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
		$newTaskPrior = [
			"task_id" => $_POST["task_id"],
			"UUID" => $UUID,
			"task_priority" => $_POST["new_task_priority"]
		];
		$middleware->isAnyColumnEmpty($newTaskPrior, true);
		$regularUserController->changeTaskPriority($newTaskPrior);
		$regularUserController->updateTaskList($UUID);
		die(json_encode([
			"message" => "Successfully changed task priority level.",
			"type" => "TASK_MODIF_SUCCESS",
			"status" => "successful"
		]));
	},
	$middleware,
	$regularUserController,
	$regularUserModel,
);

Router::post("/account/task/c/sort", function () {
	# TODO
});


# INBOX REQUEST ROUTES
Router::post("/account/inbox/create", function () {
	# TODO
});

Router::post("/account/inbox/delete", function () {
	# TODO
});

Router::get("/account/inbox/open", function () {
	# TODO
});

Router::post("/account/inbox/mark-read", function () {
	# TODO
});

Router::post("/account/inbox/reply", function () {
	# TODO
});



# FILE SYSTEM REQUEST ROUTES
Router::post("/account/files/upload", function () {
	# TODO
});

Router::post("/account/files/download", function () {
	# TODO
});

Router::post("/account/files/list", function () {
	# TODO
});

Router::post("/account/files/delete", function () {
	# TODO
});

Router::post("/account/files/rename", function () {
	# TODO
});

Router::post("/account/files/metadata", function () {
	# TODO
});
# =========================================================================



Router::post("/account/test/data", function ($middleware, $regularUserController) {
	// $UUID = $_SESSION["userAccount"]["currentAccountBasicInfo"]["UUID"] ?? null;

	header("Content-Type: application/json");
	[$UUID, $userEmail] = $regularUserController->validateTaskAccess();
	$regularUserController->updateAccountInformation();
	$regularUserController->updateTaskList($UUID);
	die(json_encode($_SESSION["userAccount"]));
}, $middleware, $regularUserController);







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
