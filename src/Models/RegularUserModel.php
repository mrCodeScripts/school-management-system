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

   public function addNewTask(string $UUID, string $taskID, string $taskDescription, string $taskDeadline) {}
   public function removeTask(string $UUID, string $taskID) {}
   public function setCompleteTasks(string $UUID, string $taskID, string $datetime) {}
   public function setIncompleteTasks(string $taskId, string $datetime) {}
   public function getTaskInformation() {}
   public function getAllTaskInformations() {}

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
}
