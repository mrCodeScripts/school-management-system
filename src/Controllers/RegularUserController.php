<?php

declare(strict_types=1);

class RegularUserController
{
    private $configurations;
    private $middleware;
    private $messages = [];
    private $regularUserModel;

    public function __construct()
    {
        $this->middleware = new Middleware();
        $this->regularUserModel = new RegularUserModel();
    }

    public function loginAccount(string $email, string $password)
    {
        $findUser = $this->regularUserModel
            ->getGeneralAccountInformations($email) ?? null;

        if (empty($findUser)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->middleware->setSessionData("message", $msg["message"][1]);
            die(json_encode([
                "message" => $msg["message"][1],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
                "refresh" => false,
                "stop_load" => true,
            ]));
        }

        if ($this->middleware->isUserAlreadyLoggedIn()) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->regularUserModel->addAccountLogRecords(
                3,
                4,
                $findUser[0]["UUID"]
            );
            $this->updateAccountInformation();
            die(json_encode([
                "message" => $msg["message"][0],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
                "refresh" => false,
                "stop_load" => true,
            ]));
        }

        if (!$this->middleware->isMatchedPassword(
            $password,
            $findUser[0]["user_password"]
        )) {
            $msg = $this->middleware->getMsg("PASSWORD_ERR");
            $this->regularUserModel->addAccountLogRecords(
                1,
                5,
                $findUser[0]["UUID"]
            );
            die(json_encode([
                "message" => $msg["message"][0],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
                "refresh" => false,
                "stop_load" => true,
            ]));
            return;
        }

        $fullAccountData = $this->regularUserModel
            ->getAllUserData(
                $findUser[0]["UUID"],
                $findUser[0]["user_email"]
            );

        if (!$this->regularUserModel->addAccountLogRecords(
            2,
            1,
            $findUser[0]["UUID"]
        )) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            die(json_encode([
                "message" => $msg["message"][3],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
                "refresh" => false,
                "stop_load" => true,
            ]));
        }

        if (!$this->middleware->setSessionData(
            "userAccount",
            $fullAccountData
        )) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->middleware->setSessionData(
                "message",
                $msg["message"][2]
            );
            die(json_encode([
                "message" => $msg["message"][2],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
                "refresh" => false,
                "stop_load" => true,
            ]));
        }

        $msg = $this->middleware->getMsg("ACCESS_GRANTED");
        die(json_encode([
            "message" => $msg["message"][0],
            "type" => $msg["messageName"],
            "status" => "successful",
            "refresh" => true,
            "stop_load" => true,
        ]));
    }

    public function logoutAccount()
    {
        $currentUserData = $this->middleware->getSessionData("userAccount");

        if (empty($currentUserData)) {
            die(json_encode([
                "message" => "You are already logged out.",
                "type" => "LOGOUT_ERR",
                "status" => "unsuccessful",
            ]));
        }

        $currentUserEmail =
            $currentUserData["currentAccountBasicInfo"][0]["user_email"]
            ?? null;

        $UUID = $this->regularUserModel
            ->getGeneralAccountInformations($currentUserEmail)[0]["UUID"];

        if (empty($UUID)) {
            die(json_encode([
                "message" => "Something went wrong!",
                "type" => "LOGOUT_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->addAccountLogRecords(
            2,
            2,
            $UUID
        )) {
            $msg = $this->middleware->getMsg("LOGOUT_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode([
                "message" => $msg["message"][2],
                "type" => $msg["messageName"],
                "status" => "unsuccessful",
            ]));
        }

        session_unset();
        session_destroy();
    }

    public function updateAccountInformation()
    {
        $currentUserData = $this->middleware->getSessionData("userAccount");

        if (!$currentUserData) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            ## ADDMESSGE HERE
            // die(json_encode[""])
        };

        $findUser = $this->regularUserModel->getGeneralAccountInformations($currentUserData["currentAccountBasicInfo"][0]["user_email"]);

        if (empty($findUser)) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            exit();
        }

        $fullAccountData = $this->regularUserModel->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        $_SESSION["userAccount"] = $fullAccountData;

        /*
        if (!$this->middleware->setSessionData("userAccount", $fullAccountData)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }
        */
    }

    public function signupAccount(array $data)
    {
        $findUser = $this->regularUserModel->getGeneralAccountInformations($data["email"]) ?? null;

        if ($findUser) {
            $msg = $this->middleware->getMsg("SIGNUP_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][0];
            die(json_encode($this->messages));
        }

        if ($this->regularUserModel->addNewRegularAccount(...$data) === false) {
            $msg = $this->middleware->getMsg("SIGNUP_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][1];
            die(json_encode($this->messages));
        }

        if (!$this->regularUserModel->addAccountLogRecords(2, 3, $data["UUID"])) {
            $msg = $this->middleware->getMsg("SIGNUP_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }

        $findUser = $this->regularUserModel->getGeneralAccountInformations($data["email"]) ?? null;

        $fullAccountData = $this->regularUserModel->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        if (!$this->middleware->setSessionData("userAccount", $fullAccountData)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }
    }

    public function checkIfAccPremium(string $email)
    {
        $generalAccData = $this->regularUserModel
            ->getGeneralAccountInformations($email);
        $findPremiumAcc = $this->regularUserModel->getPremiumAccountData($generalAccData["UUID"]);
        if ($findPremiumAcc) {
            return true;
        } else {
            return false;
        }
    }


    public function addTask(
        string $UUID,
        string $taskName,
        string $taskDescription,
        string $status,
        string $deadline,
    ) {
        # filter the tasks
        # find if the task id already exist in the database
        # if it already exist in the
    }

    public function removeTask() {}
    public function markFinishedTask() {}
    public function addProfilePicture() {}
};
