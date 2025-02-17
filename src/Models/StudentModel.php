<?php

class StudentModel extends DatabaseModel
{
    public function setNewPremiumAcc(array $studentData, string $UUID)
    {
        $registered_user = [
            "entity_id" => $studentData["LRN"] ?? null,
            "UUID" => $UUID ?? null,
            "register_role" => 4,
            "registration_status_id" => 1,
        ];

        $registered_user_query = "INSERT INTO all_registered_users 
            (entity_id, UUID, register_role, registration_status_id)
            VALUES (:entity_id, :UUID, :register_role, :registration_status_id);";
        $student_informations = "INSERT INTO registered_students 
            (LRN, firstname, lastname, age, hometown, current_location)
            VALUES (:LRN, :firstname, :lastname, :age, :hometown, :current_location);";

        $this->setBindedExecution($registered_user_query, $registered_user);
        $this->setBindedExecution($student_informations, $studentData);
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
