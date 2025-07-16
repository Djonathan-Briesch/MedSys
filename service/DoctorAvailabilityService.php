<?php
require_once '../repository/DoctorAvailabilityRepository.php';
require_once '../entity/DoctorAvailability.php';

function createDoctorAvailability($data) {
    foreach (['doctorId', 'weekDay', 'startTime', 'endTime'] as $field) {
        if (empty($data[$field])) {
            return ['data' => "$field is required", 'status' => 400];
        }
    }

    $id = insertDoctorAvailability($data);
    if ($id === false) {
        return ['data' => 'Failed to create doctor availability', 'status' => 500];
    }

    return ['data' => ['id' => $id], 'status' => 201];
}

function getDoctorAvailabilityById($id) {
    $row = findDoctorAvailabilityById($id);
    if (!$row) {
        return ['data' => 'Doctor availability not found', 'status' => 404];
    }

    $availability = new DoctorAvailability(
        $row['id'],
        $row['doctorId'],
        $row['weekDay'],
        $row['startTime'],
        $row['endTime']
    );

    return ['data' => $availability, 'status' => 200];
}

function getAllDoctorAvailabilities() {
    $rows = findAllDoctorAvailabilities();
    return ['data' => $rows, 'status' => 200];
}

function updateDoctorAvailability($data) {
    if (empty($data['id'])) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = updateDoctorAvailabilityById($data);
    return ['data' => $success ? 'Updated' : 'Not updated', 'status' => $success ? 200 : 500];
}

function deleteDoctorAvailability($id) {
    if (empty($id)) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = deleteDoctorAvailabilityById($id);
    return ['data' => $success ? 'Deleted' : 'Not found', 'status' => $success ? 200 : 404];
}
