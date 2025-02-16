<?php

declare(strict_types=1);
require __DIR__ . "/../src/Bootstrap.php";
Router::init();

Router::get("/signup", function () {
	include __DIR__ . "/../src/View/signup.page.php";
	die();
});
Router::get("/acc/personal-informations", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.dashboard.php";
	die();
});
Router::get("/acc/my-files", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.subdashb/myfiles.dashb.php";
	die();
});
Router::get("/dashb/teacher", function () {
	include __DIR__ . "/../src/View/user.dashboards/teacher.dashboard.php";
	die();
});
Router::get("/dashb/student", function () {
	include __DIR__ . "/../src/View/user.dashboards/student.dashboard.php";
	die();
});
Router::get("/dashb/admin", function () {
	include __DIR__ . "/../src/View/user.dashboards/admin.dashboard.php";
	die();
});






Router::get("/", function () {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (!empty($existingAccount)) {
		header("Location: /account");
	}
	include __DIR__ . "/../src/View/main.page.php";
	die();
});

Router::post(
	"/api/auth/login",
	function (
		$middleware,
		$regularUserController
	) {
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

Router::get("/login", function () {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (!empty($existingAccount)) {
		header("Location: /account");
	} else {
		include __DIR__ . "/../src/View/login.page.php";
	}
	die();
});

Router::get("/account", function ($middleware, $regularUserController) {
	$existingAccount = $_SESSION["userAccount"] ?? null;
	if (empty($existingAccount)) {
		header("Location: /login");
	}
	$regularUserController->updateAccountInformation();
	include __DIR__
		. "/../src/View/user.dashboards/regular.dashboard.php";
	die();
}, $middleware, $regularUserController);

Router::post("/logout", function (
	$middleware,
	$regularUserController
) {
	$regularUserController->logoutAccount();
	die(json_encode([
		"message" => "Successfuly logged out account!",
		"type" => "LOGOUT_SUCCESS",
		"status" => "successful",
	]));
}, $middleware, $regularUserController);

Router::get("/account/access-dashboard", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.subdashb/access.dashb.php";
	die();
});

Router::get("/account/task-manager", function () {
	include __DIR__ . "/../src/View/user.dashboards/regular.subdashb/taskmanager.dashb.php";
	die();
});



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

ROUTER::post("/req/signup", function ($regularUserController, $middleware) {
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
		$messages[$middleware->msg("SERVER_ERR")["messageName"]] = $middleware->msg("SERVER_ERR")["message"][0];
		die(json_encode($messages));
	}

	# validate created is equal to the confirmed password
	if ($data["confirm_password"] !== $data["create_password"]) {
		$messages[$middleware->msg("PASSWORD_ERR")["messageName"]] = $middleware->msg("PASSWORD_ERR", 0)["message"][0];
		die(json_encode($messages));
	}

	# validate email format
	if (!$middleware->isValidEmailFormat($data["email"])) {
		$messages[$middleware->msg("EMAIL_ERR")["messageName"]] = $middleware->msg("EMAIL_ERR")["message"][0];
		die(json_encode($messages));
	}

	# initiate account data
	$data = [
		"UUID" => $middleware->getUUID(),
		"fn" => $middleware->stringSanitization($data["firstname"]),
		"ln" => $middleware->stringSanitization($data["lastname"]),
		"email" => $data["email"],
		"pwd" => $middleware->getPasswordHashing($middleware->sanitizePassword($data["confirm_password"])),
		"age" => intval($data["age"]),
		"gender_type" => $data["gender"],
		"role" => $data["role"],
	];

	$regularUserController->signup($data);

	$msg = $middleware->getMsg("SIGNUP_SUCCESS");
	die(json_encode([$msg["messageName"] => $msg["message"][0]]));
}, $regularUserController, $middleware);

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
