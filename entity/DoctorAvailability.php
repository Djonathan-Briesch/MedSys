<?php

require_once 'BaseEntity.php';

class DoctorAvailability extends BaseEntity {
    private $doctorId;
    private $weekDay;
    private $startTime;
    private $endTime;

    public function __construct($id, $doctorId, $weekDay, $startTime, $endTime) {
        $this->id = $id;
        $this->doctorId = $doctorId;
        $this->weekDay = $weekDay;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getDoctorId() { return $this->doctorId; }
    public function setDoctorId($doctorId) { $this->doctorId = $doctorId; }

    public function getWeekDay() { return $this->weekDay; }
    public function setWeekDay($weekDay) { $this->weekDay = $weekDay; }

    public function getStartTime() { return $this->startTime; }
    public function setStartTime($startTime) { $this->startTime = $startTime; }

    public function getEndTime() { return $this->endTime; }
    public function setEndTime($endTime) { $this->endTime = $endTime; }

    public function __toString() {
        return "DoctorAvailability[id={$this->id}, doctorId={$this->doctorId}, weekDay={$this->weekDay}]";
    }
}
