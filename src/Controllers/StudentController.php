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

    public function studentFullRegistration(array $studentInfo, string $UUID)
    {
        $student_informations = [
            "LRN" => $this->middleware->stringSanitization($studentInfo["LRN"]),
            "firstname" => $this->middleware->stringSanitization($studentInfo["firstname"]),
            "lastname" => $this->middleware->stringSanitization($studentInfo["lastname"]),
            "age" => $this->middleware->stringSanitization($studentInfo["age"]),
            "hometown" => $this->middleware->stringSanitization($studentInfo["hometown"]),
            "current_location" => $this->middleware->stringSanitization($studentInfo["current_location"]),
        ];
        $this->studentModel->setNewPremiumAcc($student_informations, $UUID);
    }
};
