<?php
require_once '../util/output_json.php';

$request = $_SERVER['REQUEST_METHOD'];

$name = $_POST['name'];
$email = $_POST['email'];
$bd = $_POST['bd'];
$pass = $_POST['pass'];
$type = $_POST['type'];
$healthPlan = $_POST['healthPlan'];

switch ($request) {
    case 'GET':
        if (isset($_GET['id'])) {

        } else {

        }
        break;
    case 'POST':

        break;
    case 'PATCH':

        break;
    case 'DELETE':

        break;

    default:
        echo ("invalido");
        break;
}
output("sdkfjsdf", 200);