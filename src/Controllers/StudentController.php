<?php

class StudentController
{
    private $middleware;
    private $studentModel;

    public function __construct()
    {
        $this->middleware = new Middleware();
        $this->studentModel = new StudentModel();
    }

    public function studentFullRegistration(string $UUID)
    {
        # TODO

        # collect the data
        $registered_user = [
            "entity_id" => $_POST["register_lrn"] ?? null,
            "UUID" => $UUID ?? null,
            "register_role" => 4,
            "registration_status_id" => 1,
        ];
        $student_informations = [
            "LRN" => $_POST["register_lrn"] ?? null,
            "firstname" => $_POST["register_firstname"] ?? null,
            "lastname" => $_POST["register_lastname"] ?? null,
            "age" => $_POST["register_age"] ?? null,
            "hometown" => $_POST["register_hometown"] ?? null,
            "current_location" => $_POST["current_location"] ?? null,
        ];

        $registered_user_query = "INSERT INTO all_registered_users 
            (entity_id, UUID, register_role, registration_status_id)
            VALUES (:entity_id, :UUID, :register_role, :registration_status_id);";
        $student_informations = "INSERT INTO registered_students 
            (LRN, firstname, lastname, age, hometown, current_location)
            VALUES (:LRN, :firstname, :lastname, :age, :hometown, :current_location);";
    }

    public function setNewPremiumAcc(array $data)
    {
        # TODO
    }
    public function setNewRegisteredStudent(array $data)
    {
        # TODO
    }
};
