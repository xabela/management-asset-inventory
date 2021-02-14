<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->getConnection();

$userlog = new User($db);

$data = json_decode(file_get_contents('php://input'));

$token = $data->token;
echo json_encode(array("message" => $userlog->cek_token($token)));
return;

if($userlog->cek_token($token)) {
    http_response_code(201); 
    echo json_encode(array("message => token ada"));
}

else {
    http_response_code(404);
    echo json_encode(array("message" => "token ga ada"));

}
?>