<?php

class StudentModel extends DatabaseModel
{
    public function setNewPremiumAcc(array $data)
    {
        $query1 = "INSERT INTO 
            all_registered_users(
                entity_id, UUID, 
                register_role, registration_status_id
            ) VALUES (
                :entity_id, :UUID,
                :register_role, :registration_status_id
            );";

        $query2 = "INSERT INTO 
            all_registered_users(
                LRN, firstname, lastname, age, hometown, current_location
            ) VALUES (
                :LRN, :firstname, :lastname, :age, :hometown, :current_location
            );";
        $this->setBindedExecution($query1, $data);
    }

    public function getGeneralPremiumAccData(string $UUID, int $roleId)
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
};
