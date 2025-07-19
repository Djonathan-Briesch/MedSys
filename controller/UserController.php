<?php
require_once '../service/UserService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = getUserById($_GET['id']);
        } else if(isset($_GET['doctorName'])){
            $result = getDoctorsByName($_GET['doctorName']);
        }else{
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
            $result = createUser($user);
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
