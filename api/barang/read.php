<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../models/barang.php';

$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

$stmt = $barang->read();
$num = $stmt->rowCount(); 

if ($num > 0) {
    http_response_code(200);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No barang Found")
    );
};
?>