<?php
require_once '../util/database.php';
require_once '../dto/PatientDTO.php';
require_once '../dto/DoctorDTO.php';
require_once '../repository/DoctorAvailabilityRepository.php';

function insertUser($data)
{
    $pdo = getConnection();
    $sql = "INSERT INTO User (name, email, birthDate, cpf, password, role) VALUES (:name, :email, :birthDate, :cpf, :password, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':birthDate', $data['birthDate']);
    $stmt->bindParam(':password', $data['password']);
    $stmt->bindParam(':cpf', $data['cpf']);
    $stmt->bindParam(':role', $data['role']);
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function insertPatient($userId, $healthPlan)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Patient (userId, healthPlan) VALUES (:userId, :healthPlan)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':userId' => $userId,
        ':healthPlan' => $healthPlan
    ]);
}

function insertDoctor($userId, $specialty)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Doctor (userId, specialty) VALUES (:userId, :specialty)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':userId' => $userId,
        ':specialty' => $specialty
    ]);
}

function findUserById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM User WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user)
        return null;

    switch ($user['role']) {
        case 'PATIENT':
            $stmt = $pdo->prepare("SELECT healthPlan FROM Patient WHERE userId = :id");
            $stmt->execute([':id' => $user['id']]);
            $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
            return new PatientDTO(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['birthDate'],
                $user['cpf'],
                $patientData['healthPlan'] ?? null
            );

        case 'DOCTOR':
            $stmt = $pdo->prepare("SELECT specialty FROM Doctor WHERE userId = :id");
            $stmt->execute([':id' => $user['id']]);
            $doctorData = $stmt->fetch(PDO::FETCH_ASSOC);

            $availability = findDoctorAvailabilityByDoctorId($user['id']);

            return new DoctorDTO(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['birthDate'],
                $user['cpf'],
                $doctorData['specialty'] ?? null,
                $availability
            );

        default:
            return $user;
    }
}

function loginUser($cpf, $password)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM User WHERE cpf = :cpf");
    $stmt->execute([':cpf' => $cpf]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = null;

    if (!$userData) {
        return ['data' => 'Invalid email or password', 'status' => 401];
    }

    if ($userData['password'] !== $password) {
        return ['data' => 'Invalid email or password', 'status' => 401];
    }

    switch ($userData['role']) {
        case 'PATIENT':
            $stmt = $pdo->prepare("SELECT healthPlan FROM Patient WHERE userId = :id");
            $stmt->execute([':id' => $userData['id']]);
            $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new PatientDTO(
                $userData['id'],
                $userData['name'],
                $userData['email'],
                $userData['birthDate'],
                $userData['cpf'],
                $patientData['healthPlan'] ?? null
            );
            break;

        case 'DOCTOR':
            $stmt = $pdo->prepare("SELECT specialty FROM Doctor WHERE userId = :id");
            $stmt->execute([':id' => $userData['id']]);
            $doctorData = $stmt->fetch(PDO::FETCH_ASSOC);

            $availability = findDoctorAvailabilityByDoctorId($userData['id']);

            $user = new DoctorDTO(
                $userData['id'],
                $userData['name'],
                $userData['email'],
                $userData['birthDate'],
                $userData['cpf'],
                $doctorData['specialty'] ?? null,
                $availability
            );
            break;

        default:
            $user = $userData;
    }

    return $user;
}

function findAllUsers()
{
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM User");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $detailedUsers = [];

    foreach ($users as $user) {
        switch ($user['role']) {
            case 'PATIENT':
                $stmt = $pdo->prepare("SELECT healthPlan FROM Patient WHERE userId = :id");
                $stmt->execute([':id' => $user['id']]);
                $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
                $detailedUsers[] = new PatientDTO(
                    $user['id'],
                    $user['name'],
                    $user['email'],
                    $user['birthDate'],
                    $user['cpf'],
                    $patientData['healthPlan'] ?? null
                );
                break;

            case 'DOCTOR':
                $stmt = $pdo->prepare("SELECT specialty FROM Doctor WHERE userId = :id");
                $stmt->execute([':id' => $user['id']]);
                $doctorData = $stmt->fetch(PDO::FETCH_ASSOC);

                $availability = findDoctorAvailabilityByDoctorId($user['id']);

                $detailedUsers[] = new DoctorDTO(
                    $user['id'],
                    $user['name'],
                    $user['email'],
                    $user['birthDate'],
                    $user['cpf'],
                    $doctorData['specialty'] ?? null,
                    $availability
                );
                break;

            default:
                $detailedUsers[] = $user;
        }
    }

    return $detailedUsers;
}

function findAllDoctors()
{
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM User WHERE role = 'DOCTOR'");
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $detailedDoctors = [];

    $specialtyStmt = $pdo->prepare("SELECT specialty FROM Doctor WHERE userId = :id");

    foreach ($doctors as $doctor) {
        $specialtyStmt->execute([':id' => $doctor['id']]);
        $doctorData = $specialtyStmt->fetch(PDO::FETCH_ASSOC);

        $availability = findDoctorAvailabilityByDoctorId($doctor['id']);

        $detailedDoctors[] = new DoctorDTO(
            $doctor['id'],
            $doctor['name'],
            $doctor['email'],
            $doctor['birthDate'],
            $doctor['cpf'],
            $doctorData['specialty'] ?? null,
            $availability
        );
    }

    return $detailedDoctors;
}

function findDoctorsByName($name)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM User WHERE role = 'DOCTOR' AND name LIKE :name");
    $stmt->execute([':name' => "%$name%"]);
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $detailedDoctors = [];

    $specialtyStmt = $pdo->prepare("SELECT specialty FROM Doctor WHERE userId = :id");

    foreach ($doctors as $doctor) {
        $specialtyStmt->execute([':id' => $doctor['id']]);
        $doctorData = $specialtyStmt->fetch(PDO::FETCH_ASSOC);

        $availability = findDoctorAvailabilityByDoctorId($doctor['id']);

        $detailedDoctors[] = new DoctorDTO(
            $doctor['id'],
            $doctor['name'],
            $doctor['email'],
            $doctor['birthDate'],
            $doctor['cpf'],
            $doctorData['specialty'] ?? null,
            $availability
        );
    }

    return $detailedDoctors;
}

function findPatientByUserId($userId)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Patient WHERE userId = :userId");
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserById($data)
{
    $pdo = getConnection();
    $sql = "UPDATE User SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':id' => $data['id']
    ]);
}

function deleteUserById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM User WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
