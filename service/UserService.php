<?php
require_once '../repository/UserRepository.php';

function createUser($data) {
    if (!$data['name'] || !$data['email'] || !$data['birthDate'] || !$data['password'] || !$data['role']) {
        return ['data' => 'Missing required fields', 'status' => 400];
    }

    $userId = insertUser($data);
    if ($userId === false) {
        return ['data' => 'Failed to create user', 'status' => 500];
    }

    if ($data['role'] === 'PATIENT') {
        insertPatient($userId, $data['healthPlan'] ?? null);
    } elseif ($data['role'] === 'DOCTOR') {
        insertDoctor($userId, $data['specialty']);
    }

    return ['data' => ['id' => $userId], 'status' => 201];
}

function getUserById($id) {
    $user = findUserById($id);
    if ($user) {
        return ['data' => $user, 'status' => 200];
    }
    return ['data' => 'User not found', 'status' => 404];
}

function getAllUsers() {
    return ['data' => findAllUsers(), 'status' => 200];
}

function updateUser($data) {
    if (!isset($data['id'])) {
        return ['data' => 'ID required', 'status' => 400];
    }
    $updated = updateUserById($data);
    return ['data' => $updated ? 'Updated' : 'Not updated', 'status' => $updated ? 200 : 404];
}

function deleteUser($id) {
    if (!$id) {
        return ['data' => 'ID required', 'status' => 400];
    }
    $deleted = deleteUserById($id);
    return ['data' => $deleted ? 'Deleted' : 'Not found', 'status' => $deleted ? 200 : 404];
}
