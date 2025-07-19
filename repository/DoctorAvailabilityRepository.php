<?php
require_once '../util/database.php';
require_once '../dto/DoctorAvailability.php';

function insertDoctorAvailability($data) {
    $pdo = getConnection();
    $sql = "INSERT INTO doctoravailability (doctorId, weekday, startTime, endTime)
            VALUES (:doctorId, :weekDay, :startTime, :endTime)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':doctorId' => $data['doctorId'],
        ':weekDay' => $data['weekDay'],
        ':startTime' => $data['startTime'],
        ':endTime' => $data['endTime']
    ]);
    return $success ? $pdo->lastInsertId() : false;
}

function findDoctorAvailabilityByDoctorId($doctorId) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM doctoravailability WHERE doctorId = :doctorId");
    $stmt->execute([':doctorId' => $doctorId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $availabilities = [];
    foreach ($rows as $row) {
        $availabilities[] = new DoctorAvailabilityDTO(
            $row['id'],
            $row['weekday'],
            $row['startTime'],
            $row['endTime']
        );
    }
    return $availabilities;
}

function findAllDoctorAvailabilities() {
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM doctoravailability ORDER BY weekday, startTime");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateDoctorAvailabilityById($data) {
    $pdo = getConnection();
    $sql = "UPDATE doctoravailability SET
                doctorId = :doctorId,
                weekday = :weekDay,
                startTime = :startTime,
                endTime = :endTime
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':doctorId' => $data['doctorId'],
        ':weekDay' => $data['weekDay'],
        ':startTime' => $data['startTime'],
        ':endTime' => $data['endTime'],
        ':id' => $data['id']
    ]);
}

function deleteDoctorAvailabilityById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM doctoravailability WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
