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

    public function checkIfAccPremium(string $email)
    {
        return false;
    }

    public function premiumRegistration(array $data, string $UUID)
    {
        /*
        $producedEntityID = $this->middleware->getUUID();
        $this->studentModel->setNewPremiumAcc($data, $UUID);
        $logData = [
            "registration_status_id" => 1,
            "entity_id" => $producedEntityID,
            "UUID" => $UUID,
            "register_role" => 4,
        ];
        $this->studentModel->setNewPremiumRegRecord($logData, $UUID);
        */
    }
};
