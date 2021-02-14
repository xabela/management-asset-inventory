<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/kategori.php';

$database = new Database();
$db = $database->getConnection();

$kategori = new Kategori($db);

$kategori->id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : die();

$kategori->readOne();

if($kategori->kategori!=null) {
    $kategori_arr = array(
        "id_kategori" => $kategori->id_kategori,
        "kategori" => $kategori->kategori
    );

    http_response_code(200);
    echo json_encode($kategori_arr); 
} else {
    http_response_code(404); 
    echo json_encode(array("message" => "kategori does not exist"));
}

?>