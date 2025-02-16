<?php

declare(strict_types=1);
class DatabaseModel
{
  private static $instance = null;
  private $configSettings;
  private $connection;

  public function __construct()
  {
    $this->configSettings = Config::getAllSettings();
    $this->connection = $this->createConnection();
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new DatabaseModel();
    }
    return self::$instance;
  }

  private function createConnection()
  {
    $username = $this->configSettings["database_username"];
    $host = $this->configSettings["database_host"];
    $password = $this->configSettings["database_password"];
    $databaseName = $this->configSettings["database_name"];
    $dsn = "mysql:host={$host};dbname={$databaseName};charset=utf8";
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    try {
      $connection = new PDO($dsn, $username, $password, $options);
      return $connection;
    } catch (PDOException $e) {
      throw new Exception("Database connection error: " . $e->getMessage());
    }
  }

  public function haveConnection()
  {
    return $this->connection;
  }

  public function isTableExist(string $tableName)
  {
    $query = "SHOW TABLES LIKE :tableName";
    $statement = $this->haveConnection()->prepare($query);
    $statement->execute([":tableName" => $tableName]);
    return $statement->rowCount() > 0;
  }

  public function areTableExists(array $tables)
  {
    foreach ($tables as $table) {
      if (!$this->isTableExist($table)) {
        return false;
      }
    }
  }

  public function queryPlaceholderGenerator(array $data, string $condition = "AND"): array
  {
    $placeholders = [];
    $arrayPlaceholders = [];
    $arrayData = [];
    $queryConditions = [];
    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $keyParam = ":{$key}_" . implode("_", array_keys($value));
        foreach ($value as $subKey => $subValue) {
          $subKeyParam = ":{$key}_{$subKey}";
          $arrayPlaceholders[$subKeyParam] = $subValue;
          $arrayData[] = $subValue;
          $queryConditions[] = "{$key} LIKE {$subKeyParam}";
        }
      } else {
        $keyParam = ":{$key}";
        $arrayPlaceholders[$keyParam] = $value;
        $arrayData[] = $value;
        $queryConditions[] = "{$key} = {$keyParam}";
      }
    }
    $stringPlaceholder1 = implode(", ", array_keys($arrayPlaceholders));
    $stringPlaceholder2 = implode(" $condition ", $queryConditions);
    $stringData = implode(", ", $arrayData);
    $placeholders["keyPlaceholder1"] = $arrayPlaceholders;
    $placeholders["keyPlaceholder2"] = $stringPlaceholder1;
    $placeholders["keyPlaceholder3"] = $stringPlaceholder2;
    $placeholders["dataPlaceholder2"] = $stringData;
    return $placeholders;
  }

  public function isDataExist(array $searchData, string $tableName, string $condition)
  {
    if (!$this->isTableExist($tableName)) {
      echo json_encode(["message" => "table does not exist"]);
      return false;
    }
    $queryPlaceholderGenerator = $this->queryPlaceholderGenerator($searchData, $condition);
    $executionPlaceholders = $queryPlaceholderGenerator["keyPlaceholder1"];
    $queryDataPlaceholders = $queryPlaceholderGenerator["keyPlaceholder3"];
    $query = "SELECT * FROM `{$tableName}` WHERE {$queryDataPlaceholders};";
    $statement = $this->haveConnection()->prepare($query);
    $statement->execute($executionPlaceholders);
    $data = $statement->fetchAll();
    if (!$data) {
      return false;
    }
    return true;
  }

  public function getAllData(string | array $selectedColumn, array $searchedData, array $tableNames, string $condition = "AND")
  {
    $conditionPlaceholders = $this->queryPlaceholderGenerator($searchedData, $condition);
    if ($this->areTableExists($tableNames) === false) {
      die(json_encode(["SERVER_DB_ERR" => "Table name does not exist in the database."]));
    }
    if (is_array($selectedColumn)) $selectedColumn = implode(", ", $selectedColumn);
    if (is_array($tableNames)) $tableName = implode(", ", $tableNames);
    $query = "SELECT {$selectedColumn} FROM {$tableName} WHERE " . "{$conditionPlaceholders["keyPlaceholder3"]};";
    // echo json_encode($query);
    $statement = $this->haveConnection()->prepare($query);
    $statement->execute($conditionPlaceholders["keyPlaceholder1"]);
    $data = $statement->fetchAll();
    return $data;
  }


  // $query = "SELECT log_type.log_type_name, log_status.log_status_name, user_logs.log_time WHERE UUID = :UUID;";

  public function getAllDatabaseData() {}

  public function getAllTableData() {}

  public function setDataInsertion(string $tableName, array $data)
  {
    $placeholders = $this->queryPlaceholderGenerator($data);
    $query = "INSERT INTO `{$tableName}` (" . implode(", ", array_keys($data)) . ") VALUES (" . $placeholders['keyPlaceholder2'] . ")";
    $statement = $this->haveConnection()->prepare($query);
    return $statement->execute($placeholders['keyPlaceholder1']);
  }

  public function setUpdateInsertion(string $tableName, array $data, array $conditions)
  {
    $setPlaceholders = $this->queryPlaceholderGenerator($data, ",");
    $conditionPlaceholders = $this->queryPlaceholderGenerator($conditions);
    $query = "UPDATE `{$tableName}` SET " . $setPlaceholders['keyPlaceholder3'] . " WHERE " . $conditionPlaceholders['keyPlaceholder3'];
    $statement = $this->haveConnection()->prepare($query);
    return $statement->execute(array_merge($setPlaceholders['keyPlaceholder1'], $conditionPlaceholders['keyPlaceholder1']));
  }

  public function setDeleteData(string $tableName, array $conditions)
  {
    $conditionPlaceholders = $this->queryPlaceholderGenerator($conditions);
    $query = "DELETE FROM `{$tableName}` WHERE " . $conditionPlaceholders['keyPlaceholder3'];
    $statement = $this->haveConnection()->prepare($query);
    return $statement->execute($conditionPlaceholders['keyPlaceholder1']);
  }

  public function setBindedExecution(string $query, ?array $bindData = null)
  {
    // $placeholder = $this->queryPlaceholderGenerator($bindData)["keyPlaceholder1"];
    $statement = $this->haveConnection()->prepare($query);
    if (!empty($bindData)) {
      foreach ($bindData as $key => $value) {
        $statement->bindValue(":$key", $value);
      }
    }
    $statement->execute();
    return $statement;
  }


  public function startTransaction()
  {
    $this->haveConnection()->beginTransaction();
  }

  public function commitTransaction()
  {
    $this->haveConnection()->commit();
  }

  public function rollbackTransaction()
  {
    $this->haveConnection()->rollBack();
  }
};







/*
  Queries created for the database;


  -- for genders
  INSERT INTO gender_types (gender_id, gender_name, gender_description) VALUES ('M', 'Male', 'Refers to the male gender'), ('F', 'Female', 'Refers to the female gender'), ('N/A', 'N/A', 'Rather not say');

  -- for user roles
  INSERT INTO user_roles (role_name, role_description) VALUES ("Regular User", "Users with limited access to the application's features."), ("Premium User", "Users with full access to the application's features, which means they are already enrolled or registered as part of the school"), ("Administrator", "The main administrator or manager of the system.");


  -- for log types and log status
  INSERT INTO log_status (log_status_name, log_status_description) VALUES 
  ("Unsuccessful", "Something might went wrong or is invalid or inapproriate access."),
  ("Successful", "Successful access or is have granted access."),
  ("Suspicious", "Something unusual happened or malicious access of data or action.");

  INSERT INTO log_type () VALUES
  ("Login", "Accessing of account."),
  ("Logout", "Loggin out of account"),
  ("Signup", "Creating new account.");
  ("Unusual Login", "Already logged in?")
  ("Password Error", "Wrong password? Is this you?");
*/