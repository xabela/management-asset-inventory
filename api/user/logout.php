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
$userlog->token = $token;


$success = array (
    'status' => $userlog->hapus_token($token)
);

echo json_encode($success);
return;

?>