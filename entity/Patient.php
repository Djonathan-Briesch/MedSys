<?php

require_once 'BaseEntity.php';

class Patient extends BaseEntity {
    private $userId;
    private $healthPlan;

    public function __construct($id, $userId, $healthPlan) {
        $this->id = $id;
        $this->userId = $userId;
        $this->healthPlan = $healthPlan;
    }

    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }

    public function getHealthPlan() { return $this->healthPlan; }
    public function setHealthPlan($healthPlan) { $this->healthPlan = $healthPlan; }

    public function __toString() {
        return "Patient[id={$this->id}, userId={$this->userId}, healthPlan={$this->healthPlan}]";
    }
}
