<?php

require_once 'BaseEntity.php';

class CRM extends BaseEntity {
    private $doctorId;
    private $number;
    private $state;

    public function __construct($id, $doctorId, $number, $state) {
        $this->id = $id;
        $this->doctorId = $doctorId;
        $this->number = $number;
        $this->state = $state;
    }

    public function getDoctorId() { return $this->doctorId; }
    public function setDoctorId($doctorId) { $this->doctorId = $doctorId; }

    public function getNumber() { return $this->number; }
    public function setNumber($number) { $this->number = $number; }

    public function getState() { return $this->state; }
    public function setState($state) { $this->state = $state; }

    public function __toString() {
        return "CRM[id={$this->id}, number={$this->number}, state={$this->state}]";
    }
}
