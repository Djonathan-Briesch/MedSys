<?php
require_once '../service/DoctorAvailabilityService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = getDoctorAvailabilityById($_GET['id']);
        } else {
            $result = getAllDoctorAvailabilities();
        }
        break;

    case 'POST':
        $data = [
            'doctorId' => $_POST['doctorId'] ?? null,
            'weekDay' => $_POST['weekDay'] ?? null,
            'startTime' => $_POST['startTime'] ?? null,
            'endTime' => $_POST['endTime'] ?? null,
        ];
        $result = createDoctorAvailability($data);
        break;

    case 'PATCH':
        parse_str(file_get_contents("php://input"), $input);
        $result = updateDoctorAvailability($input);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $result = deleteDoctorAvailability($input['id'] ?? null);
        break;

    default:
        output("Invalid method", 400);
        exit;
}

output($result['data'], $result['status']);
