<?php

function output($data, int $code)
{
    header('Content-Type: application/json');
    http_response_code($code);
    echo json_encode($data);
    exit;

}

?>