<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/lokasi.php';

$database = new Database();
$db = $database->getConnection();

$lokasi = new Lokasi($db);

$data = json_decode(file_get_contents("php://input")); 
if (
    !empty($data->lokasi)
) {
    $lokasi->lokasi = $data->lokasi;
    $lokasi->alamat = $data->alamat;

    if($lokasi->create()) {
        http_response_code(201); 
        echo json_encode(array("message => lokasi was created"));
    }

    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create lokasi."));

    }
}
else {
    http_response_code(400); 
    echo json_encode(array("message" => "Unable create lokasi. Data is incomplete"));
}
?>