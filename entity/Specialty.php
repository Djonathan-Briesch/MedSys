<?php

require_once 'BaseEntity.php';

class Specialty extends BaseEntity {
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function __toString() {
        return "Specialty[id={$this->id}, name={$this->name}]";
    }
}
