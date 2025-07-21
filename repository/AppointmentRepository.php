<?php
require_once '../util/database.php';
require_once '../dto/AppointmentDTO.php';
require_once '../repository/UserRepository.php';

function insertAppointment($data)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Appointment (doctorId, patientId, startDateTime, endDateTime, status, createdBy, editedBy, notes) 
            VALUES (:doctorId, :patientId, :startDateTime, :endDateTime, :status, :createdBy, :editedBy, :notes)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':doctorId', $data['doctorId']);
    $stmt->bindParam(':patientId', $data['patientId']);
    $stmt->bindParam(':startDateTime', $data['startDateTime']);
    $stmt->bindParam(':endDateTime', $data['endDateTime']);
    $stmt->bindParam(':status', $data['status']);
    $stmt->bindParam(':createdBy', $data['createdBy']);
    $stmt->bindParam(':editedBy', $data['editedBy']);
    $stmt->bindParam(':notes', $data['notes']);
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function findAppointmentById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Appointment WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment)
        return null;

    $doctor = findUserById($appointment['doctorId']);
    $patient = findUserById($appointment['patientId']);
    $createdBy = !empty($appointment['createdBy']) ? findUserById($appointment['createdBy']) : null;
    $editedBy = !empty($appointment['editedBy']) ? findUserById($appointment['editedBy']) : null;

    $doctorData = is_object($doctor) ? [
        'id' => $doctor->getId() ?? null,
        'name' => $doctor->getName() ?? null,
    ] : $doctor;

    $patientData = is_object($patient) ? [
        'id' => $patient->getId() ?? null,
        'name' => $patient->getName() ?? null,
    ] : $patient;

    $createdByData = is_object($createdBy) ? [
        'id' => $createdBy->getId() ?? null,
        'name' => $createdBy->getName() ?? null,
    ] : $createdBy;

    $editedByData = is_object($editedBy) ? [
        'id' => $editedBy->getId() ?? null,
        'name' => $editedBy->getName() ?? null,
    ] : $editedBy;

    return new AppointmentDTO(
        $doctorData,
        $patientData,
        $appointment['startDateTime'],
        $appointment['endDateTime'],
        $appointment['status'],
        $createdByData,
        $editedByData,
        $appointment['notes']
    );
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
        $stmt->bindValue($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $result = [];

    foreach ($rows as $appointment) {
        $doctor = findUserById($appointment['doctorId']);
        $patient = findUserById($appointment['patientId']);
        $createdBy = !empty($appointment['createdBy']) ? findUserById($appointment['createdBy']) : null;
        $editedBy = !empty($appointment['editedBy']) ? findUserById($appointment['editedBy']) : null;
        $doctorData = is_object($doctor) ? [
            'id' => $doctor->getId() ?? null,
            'name' => $doctor->getName() ?? null,
        ] : $doctor;

        $patientData = is_object($patient) ? [
            'id' => $patient->getId() ?? null,
            'name' => $patient->getName() ?? null,
        ] : $patient;

        $createdByData = is_object($createdBy) ? [
            'id' => $createdBy->getId() ?? null,
            'name' => $createdBy->getName() ?? null,
        ] : $createdBy;

        $editedByData = is_object($editedBy) ? [
            'id' => $editedBy->getId() ?? null,
            'name' => $editedBy->getName() ?? null,
        ] : $editedBy;

        $result[] = [
            'id' => $appointment['id'], 
            'doctor' => $doctorData,
            'patient' => $patientData,
            'startDateTime' => $appointment['startDateTime'],
            'endDateTime' => $appointment['endDateTime'],
            'status' => $appointment['status'],
            'createdBy' => $createdByData,
            'editedBy' => $editedByData,
            'notes' => $appointment['notes']
        ];
    }

    return $result;
}

function updateAppointmentById($data)
{
    $pdo = getConnection();

    $stmt = $pdo->prepare("SELECT * FROM Appointment WHERE id = :id");
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();
    $oldAppointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oldAppointment) {
        return false;
    }

    $doctorId = isset($data['doctorId']) && $data['doctorId'] !== null ? $data['doctorId'] : $oldAppointment['doctorId'];
    $patientId = isset($data['patientId']) && $data['patientId'] !== null ? $data['patientId'] : $oldAppointment['patientId'];
    $startDateTime = isset($data['startDateTime']) && $data['startDateTime'] !== null ? $data['startDateTime'] : $oldAppointment['startDateTime'];
    $endDateTime = isset($data['endDateTime']) && $data['endDateTime'] !== null ? $data['endDateTime'] : $oldAppointment['endDateTime'];
    $status = isset($data['status']) && $data['status'] !== null ? $data['status'] : $oldAppointment['status'];
    $createdBy = isset($data['createdBy']) && $data['createdBy'] !== null ? $data['createdBy'] : $oldAppointment['createdBy'];
    $editedBy = isset($data['editedBy']) && $data['editedBy'] !== null ? $data['editedBy'] : $oldAppointment['editedBy'];
    $notes = isset($data['notes']) && $data['notes'] !== null ? $data['notes'] : $oldAppointment['notes'];

    $sql = "UPDATE Appointment SET 
                doctorId = :doctorId, 
                patientId = :patientId,
                startDateTime = :startDateTime,
                endDateTime = :endDateTime,
                status = :status,
                createdBy = :createdBy,
                editedBy = :editedBy,
                notes = :notes
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':doctorId', $doctorId);
    $stmt->bindParam(':patientId', $patientId);
    $stmt->bindParam(':startDateTime', $startDateTime);
    $stmt->bindParam(':endDateTime', $endDateTime);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':createdBy', $createdBy);
    $stmt->bindParam(':editedBy', $editedBy);
    $stmt->bindParam(':notes', $notes);
    $stmt->bindParam(':id', $data['id']);

    return $stmt->execute();
}


function deleteAppointmentById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM Appointment WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
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

