<?php

require_once 'BaseEntity.php';

class User extends BaseEntity
{
    private $name;
    private $email;
    private $birthDate;
    private $cpf;
    private $password;
    private $type;

    public function __construct($id, $name, $email, $birthDate, $cpf, $password, $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->cpf = $cpf;
        $this->password = $password;
        $this->type = $type;
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

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return "User[id={$this->id}, name={$this->name}, email={$this->email}, type={$this->type}]";
    }
}