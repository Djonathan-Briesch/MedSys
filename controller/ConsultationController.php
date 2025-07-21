<?php
require_once '../service/ConsultationService.php';
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
            $result = getConsultationById($_GET['id']);
        } else {
            $filters = [
                'appointmentId' => $_GET['appointmentId'] ?? null,
                'status' => $_GET['status'] ?? null
            ];
            $limit = $_GET['limit'] ?? null;
            $offset = $_GET['offset'] ?? null;
            $result = filterConsultations($filters, $limit, $offset);
        }
        break;

    case 'POST':
        $data = [
            'appointmentId' => $_POST['appointmentId'] ?? null,
            'startDateTime' => $_POST['startDateTime'] ?? null,
            'endDateTime' => $_POST['endDateTime'] ?? null,
            'status' => $_POST['status'] ?? 'SCHEDULED',
            'medicalNotes' => $_POST['medicalNotes'] ?? null
        ];
        $result = createConsultation($data);
        break;

    case 'PATCH':
        parse_str(file_get_contents("php://input"), $input);
        $result = updateConsultation($input);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $result = deleteConsultation($input['id'] ?? null);
        break;

    default:
        output("Invalid method", 400);
        exit;
}

output($result['data'], $result['status']);
