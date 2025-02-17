<?php

class TeacherModel extends DatabaseModel
{
   public function setNewPremiumAcc(array $teacherData, string $UUID)
   {
      $registered_user = [
         "entity_id" => $teacherData["professional_id"] ?? null,
         "UUID" => $UUID ?? null,
         "register_role" => 5,
         "registration_status_id" => 1,
      ];

      $registered_user_query = "INSERT INTO all_registered_users 
            (entity_id, UUID, register_role, registration_status_id)
            VALUES (:entity_id, :UUID, :register_role, :registration_status_id);";
      $student_informations = "INSERT INTO registered_teachers 
            (professional_id, firstname, lastname, age, hometown, current_location)
            VALUES (:professional_id, :firstname, :lastname, :age, :hometown, :current_location);";

      $this->setBindedExecution($registered_user_query, $registered_user);
      $this->setBindedExecution($student_informations, $teacherData);
   }

   public function getGeneralPremiumAccData(string $UUID, int $roleId = 4)
   {
      $query = "SELECT * 
            FROM all_registered_users 
            WHERE UUID = :UUID 
            AND register_role = :register_role;";
      return $this->setBindedExecution($query, [
         "UUID" => $UUID,
         "register_role" => $roleId,
      ])->fetchAll();
   }

   public function getRegisteredStudentInformations(string $LRN)
   {
      $query = "SELECT *
            FROM registered_students
            WHERE LRN = :LRN;";
      return $this->setBindedExecution($query, [
         "LRN" => $LRN,
      ]);
   }
};
