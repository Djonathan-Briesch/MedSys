<?php

class DoctorDTO implements JsonSerializable
{
    private $id; // de id até cpf é da tabela user
    private $name;
    private $email;
    private $birthDate;
    private $cpf;
    private $specialty; // esse é da tabela doctor, q tem o id do doctor e a especialidade dele
    private $availability; // vem da tabela doctoravailability, tem q ser um objeto desse tipo

    public function __construct($id, $name, $email, $birthDate, $cpf, $specialty, $availability)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->cpf = $cpf;
        $this->specialty = $specialty;
        $this->availability = $availability;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getSpecialty()
    {
        return $this->specialty;
    }
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;
    }

    public function getAvailability()
    {
        return $this->availability;
    }
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    public function __toString()
    {
        return "DoctorDTO[id={$this->id}, name={$this->name}, email={$this->email}]";
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthDate' => $this->birthDate,
            'cpf' => $this->cpf,
            'specialty' => $this->specialty,
            'availability' => $this->availability,
        ];
    }
}