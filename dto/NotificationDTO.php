<?php

class NotificationDTO
{
    private $user;
    private $title;
    private $description;
    private $dateTime;
    private $read;

    public function __construct($user, $title, $description, $dateTime, $read = false) {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
        $this->dateTime = $dateTime;
        $this->read = $read;
    }

    public function getUser() { return $this->user; }
    public function setUser($user) { $this->user = $user; }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getDateTime() { return $this->dateTime; }
    public function setDateTime($dateTime) { $this->dateTime = $dateTime; }

    public function isRead() { return $this->read; }
    public function setRead($read) { $this->read = $read; }

    public function __toString() {
        return "NotificationDTO[title={$this->title}, read={$this->read}]";
    }
}