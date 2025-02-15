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
                "LOGOUT_ERR" => "You are already logged out",
                "somedata" => $currentUserData
            ]));
        }

        $currentUserEmail = $currentUserData["currentAccountBasicInfo"][0]["user_email"] ?? null;

        $UUID = $this->regularUserModel->getGeneralAccountInformations($currentUserEmail)[0]["UUID"];

        if (empty($UUID)) {
            die(json_encode(["LOGOUT_ERR" => "Something went wrong!"]));
        }

        if (!$this->regularUserModel->addAccountLogRecords(2, 2, $UUID)) {
            $msg = $this->middleware->getMsg("LOGOUT_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }


        session_unset();
        session_destroy();

        /*
        $this->middleware->unsetSessions();
        $this->middleware->destroySessions();
        */
    }

    public function updateAccountInformation()
    {
        $currentUserData = $this->middleware->getSessionData("userAccount");

        if (!$currentUserData) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            die("shit");
        };

        $findUser = $this->regularUserModel->getGeneralAccountInformations($currentUserData["currentAccountBasicInfo"][0]["user_email"]);

        if (empty($findUser)) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            exit();
        }

        $fullAccountData = $this->regularUserModel->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        if (!$this->middleware->setSessionData("userAccount", $fullAccountData)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }
    }

    public function signup(array $data)
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

        $fullAccountData = $this->regularUserModel->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        if (!$this->middleware->setSessionData("userAccount", $fullAccountData)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }
    }





    public function getAllProfileInfo() {}
    public function addTask() {}
    public function removeTask() {}
    public function markFinishedTask() {}
    public function addProfilePicture() {}
};
