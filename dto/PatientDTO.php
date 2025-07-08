<?php

class PatientDTO
{
    private $id;
    private $name;
    private $email;
    private $birthDate;
    private $cpf;
    private $healthPlan;

    public function __construct($id, $name, $email, $birthDate, $cpf, $healthPlan) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->cpf = $cpf;
        $this->healthPlan = $healthPlan;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getBirthDate() { return $this->birthDate; }
    public function setBirthDate($birthDate) { $this->birthDate = $birthDate; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; }

    public function getHealthPlan() { return $this->healthPlan; }
    public function setHealthPlan($healthPlan) { $this->healthPlan = $healthPlan; }

    public function __toString() {
        return "PatientDTO[id={$this->id}, name={$this->name}, email={$this->email}]";
    }
}