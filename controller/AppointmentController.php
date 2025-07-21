<?php
require_once '../service/AppointmentService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

switch ($request) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = getAppointmentById($_GET['id']);
        } else {
            $filters = [
                'doctorId' => $_GET['doctorId'] ?? null,
                'patientId' => $_GET['patientId'] ?? null,
                'status' => $_GET['status'] ?? null
            ];
            $limit = $_GET['limit'] ?? 10;
            $offset = $_GET['offset'] ?? 0;
            $result = filterAppointments($filters, $limit, $offset);
        }
        break;

    case 'POST':
        $data = [
            'doctorId' => $_POST['doctorId'] ?? null,
            'patientId' => $_POST['patientId'] ?? null,
            'startDateTime' => $_POST['startDateTime'] ?? null,
            'endDateTime' => $_POST['endDateTime'] ?? null,
            'status' => $_POST['status'] ?? 'PENDING',
            'notes' => $_POST['notes'] ?? null
        ];
        $result = createAppointment($data);
        break;

    case 'PATCH':
        parse_str(file_get_contents("php://input"), $input);
        $result = updateAppointment($input);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $result = deleteAppointment($input['id'] ?? null);
        break;

    default:
        output("Invalid method", 400);
        exit;
}

output($result['data'], $result['status']);
