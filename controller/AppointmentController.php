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
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        if (!$data) {
            error_log("Erro ao decodificar JSON: " . $rawData);
            http_response_code(400);
            echo json_encode(["error" => "Dados inválidos."]);
            exit;
        }

        error_log("Creating appointment with data: " . json_encode($data));
        $result = createAppointment($data);
        error_log("Appointment creation result: " . json_encode($result));
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
