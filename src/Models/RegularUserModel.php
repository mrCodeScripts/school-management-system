<?php

declare(strict_types=1);

class RegularUserModel extends DatabaseModel
{
   private $databaseModel;
   private $middleware;

   public function __construct()
   {
      parent::__construct();
      $this->databaseModel = DatabaseModel::getInstance();
      $this->middleware = new Middleware();
   }

   # PURE QUERIES
   public function getBasicAccountInformations(
      string $UUID,
      string $email,
   ) {
      $query = "SELECT 
         ua.user_firstname,
         ua.user_lastname, 
         ua.user_email,
         ua.user_age, 
         g.gender_name, 
         ua.account_created,
         ur.role_name 
         FROM user_accounts ua 
         JOIN gender_types g 
         ON g.gender_id = ua.user_gender_type 
         JOIN user_roles ur 
         ON ur.role_id = ua.user_role_id 
         WHERE ua.UUID = :UUID
         AND ua.user_email = :email;";
      return $this->setBindedExecution(
         $query,
         ["UUID" => $UUID, "email" => $email]
      )->fetchAll();
   }

   public function getBasicLogInformations(
      string $UUID,
   ) {
      $query = "SELECT 
         lr.UUID, 
         lt.log_type_name, 
         ls.log_status_name, 
         lt.log_type_description, 
         lr.log_time 
         FROM user_logs lr 
         JOIN log_type lt 
         ON lt.log_type_id = lr.log_type 
         JOIN log_status ls 
         ON ls.log_status_id = lr.log_status 
         WHERE lr.UUID = :UUID ORDER BY lr.log_time DESC";
      return $this->setBindedExecution(
         $query,
         ["UUID" => $UUID]
      )->fetchAll();
   }

   public function getGeneralAccountInformations(
      string $email,
   ) {
      $query = "SELECT * FROM 
         user_accounts 
         WHERE user_email = :email;";
      return $this->setBindedExecution(
         $query,
         ["email" => $email]
      )->fetchAll();
   }

   public function addAccountLogRecords(
      int $logStatus,
      int $logType,
      string $UUID,
   ) {
      $query = "INSERT INTO 
         user_logs (log_type, log_status, UUID) 
         VALUES (:log_type, :log_status, :UUID);";
      $this->setBindedExecution(
         $query,
         [
            "log_type" => $logType,
            "log_status" => $logStatus,
            "UUID" => $UUID
         ]
      );
      return true;
   }

   public function addNewRegularAccount(
      string $UUID,
      string $fn,
      string $ln,
      string $email,
      string $pwd,
      int $age,
      string $gender_type,
      int $role
   ) {
      $userData = [
         "uuid" => $UUID,
         "ufn" => $fn,
         "uln" => $ln,
         "uem" => $email,
         "uag" => $age,
         "ugt" => $gender_type,
         "uri" => $role,
         "upw" => $pwd,
      ];
      $query = "INSERT INTO user_accounts 
         (UUID, user_firstname, 
         user_lastname, 
         user_email, 
         user_age, 
         user_gender_type, 
         user_role_id, 
         user_password
         ) VALUES (
         :uuid, 
         :ufn, 
         :uln, 
         :uem, 
         :uag, 
         :ugt, 
         :uri, 
         :upw);";
      if (!$this->setBindedExecution(
         $query,
         $userData
      )) return false;
      return true;
   }

   // public function setIncompleteTasks(string $taskId, string $datetime) {}
   // public function getTaskInformation() {}
   // public function getAllTaskInformations() {}

   # METHODS ASSOCIATED WITH THE QUERIES
   public function getAllUserData(
      string $UUID,
      string $email,
   ) {
      $accountDetails = $this->getBasicAccountInformations(
         $UUID,
         $email
      );
      $accountLogs = $this->getBasicLogInformations($UUID);
      $data = [
         "currentAccountBasicInfo" => $accountDetails,
         "currentAccountLogsInfo" => $this->modifyLogRecords($accountLogs),
      ];
      return $data;
   }

   public function modifyLogRecords(
      array $logRecords,
   ) {
      $newLogRecord = [];
      foreach ($logRecords as $record) {
         $newLogRecord[] = [
            ...$record,
            "last_accessed" => implode(
               ", ",
               $this->middleware
                  ->getTimeDiff($record["log_time"]),
            )
         ];
      }
      return $newLogRecord;
   }

   public function getPremiumAccountData(string $UUID, ?string $entityType = null)
   {
      $entity = '';
      switch ($entityType) {
         case "student":
            $entity = "registered_students";
            break;
         case "teacher":
            $entity = "registered_teachers";
            break;
         case "parents":
            $entity = "registered_parents";
            break;
         case "admin":
            $entity = "registered_administrators";
            break;
         default:
            $entity = "registered_students, 
            registered_teachers, registered_parents,
            registered_administrators";
            break;
      }
      $query = "SELECT * FROM {$entity} WHERE UUID = :UUID;";
      $this->databaseModel->setBindedExecution($query, ["UUID" => $UUID]);
   }

