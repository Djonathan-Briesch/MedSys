<?php
require_once '../service/UserService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = getUserById($_GET['id']);
        } else {
            $result = getAllUsers();
        }
        break;

    case 'POST':
        $data = [
            'name' => $_POST['name'] ?? null,
            'email' => $_POST['email'] ?? null,
            'birthDate' => $_POST['bd'] ?? null,
            'password' => $_POST['pass'] ?? null,
            'role' => $_POST['type'] ?? null,
            'healthPlan' => $_POST['healthPlan'] ?? null,
            'specialty' => $_POST['specialty'] ?? null
        ];
        $result = createUser($data);
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
