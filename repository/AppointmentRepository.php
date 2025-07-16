<?php
require_once '../util/database.php';

function insertAppointment($data)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Appointment (doctorId, patientId, startDateTime, endDateTime, status, notes) 
            VALUES (:doctorId, :patientId, :startDateTime, :endDateTime, :status, :notes)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':doctorId' => $data['doctorId'],
        ':patientId' => $data['patientId'],
        ':startDateTime' => $data['startDateTime'],
        ':endDateTime' => $data['endDateTime'],
        ':status' => $data['status'],
        ':notes' => $data['notes']
    ]);
    return $success ? $pdo->lastInsertId() : false;
}

function findAppointmentById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Appointment WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findAppointments($filters = [], $limit = null, $offset = null)
{
    $pdo = getConnection();
    $sql = "SELECT * FROM Appointment WHERE 1=1";
    $params = [];

    if (!empty($filters['doctorId'])) {
        $sql .= " AND doctorId = :doctorId";
        $params[':doctorId'] = $filters['doctorId'];
    }
    if (!empty($filters['patientId'])) {
        $sql .= " AND patientId = :patientId";
        $params[':patientId'] = $filters['patientId'];
    }
    if (!empty($filters['status'])) {
        $sql .= " AND status = :status";
        $params[':status'] = $filters['status'];
    }

    if ($limit !== null) {
        $sql .= " LIMIT :limit";
        $params[':limit'] = (int) $limit;
    }
    if ($offset !== null) {
        $sql .= " OFFSET :offset";
        $params[':offset'] = (int) $offset;
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $val, $type);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function findAllAppointments()
{
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM Appointment");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateAppointmentById($data)
{
    $pdo = getConnection();
    $sql = "UPDATE Appointment SET 
                doctorId = :doctorId, 
                patientId = :patientId,
                startDateTime = :startDateTime,
                endDateTime = :endDateTime,
                status = :status,
                notes = :notes
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':doctorId' => $data['doctorId'],
        ':patientId' => $data['patientId'],
        ':startDateTime' => $data['startDateTime'],
        ':endDateTime' => $data['endDateTime'],
        ':status' => $data['status'],
        ':notes' => $data['notes'],
        ':id' => $data['id']
    ]);
}

function deleteAppointmentById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM Appointment WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

function hasConflict($doctorId, $startDateTime, $endDateTime, $ignoreId = null)
{
    $pdo = getConnection();
    $sql = "SELECT COUNT(*) FROM Appointment 
            WHERE doctorId = :doctorId 
              AND (
                  (startDateTime < :endDateTime AND endDateTime > :startDateTime)
              )";

    if ($ignoreId) {
        $sql .= " AND id != :ignoreId";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':doctorId', $doctorId);
    $stmt->bindValue(':startDateTime', $startDateTime);
    $stmt->bindValue(':endDateTime', $endDateTime);

    if ($ignoreId) {
        $stmt->bindValue(':ignoreId', $ignoreId);
    }

    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

