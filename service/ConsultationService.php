<?php
require_once '../repository/consultation_repository.php';
require_once '../entity/Consultation.php';

function createConsultation($data) {
    foreach (['appointmentId', 'startDateTime', 'endDateTime'] as $field) {
        if (empty($data[$field])) {
            return ['data' => "$field is required", 'status' => 400];
        }
    }

    $id = insertConsultation($data);
    if ($id === false) {
        return ['data' => 'Failed to create consultation', 'status' => 500];
    }

    return ['data' => ['id' => $id], 'status' => 201];
}

function getConsultationById($id) {
    $row = findConsultationById($id);
    if (!$row) {
        return ['data' => 'Consultation not found', 'status' => 404];
    }

    $consultation = new Consultation(
        $row['id'],
        $row['appointmentId'],
        $row['startDateTime'],
        $row['endDateTime'],
        $row['status'],
        $row['medicalNotes']
    );

    return ['data' => $consultation, 'status' => 200];
}

function filterConsultations($filters = [], $limit = null, $offset = null) {
    $rows = findConsultations($filters, $limit, $offset);
    return ['data' => $rows, 'status' => 200];
}

function updateConsultation($data) {
    if (empty($data['id'])) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = updateConsultationById($data);
    return ['data' => $success ? 'Updated' : 'Not updated', 'status' => $success ? 200 : 500];
}

function deleteConsultation($id) {
    if (empty($id)) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = deleteConsultationById($id);
    return ['data' => $success ? 'Deleted' : 'Not found', 'status' => $success ? 200 : 404];
}
