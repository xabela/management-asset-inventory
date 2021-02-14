<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/kategori.php';

$database = new Database();
$db = $database->getConnection();

$kategori = new Kategori($db);

$data = json_decode(file_get_contents("php://input")); 
if (
    !empty($data->kategori)
) {
    $kategori->kategori = $data->kategori;

    if($kategori->create()) {
        http_response_code(201); 
        echo json_encode(array("message => kategori was created"));
    }

    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create kategori."));

    }
}
else {
    http_response_code(400); 
    echo json_encode(array("message" => "Unable create kategori. Data is incomplete"));
}
?>