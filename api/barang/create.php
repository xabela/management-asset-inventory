<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/barang.php';

$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

$data = json_decode(file_get_contents("php://input")); 
if (
    !empty($data->nama) &&
    !empty($data->jumlah)
) {
    $barang->kode_inventaris = $data->kode_inventaris;
    $barang->nama = $data->nama;
    $barang->jumlah = $data->jumlah;
    $barang->harga = $data->harga;
    $barang->tanggal_beli = $data->tanggal_beli;
    $barang->status = $data->status;
    $barang->id_kategori = $data->id_kategori;
    $barang->id_lokasi = $data->id_lokasi;
    
    if($barang->create()) {
        http_response_code(201); 
        echo json_encode(array("message => barang was created"));
    }

    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create barang."));

    }
}
else {
    http_response_code(400); 
    echo json_encode(array("message" => "Unable create barang. Data is incomplete"));
}
?>