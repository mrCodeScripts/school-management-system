<?php

class TeacherController
{
   private $middleware;
   private $teacherModel;

   public function __construct()
   {
      $this->middleware = new Middleware();
      $this->teacherModel = new TeacherModel();
   }

   public function teacherFullRegistration(array $studentInfo, string $UUID)
   {
      $student_informations = [
         "professional_id" => $this->middleware->stringSanitization($studentInfo["professional_id"]),
         "firstname" => $this->middleware->stringSanitization($studentInfo["firstname"]),
         "lastname" => $this->middleware->stringSanitization($studentInfo["lastname"]),
         "age" => $this->middleware->stringSanitization($studentInfo["age"]),
         "hometown" => $this->middleware->stringSanitization($studentInfo["hometown"]),
         "current_location" => $this->middleware->stringSanitization($studentInfo["current_location"]),
      ];
      $this->teacherModel->setNewPremiumAcc($student_informations, $UUID);
   }
};
