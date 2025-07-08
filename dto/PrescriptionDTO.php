<?php

class PrescriptionDTO
{
    private $consultationId;
    private $medicineName;
    private $dosage;
    private $duration;

    public function __construct($consultationId, $medicineName, $dosage, $duration) {
        $this->consultationId = $consultationId;
        $this->medicineName = $medicineName;
        $this->dosage = $dosage;
        $this->duration = $duration;
    }

    public function getConsultationId() { return $this->consultationId; }
    public function setConsultationId($consultationId) { $this->consultationId = $consultationId; }

    public function getMedicineName() { return $this->medicineName; }
    public function setMedicineName($medicineName) { $this->medicineName = $medicineName; }

    public function getDosage() { return $this->dosage; }
    public function setDosage($dosage) { $this->dosage = $dosage; }

    public function getDuration() { return $this->duration; }
    public function setDuration($duration) { $this->duration = $duration; }

    public function __toString() {
        return "PrescriptionDTO[medicineName={$this->medicineName}, dosage={$this->dosage}]";
    }
}