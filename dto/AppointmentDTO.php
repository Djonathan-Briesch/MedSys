<?php

class AppointmentDTO
{
    private $doctor;
    private $patient;
    private $startDateTime;
    private $endDateTime;
    private $status;
    private $createdBy;
    private $editedBy;
    private $notes;

    public function __construct($doctor, $patient, $startDateTime, $endDateTime, $status, $createdBy, $editedBy, $notes) {
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->status = $status;
        $this->createdBy = $createdBy;
        $this->editedBy = $editedBy;
        $this->notes = $notes;
    }

    public function getDoctor() { return $this->doctor; }
    public function setDoctor($doctor) { $this->doctor = $doctor; }

    public function getPatient() { return $this->patient; }
    public function setPatient($patient) { $this->patient = $patient; }

    public function getStartDateTime() { return $this->startDateTime; }
    public function setStartDateTime($startDateTime) { $this->startDateTime = $startDateTime; }

    public function getEndDateTime() { return $this->endDateTime; }
    public function setEndDateTime($endDateTime) { $this->endDateTime = $endDateTime; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getCreatedBy() { return $this->createdBy; }
    public function setCreatedBy($createdBy) { $this->createdBy = $createdBy; }

    public function getEditedBy() { return $this->editedBy; }
    public function setEditedBy($editedBy) { $this->editedBy = $editedBy; }

    public function getNotes() { return $this->notes; }
    public function setNotes($notes) { $this->notes = $notes; }

    public function __toString() {
        return "AppointmentDTO[doctor={$this->doctor}, patient={$this->patient}, status={$this->status}]";
    }
}