<?php

require_once 'BaseEntity.php';

class Consultation extends BaseEntity {
    private $appointmentId;
    private $startDateTime;
    private $endDateTime;
    private $status;
    private $medicalNotes;

    public function __construct($id, $appointmentId, $startDateTime, $endDateTime, $status, $medicalNotes) {
        $this->id = $id;
        $this->appointmentId = $appointmentId;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->status = $status;
        $this->medicalNotes = $medicalNotes;
    }

    public function getAppointmentId() { return $this->appointmentId; }
    public function setAppointmentId($appointmentId) { $this->appointmentId = $appointmentId; }

    public function getStartDateTime() { return $this->startDateTime; }
    public function setStartDateTime($startDateTime) { $this->startDateTime = $startDateTime; }

    public function getEndDateTime() { return $this->endDateTime; }
    public function setEndDateTime($endDateTime) { $this->endDateTime = $endDateTime; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getMedicalNotes() { return $this->medicalNotes; }
    public function setMedicalNotes($medicalNotes) { $this->medicalNotes = $medicalNotes; }

    public function __toString() {
        return "Consultation[id={$this->id}, appointmentId={$this->appointmentId}, status={$this->status}]";
    }
}
