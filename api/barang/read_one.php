<?php

header("Acces-Control-Allow_origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/barang.php';

$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

$barang->id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : die();

$barang->readOne();

if($barang->nama!=null) {
    $barang_arr = array(
        "kode_inventaris" => $barang->kode_inventaris,
        "id_barang" => $barang->id_barang,
        "nama" => $barang->nama,
        "jumlah" => $barang->jumlah,
        "harga" => $barang->harga,
        "tanggal_beli" => $barang->tanggal_beli,
        "status" => $barang->status,
        "id_kategori" => $barang->id_kategori,
        "nama_kategori" => $barang->nama_kategori,
        "id_lokasi" => $barang->id_lokasi,
        "nama_lokasi" => $barang->nama_lokasi
    );

    http_response_code(200);
    echo json_encode($barang_arr); 
} else {
    http_response_code(404); 
    echo json_encode(array("message" => "barang does not exist"));
}

?>