<?php
require_once '../util/database.php';

function insertDoctorAvailability($data) {
    $pdo = getConnection();
    $sql = "INSERT INTO DisponibilidadeMedico (idMedico, diaSemana, horaInicio, horaFim)
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

function findDoctorAvailabilityById($id) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM DisponibilidadeMedico WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findAllDoctorAvailabilities() {
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM DisponibilidadeMedico ORDER BY diaSemana, horaInicio");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateDoctorAvailabilityById($data) {
    $pdo = getConnection();
    $sql = "UPDATE DisponibilidadeMedico SET
                idMedico = :doctorId,
                diaSemana = :weekDay,
                horaInicio = :startTime,
                horaFim = :endTime
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
    $stmt = $pdo->prepare("DELETE FROM DisponibilidadeMedico WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
