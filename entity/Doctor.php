<?php

require_once 'BaseEntity.php';

class Doctor extends BaseEntity {
    private $userId;
    private $specialtyId;

    public function __construct($id, $userId, $specialtyId) {
        $this->id = $id;
        $this->userId = $userId;
        $this->specialtyId = $specialtyId;
    }

    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }

    public function getSpecialtyId() { return $this->specialtyId; }
    public function setSpecialtyId($specialtyId) { $this->specialtyId = $specialtyId; }

    public function __toString() {
        return "Doctor[id={$this->id}, userId={$this->userId}, specialtyId={$this->specialtyId}]";
    }
}
