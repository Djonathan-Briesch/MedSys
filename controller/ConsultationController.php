<?php
require_once '../service/ConsultationService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

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
