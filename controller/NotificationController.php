<?php
require_once '../service/NotificationService.php';
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

switch ($request) {
    case 'GET':
    if (isset($_GET['id'])) {
        $result = getNotificationById($_GET['id']);
    } elseif (isset($_GET['userId'])) {
        $result = getNotificationsByUserId($_GET['userId']);
    } else {
        $result = getAllNotifications();
    }
    break;


    case 'POST':
        $data = [
            'userId' => $_POST['userId'] ?? null,
            'title' => $_POST['title'] ?? null,
            'description' => $_POST['description'] ?? null,
            'dateTime' => $_POST['dateTime'] ?? date('Y-m-d H:i:s'),
            'read' => isset($_POST['read']) ? filter_var($_POST['read'], FILTER_VALIDATE_BOOLEAN) : false,
        ];
        $result = createNotification($data);
        break;

    case 'PATCH':
        parse_str(file_get_contents("php://input"), $input);
        if (isset($input['id']) && isset($input['read']) && $input['read'] == true) {
            $result = markAsRead($input['id']);
        } else {
            $result = updateNotification($input);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $result = deleteNotification($input['id'] ?? null);
        break;

    default:
        output("Invalid method", 400);
        exit;
}

output($result['data'], $result['status']);
