<?php
require_once '../util/database.php';

function insertConsultation($data) {
    $pdo = getConnection();
    $sql = "INSERT INTO Consultation (appointmentId, startDateTime, endDateTime, status, medicalNotes)
            VALUES (:appointmentId, :startDateTime, :endDateTime, :status, :medicalNotes)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':appointmentId' => $data['appointmentId'],
        ':startDateTime' => $data['startDateTime'],
        ':endDateTime' => $data['endDateTime'],
        ':status' => $data['status'],
        ':medicalNotes' => $data['medicalNotes']
    ]);
    return $success ? $pdo->lastInsertId() : false;
}

function findConsultationById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Consultation WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findConsultations($filters = [], $limit = null, $offset = null) {
    $pdo = getConnection();
    $sql = "SELECT * FROM Consultation WHERE 1=1";
    $params = [];

    if (!empty($filters['appointmentId'])) {
        $sql .= " AND appointmentId = :appointmentId";
        $params[':appointmentId'] = $filters['appointmentId'];
    }
    if (!empty($filters['status'])) {
        $sql .= " AND status = :status";
        $params[':status'] = $filters['status'];
    }

    if ($limit !== null) {
        $sql .= " LIMIT :limit";
        $params[':limit'] = (int)$limit;
    }
    if ($offset !== null) {
        $sql .= " OFFSET :offset";
        $params[':offset'] = (int)$offset;
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $val, $type);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateConsultationById($data) {
    $pdo = getConnection();
    $sql = "UPDATE Consultation SET 
                appointmentId = :appointmentId,
                startDateTime = :startDateTime,
                endDateTime = :endDateTime,
                status = :status,
                medicalNotes = :medicalNotes
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':appointmentId' => $data['appointmentId'],
        ':startDateTime' => $data['startDateTime'],
        ':endDateTime' => $data['endDateTime'],
        ':status' => $data['status'],
        ':medicalNotes' => $data['medicalNotes'],
        ':id' => $data['id']
    ]);
}

function deleteConsultationById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM Consultation WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
