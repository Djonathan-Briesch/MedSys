<?php

class DoctorAvailabilityDTO implements JsonSerializable
{
    private $id;
    private $weekDay;
    private $startTime;
    private $endTime;

    public function __construct($id, $weekDay, $startTime, $endTime) {
        $this->id = $id;
        $this->weekDay = $weekDay;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getId() { return $this->id; }
    public function getWeekDay() { return $this->weekDay; }
    public function getStartTime() { return $this->startTime; }
    public function getEndTime() { return $this->endTime; }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'weekDay' => $this->weekDay,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
        ];
    }
}
