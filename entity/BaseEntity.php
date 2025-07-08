<?php

abstract class BaseEntity {
    protected $id;
    protected $createdAt;
    protected $updatedAt;
    protected $deleted = false;
    protected $deletedAt;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }

    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }

    public function isDeleted() { return $this->deleted; }
    public function setDeleted($deleted) { $this->deleted = $deleted; }

    public function getDeletedAt() { return $this->deletedAt; }
    public function setDeletedAt($deletedAt) { $this->deletedAt = $deletedAt; }
}