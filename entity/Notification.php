<?php

require_once 'BaseEntity.php';

class Notification extends BaseEntity {
    private $userId;
    private $title;
    private $description;
    private $dateTime;
    private $read;

    public function __construct($id, $userId, $title, $description, $dateTime, $read) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->dateTime = $dateTime;
        $this->read = $read;
    }

    public function getUserId() { return $this->userId; }
    public function setUserId($userId) { $this->userId = $userId; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getDateTime() { return $this->dateTime; }
    public function setDateTime($dateTime) { $this->dateTime = $dateTime; }

    public function isRead() { return $this->read; }
    public function setRead($read) { $this->read = $read; }

    public function __toString() {
        return "Notification[id={$this->id}, title={$this->title}, read={$this->read}]";
    }
}
