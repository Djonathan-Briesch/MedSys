<?php

require_once 'BaseEntity.php';

class Appointment extends BaseEntity {
    private $doctorId;
    private $patientId;
    private $startDateTime;
    private $endDateTime;
    private $status;
    private $notes;

    public function __construct($id, $doctorId, $patientId, $startDateTime, $endDateTime, $status, $notes) {
        $this->id = $id;
        $this->doctorId = $doctorId;
        $this->patientId = $patientId;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->status = $status;
        $this->notes = $notes;
    }

    public function getDoctorId() { return $this->doctorId; }
    public function setDoctorId($doctorId) { $this->doctorId = $doctorId; }

    public function getPatientId() { return $this->patientId; }
    public function setPatientId($patientId) { $this->patientId = $patientId; }

    public function getStartDateTime() { return $this->startDateTime; }
    public function setStartDateTime($startDateTime) { $this->startDateTime = $startDateTime; }

    public function getEndDateTime() { return $this->endDateTime; }
    public function setEndDateTime($endDateTime) { $this->endDateTime = $endDateTime; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getNotes() { return $this->notes; }
    public function setNotes($notes) { $this->notes = $notes; }
    public function __toString() {
        return "Appointment[id={$this->id}, doctorId={$this->doctorId}, patientId={$this->patientId}, status={$this->status}]";
    }
}
