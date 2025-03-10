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

    # UPDATE ALL DATA OF THE ACCOUNT
    public function updateAccountInformation()
    {
        $currentUserData = $this->middleware->getSessionData("userAccount");

        if (!$currentUserData) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            die(json_encode([
                "message" => "You are not logged in yet bitch!",
                "type" => "USER_UPDATE_ACC",
                "status" => "unsuccessful",
            ]));
        };

        $userEmail =
            $currentUserData["currentAccountBasicInfo"][0]["user_email"] ?? null;

        $findUser = $this->regularUserModel
            ->getGeneralAccountInformations($userEmail);

        if (empty($findUser)) {
            $this->middleware->destroySessions();
            $this->middleware->unsetSessions();
            exit();
        }

        $fullAccountData = $this->regularUserModel
            ->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        $_SESSION["userAccount"] = $fullAccountData;
    }

    public function signupAccount(array $data)
    {
        $findUser = $this->regularUserModel
            ->getGeneralAccountInformations($data["email"]) ?? null;

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

        $findUser = $this->regularUserModel
            ->getGeneralAccountInformations($data["email"]) ?? null;

        $fullAccountData = $this->regularUserModel
            ->getAllUserData($findUser[0]["UUID"], $findUser[0]["user_email"]);

        if (!$this->middleware->setSessionData("userAccount", $fullAccountData)) {
            $msg = $this->middleware->getMsg("LOGIN_ERR");
            $this->messages[$msg["messageName"]] = $msg["message"][2];
            die(json_encode($this->messages));
        }
    }

    ## =================== TASKS =====================================
    public function validateTaskAccess()
    {
        # TODO

        $existingUser = $_SESSION["userAccount"] ?? null;
        if (empty($existingUser)) {
            die(json_encode([
                "message" => "You are not logged in yet bitch!",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        $userEmail =
            $existingUser["currentAccountBasicInfo"][0]["user_email"] ?? null;
        $generalAccData = $this->regularUserModel
            ->getGeneralAccountInformations($userEmail) ?? null;
        $UUID = $generalAccData[0]["UUID"];

        return [$UUID, $userEmail];
    }

    public function createTask($taskData)
    {
        $filterData = [
            "task_id" => $this->middleware->stringSanitization($taskData["task_id"]),
            "UUID" => $this->middleware->stringSanitization($taskData["UUID"]),
            "task_title" => $this->middleware->stringSanitization($taskData["task_title"]),
            "task_type" => $taskData["task_type"],
            "task_deadline" => $this->middleware->stringSanitization($taskData["task_deadline"]),
            "task_priority" => intval($taskData["task_priority"]),
            "task_description" => $this->middleware->stringSanitization($taskData["task_description"]),
            "task_status_id" => 1,
        ];

        $this->regularUserModel->setNewTask($filterData);
    }

    public function deleteTask($taskData)
    {
        $getTask = $this->regularUserModel->getTask(
            $taskData["UUID"],
            $taskData["task_id"],
        );

        if (!$getTask) {
            die(json_encode([
                "message" => "Task does not exist.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->deleteTask($taskData)) {
            die(json_encode([
                "message" => "Failed to delete task",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }
    }

    public function validateTasksExists($data, $sendMsg = false)
    {
        # TODO
        $existedItems = [];
        $errMessages = [];

        foreach ($data["data"] as $d) {
            $t = $this->regularUserModel->getTask(
                $data["UUID"],
                $d["task_id"],
            );
            if ($t) {
                $existedItems[] = $t[0];
            } else {
                $taskLabel = $d["task_name"] ?? $d["task_index"] ?? null;
                $errMessages[] = [
                    "taskName" => "'{$taskLabel}'",
                    "phrase" => "does not exist",
                ];
            }
        }

        if ($sendMsg && !empty($nonExistentItems)) {
            die(json_encode($errMessages));
        } else {
            return [$existedItems, $errMessages];
        }
    }

    public function taskManagerNotification($msg)
    {
        # TODO
    }

    public function deleteTasks($data)
    {
        # DONE (still on development) -- overal: DONE
        $msg = [
            "type" => "SPECIAL_TASK_MANAGER_MSG",
            "status" => "unsuccessful",
            "messages" => [
                "failed" => null,
                "success" => null,
            ],
        ];

        [$existedItems, $errMessages] = $this->validateTasksExists($data);
        if (!empty($errMessages)) {
            foreach ($errMessages as $msgs) {
                $msg["messages"]["failed"][] = [
                    "errSaltStmnt" => "Failed to remove task named ",
                    ...$msgs,
                ];
            }
        } else {
            $msg["messages"]["failed"] = null;
        }

        if (!empty($existedItems)) {
            foreach ($existedItems as $data) {
                if ($this->regularUserModel->deleteTask(
                    [
                        "UUID" => $data["UUID"],
                        "task_id" => $data["task_id"]
                    ]
                )) {
                    $msg["messages"]["success"][] = [
                        "taskName" =>  $data["task_title"],
                        "phrase" => "Successfuly deleted {$data["task_title"]}",
                        "saltStmnt" => "Successfuly deleted",
                    ];
                } else {
                    $msg["messages"]["failed"][] = [
                        "taskName" => $data["task_title"],
                        "phrase" => "Failed to remove {$data["task_title"]}",
                        "saltStmnt" => "Failed to remove",
                    ];
                }
            }
        }
        die(json_encode($msg));
    }

    public function completedTask($data)
    {
        # TODO
        $msg = [
            "type" => "SPECIAL_TASK_MANAGER_MSG",
            "status" => "neutral",
            "messages" => [
                "failed" => null,
                "success" => null,
            ],
        ];

        [$existedItems, $errMessages] = $this->validateTasksExists($data);
        if (!empty($errMessages)) {
            foreach ($errMessages as $msgs) {
                $msg["messages"]["failed"][] = [
                    "errSaltStmnt" => "Failed to set complete task",
                    ...$msgs,
                ];
            }
        } else {
            $msg["messages"]["failed"] = null;
        }

        $currentDate = $this->middleware->getCurrentTime();

        if (!empty($existedItems)) {
            foreach ($existedItems as $data) {
                if ($data["task_status_id"] !== 2) {
                    if (!$this->regularUserModel->setCompleteTasks(
                        $data["UUID"],
                        $data["task_id"],
                        $currentDate,
                    )) {
                        $msg["messages"]["failed"][] = [
                            "taskName" => $data["task_title"],
                            "phrase" => "Failed to set complete task: {$data["task_title"]}",
                            "saltStmnt" => "Failed to set complete task",
                        ];
                    }
                    $msg["messages"]["success"][] = [
                        "taskName" =>  $data["task_title"],
                        "phrase" => "Successfuly completed task: {$data["task_title"]}",
                        "saltStmnt" => "Successfuly completed",
                    ];
                } else {
                    $msg["messages"]["failed"][] = [
                        "taskName" => $data["task_title"],
                        "phrase" => "This task is already set to complete: {$data["task_title"]}",
                        "saltStmnt" => "Task is already set to complete",
                    ];
                }
            }
        }
        die(json_encode($msg));
    }



    public function updateTaskList(
        string $UUID,
        string $prefferedOrder = "task_created_on",
        string $sortDirection = "DESC",
    ) {
        $sortingPhrase = "{$prefferedOrder} {$sortDirection}";
        $fetchedTasks = $this->regularUserModel->getAllTask(
            $UUID,
            $sortingPhrase
        );
        $_SESSION["userAccount"]["currentAccountTaskList"] = [
            "prefferedTaskListOrder" => $sortingPhrase,
            "userTaskList" => [
                ...$this->regularUserModel->filterFetchedTasks($fetchedTasks),
            ]
        ];
    }

    public function changeTaskTitle($data)
    {
        $getTask = $this->regularUserModel->getTask(
            $data["UUID"],
            $data["data"][0]["task_id"],
        );
        
        if (!$getTask) {
            die(json_encode([
                "message" => "Task does not exist.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->changeTaskTitle(
            $data,
            $this->middleware->getCurrentTime()
        )) {
            die(json_encode([
                "message" => "Failed to change task title.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful"
            ]));
        }
    }

    public function changeTaskDescription($data)
    {
        $getTask = $this->regularUserModel->getTask(
            $data["UUID"],
            $data["task_id"],
        );

        if (!$getTask) {
            die(json_encode([
                "message" => "Task does not exist.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->changeTaskDesc(
            $data,
            $this->middleware->getCurrentTime()
        )) {
            die(json_encode([
                "message" => "Failed to change task title.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful"
            ]));
        }
    }

    public function changeTaskPriority($data, $d = null)
    {
        $getTask = $this->regularUserModel->getTask(
            $data["UUID"],
            $data["task_id"],
        );

        if (!$getTask) {
            die(json_encode([
                "message" => "Task does not exist.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->changeTaskPriority(
            $data,
            $this->middleware->getCurrentTime()
        )) {
            die(json_encode([
                "message" => "Failed to change task title.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful"
            ]));
        }
    }

    public function changeTaskDeadline($data)
    {
        $getTask = $this->regularUserModel->getTask(
            $data["UUID"],
            $data["task_id"],
        );

        if (!$getTask) {
            die(json_encode([
                "message" => "Task does not exist.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful",
            ]));
        }

        if (!$this->regularUserModel->changeTaskDeadline(
            $data,
            $this->middleware->getCurrentTime()
        )) {
            die(json_encode([
                "message" => "Failed to change task title.",
                "type" => "TASK_MANAGER_ERR",
                "status" => "unsuccessful"
            ]));
        }
    }
    # =============================================================





    ##======================== INBOX ==================
    public function createInbox()
    {
        # TODO
    }

    public function deleteInbox()
    {
        # TODO
    }

    public function openInbox()
    {
        # TODO
    }

    public function markReadInbox()
    {
        # TODO
    }

    public function replyInbox()
    {
        # TODO
    }
    # =====================================================






    ## FILES
    public function uploadFile()
    {
        # TODO
    }

    public function downloadFile()
    {
        # TODO
    }

    public function listFile()
    {
        # TODO
    }

    public function deleteFile()
    {
        # TODO 
    }

    public function renameFile()
    {
        # TODO
    }

    public function metadataFile()
    {
        # TODO
    }
};
