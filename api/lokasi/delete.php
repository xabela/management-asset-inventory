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

$lokasi->id_lokasi = $data->id_lokasi;

if($lokasi->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "lokasi deleted successfully"));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "unable delete lokasi"));
}
?>