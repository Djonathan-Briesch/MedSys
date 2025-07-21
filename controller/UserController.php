<?php
require_once '../service/UserService.php';
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
        $result = getUserById($_GET['id']);
    } else if (isset($_GET['doctorName'])) {
        $result = getDoctorsByName($_GET['doctorName']);
    } else if (isset($_GET['type']) && $_GET['type'] === 'DOCTOR') {
        $result = getAllDoctors();
    } else {
        $result = getAllUsers();
    }
    break;


    case 'POST':
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents("php://input"), true);
        } else {
            $data = $_POST;
        }

        if (isset($data['cpf']) && isset($data['password']) && !isset($data['name'])) {
            $result = login($data['cpf'], $data['password']);
        } else {
            $user = [
                'name' => $data['name'] ?? null,
                'cpf' => $data['cpf'] ?? null,
                'email' => $data['email'] ?? null,
                'birthDate' => $data['bd'] ?? null,
                'password' => $data['pass'] ?? null,
                'role' => $data['type'] ?? null,
                'healthPlan' => $data['healthPlan'] ?? null,
                'specialty' => $data['specialty'] ?? null
            ];
            error_log("User data: " . print_r($user, true));
            error_log("Data: " . print_r($data, true));
            $result = createUser($user);
            error_log("Create user result: " . print_r($result, true));
        }
        break;


    case 'PATCH':
        parse_str(file_get_contents("php://input"), $input);
        $result = updateUser($input);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $result = deleteUser($input['id'] ?? null);
        break;

    default:
        output("Invalid request method", 400);
        exit;
}

output($result['data'], $result['status']);
