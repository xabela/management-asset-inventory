<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/lokasi.php';

$database = new Database();
$db = $database->getConnection();

$lokasi = new Lokasi($db);

$lokasi->id_lokasi = isset($_GET['id_lokasi']) ? $_GET['id_lokasi'] : die();

$lokasi->readOne();

if($lokasi->lokasi!=null) {
    $lokasi_arr = array(
        "id_lokasi" => $lokasi->id_lokasi,
        "lokasi" => $lokasi->lokasi,
        "alamat" => $lokasi->alamat
    );

    http_response_code(200);
    echo json_encode($lokasi_arr); 
} else {
    http_response_code(404); 
    echo json_encode(array("message" => "lokasi does not exist"));
}

?>