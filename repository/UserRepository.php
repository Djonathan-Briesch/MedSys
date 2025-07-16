<?php
require_once '../util/database.php';

function insertUser($data) {
    $pdo = getConnection();
    $sql = "INSERT INTO User (name, email, birthDate, cpf, password, role) VALUES (:name, :email, :birthDate, '', :password, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':birthDate', $data['birthDate']);
    $stmt->bindParam(':password', $data['password']);
    $stmt->bindParam(':role', $data['role']);
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function insertPatient($userId, $healthPlan) {
    $pdo = getConnection();
    $sql = "INSERT INTO Patient (userId, healthPlan) VALUES (:userId, :healthPlan)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':userId' => $userId,
        ':healthPlan' => $healthPlan
    ]);
}

function insertDoctor($userId, $specialty) {
    $pdo = getConnection();
    $sql = "INSERT INTO Doctor (userId, specialty) VALUES (:userId, :specialty)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':userId' => $userId,
        ':specialty' => $specialty
    ]);
}

function findUserById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM User WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findAllUsers() {
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM User");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUserById($data) {
    $pdo = getConnection();
    $sql = "UPDATE User SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':id' => $data['id']
    ]);
}

function deleteUserById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM User WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
