<?php
require_once '../repository/AppointmentRepository.php';
require_once '../entity/Appointment.php';

function createAppointment($data)
{
    foreach (['doctorId', 'patientId', 'startDateTime', 'endDateTime'] as $field) {
        if (empty($data[$field])) {
            return ['data' => "$field is required", 'status' => 400];
        }
    }

    if (hasConflict($data['doctorId'], $data['startDateTime'], $data['endDateTime'])) {
        return ['data' => 'Scheduling conflict for this time slot', 'status' => 409];
    }

    $id = insertAppointment($data);
    return $id ? ['data' => ['id' => $id], 'status' => 201] : ['data' => 'Failed to create', 'status' => 500];
}


function getAppointmentById($id)
{
    $row = findAppointmentById($id);
    if (!$row) {
        return ['data' => 'Appointment not found', 'status' => 404];
    }

    $appointment = new Appointment(
        $row['id'],
        $row['doctorId'],
        $row['patientId'],
        $row['startDateTime'],
        $row['endDateTime'],
        $row['status'],
        $row['notes']
    );

    return ['data' => $appointment, 'status' => 200];
}

function getAllAppointments()
{
    $rows = findAllAppointments();
    return ['data' => $rows, 'status' => 200];
}

function updateAppointment($data)
{
    if (empty($data['id'])) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    if (hasConflict($data['doctorId'], $data['startDateTime'], $data['endDateTime'], $data['id'])) {
        return ['data' => 'Conflict with another appointment', 'status' => 409];
    }

    $success = updateAppointmentById($data);
    return ['data' => $success ? 'Updated' : 'Not updated', 'status' => $success ? 200 : 500];
}

function deleteAppointment($id)
{
    if (empty($id)) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = deleteAppointmentById($id);
    return ['data' => $success ? 'Deleted' : 'Not found', 'status' => $success ? 200 : 404];
}

function filterAppointments($filters = [], $limit = null, $offset = null)
{
    $appointments = findAppointments($filters, $limit, $offset);
    return ['data' => $appointments, 'status' => 200];
}
