<?php
require_once '../util/database.php';
require_once '../dto/ConsultationDTO.php';
require_once '../repository/AppointmentRepository.php';
function insertConsultation($data)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Consultation (appointmentId, startDateTime, endDateTime, status, medicalNotes)
            VALUES (:appointmentId, :startDateTime, :endDateTime, :status, :medicalNotes)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':appointmentId', $data['appointmentId']);
    $stmt->bindParam(':startDateTime', $data['startDateTime']);
    $stmt->bindParam(':endDateTime', $data['endDateTime']);
    $stmt->bindParam(':status', $data['status']);
    $stmt->bindParam(':medicalNotes', $data['medicalNotes']);
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function findConsultationById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Consultation WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $consultation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$consultation) {
        return null;
    }

    $appointmentDTO = findAppointmentById($consultation['appointmentId']);

    return new ConsultationDTO(
        $appointmentDTO,
        $consultation['startDateTime'],
        $consultation['endDateTime'],
        $consultation['status'],
        $consultation['medicalNotes']
    );
}

function findConsultations($filters = [], $limit = null, $offset = null)
{
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
    if (!empty($filters['userId'])) {
        $sql .= " AND appointmentId IN (SELECT id FROM Appointment WHERE patientId = :userId)";
        $params[':userId'] = $filters['userId'];
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
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($rows as $consultation) {
        $appointmentDTO = findAppointmentById($consultation['appointmentId']);
        $result[] = new ConsultationDTO(
            $appointmentDTO,
            $consultation['startDateTime'],
            $consultation['endDateTime'],
            $consultation['status'],
            $consultation['medicalNotes']
        );
    }

    return $result;
}


function updateConsultationById($data)
{
    $oldAppointment = findConsultationById($data['id']);
    if (!$oldAppointment) {
        return false;
    }

    $appointmentId = $data['appointmentId'] ?? $oldAppointment->getAppointment()->getId();
    $startDateTime = $data['startDateTime'] ?? $oldAppointment->getStartDateTime();
    $endDateTime = $data['endDateTime'] ?? $oldAppointment->getEndDateTime();
    $status = $data['status'] ?? $oldAppointment->getStatus();
    $medicalNotes = $data['medicalNotes'] ?? $oldAppointment->getMedicalNotes();

    $pdo = getConnection();
    $sql = "UPDATE Consultation SET 
                appointmentId = :appointmentId,
                startDateTime = :startDateTime,
                endDateTime = :endDateTime,
                status = :status,
                medicalNotes = :medicalNotes
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':appointmentId', $appointmentId);
    $stmt->bindParam(':startDateTime', $startDateTime);
    $stmt->bindParam(':endDateTime', $endDateTime);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':medicalNotes', $medicalNotes);
    $stmt->bindParam(':id', $data['id']);
    return $stmt->execute();
}

function deleteConsultationById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM Consultation WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
