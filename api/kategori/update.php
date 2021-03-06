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

$kategori->id_kategori = $data->id_kategori;

$kategori->kategori = $data->kategori;

if($kategori->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "kategori update successfully"));
}
else {
    http_response_code(503); 
    echo json_encode(array("message" => "unable update kategori"));
}

?>