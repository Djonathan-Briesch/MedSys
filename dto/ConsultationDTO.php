<?php

class ConsultationDTO implements JsonSerializable
{
    private $appointment;
    private $startDateTime;
    private $endDateTime;
    private $status;
    private $medicalNotes;

    public function __construct($appointment, $startDateTime, $endDateTime, $status, $medicalNotes) {
        $this->appointment = $appointment;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->status = $status;
        $this->medicalNotes = $medicalNotes;
    }

    public function getAppointment() { return $this->appointment; }
    public function setAppointment($appointment) { $this->appointment = $appointment; }

    public function getStartDateTime() { return $this->startDateTime; }
    public function setStartDateTime($startDateTime) { $this->startDateTime = $startDateTime; }

    public function getEndDateTime() { return $this->endDateTime; }
    public function setEndDateTime($endDateTime) { $this->endDateTime = $endDateTime; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getMedicalNotes() { return $this->medicalNotes; }
    public function setMedicalNotes($medicalNotes) { $this->medicalNotes = $medicalNotes; }

    public function __toString() {
        return "ConsultationDTO[appointment={$this->appointment}, status={$this->status}]";
    }

    public function jsonSerialize() {
        return [
            'appointment' => $this->appointment instanceof JsonSerializable
                ? $this->appointment->jsonSerialize()
                : $this->appointment,
            'startDateTime' => $this->startDateTime,
            'endDateTime' => $this->endDateTime,
            'status' => $this->status,
            'medicalNotes' => $this->medicalNotes,
        ];
    }
}