   public function getAllGenderTypes()
   {
      $query = "SELECT * FROM gender_types;";
      return $this->setBindedExecution($query)->fetchAll();
   }

   public function setNewTask($data)
   {
      $query = "INSERT INTO tasks (
            task_id,
            UUID,
            task_title,
            task_type,
            task_deadline,
            task_priority,
            task_description,
            task_status_id
         ) VALUES (
            :task_id,
            :UUID,
            :task_title,
            :task_type,
            :task_deadline,
            :task_priority,
            :task_description,
            :task_status_id
         );
      ";

      $this->setBindedExecution($query, $data);
   }

   public function getAllTask($UUID, $sort)
   {
      # TODO
      $query = "SELECT * FROM 
         tasks, 
         task_priorities, 
         task_types,
         task_status
         WHERE UUID = :UUID 
         AND task_priorities.task_priority_id = tasks.task_priority 
         AND task_types.task_type_id = tasks.task_type 
         AND task_status.task_status_id = tasks.task_status_id
         ORDER BY {$sort};
      ";
      return $this->setBindedExecution(
         $query,
         ["UUID" => $UUID],
      )->fetchAll();
   }

   public function getTask($UUID, $taskID)
   {
      $query = "SELECT * FROM tasks, task_priorities,task_types
      WHERE UUID = :UUID 
      AND task_id = :task_id
      AND task_priorities.task_priority_id = tasks.task_priority 
      AND task_types.task_type_id = tasks.task_type;";
      return $this->setBindedExecution(
         $query,
         ["UUID" => $UUID, "task_id" => $taskID],
      )->fetchAll();
   }

   public function filterFetchedTasks($fetchedTask)
   {
      $newList = [];
      foreach ($fetchedTask as $task) {
         $newList[] = [
            "task_id" => $task["task_id"],
            "task_title" => $task["task_title"],
            "task_type" => $task["task_type_name"],
            "task_created_on" => $this->middleware->getModifiedTime($task["task_created_on"]),
            "task_deadline" => $this->middleware->getModifiedTime($task["task_deadline"]),
            "task_days_remaining" => $this->middleware->getTimeDiff($task["task_deadline"]),
            "task_priority" => $task["task_priority_name"],
            "task_description" => $task["task_description"],
            "task_status" => $task["task_status_name"],
            "task_last_mofied" => $task["task_last_modified"] ? $this->middleware->getModifiedTime($task["task_last_modified"]) : null,
            "task_raw_data" => [
               "raw_task_status_id" => $task["task_status_id"],
               "raw_task_deadline" => $task["task_deadline"],
               "raw_task_created_on" => $task["task_created_on"],
               "raw_task_priority_id" => $task["task_priority_id"],
               "raw_task_type_id" => $task["task_type_id"],
               "raw_task_completion_date" => $task["task_completion"] ?? null,
               "raw_task_last_modified" => $task["task_last_modified"],
            ]
         ];
      }
      return $newList;
   }

   public function deleteTask($data)
   {
      # TODO
      $query = "DELETE FROM tasks 
      WHERE UUID = :UUID AND task_id = :task_id;
      ";
      return $this->setBindedExecution($query, $data);
   }

   public function findPremiumRegsiteredAccount(string $UUID): bool
   {
      $query = "SELECT * 
            FROM all_registered_users 
            WHERE UUID = :UUID;";
      return $this->setBindedExecution($query, [
         "UUID" => $UUID,
      ])->fetchAll() ? true : false;
   }

   public function setCompleteTasks(
      string $UUID,
      string $taskID,
      $datetime,
   ) {
      # TODO
      $data = [
         "UUID" => $UUID,
         "task_id" => $taskID,
         "task_status_id" => 2,
         "task_completion" => $datetime,
      ];

      $query = "UPDATE tasks 
      SET 
         task_status_id = :task_status_id, 
         task_completion = :task_completion 
      WHERE UUID = :UUID 
      AND task_id = :task_id;";
      return $this->setBindedExecution($query, $data);
   }

   public function changeTaskTitle(
      $data,
      $timeModif,
   ) {
      # TODO
      $newData = [
         "task_id" => $data["task_id"],
         "task_title" => $this->middleware->stringSanitization($data["task_title"]),
         "UUID" => $data["UUID"],
         "task_last_modified" => $timeModif,
      ];

      $query = "UPDATE tasks SET
         task_title = :task_title,
         task_last_modified = :task_last_modified
      WHERE UUID = :UUID
      AND task_id = :task_id;";
      return $this->setBindedExecution($query, $newData);
   }
};
