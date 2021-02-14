<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input")); 
if (
    !empty($data->email)
) {
    $user->email = $data->email;
    echo json_encode(['message' => $user->create()]);
    return;
    if($user->create()) {
        http_response_code(201); 
        echo json_encode(array("message => user was created"));
    }

    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user."));

    }
}
else {
    http_response_code(400); 
    echo json_encode(array("message" => "Unable create user. Data is incomplete"));
}
?>