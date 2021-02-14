<?php
class Barang {
    private $conn;
    private $table_name = 'barang';

    public $id_barang;
    public $kode_inventaris;
    public $nama;
    public $jumlah;
    public $harga;
    public $tanggal_beli;
    public $status;
    public $id_kategori;
    public $nama_kategori;
    public $id_lokasi;
    public $nama_lokasi;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
        $query = "SELECT k.kategori as nama_kategori, k.id_kategori as id_kategori,
                l.lokasi as nama_lokasi, l.id_lokasi as id_lokasi,
                b.id_barang, b.kode_inventaris, b.nama, b.jumlah, b.harga, b.tanggal_beli, b.status
                FROM " . $this->table_name . " b 
                INNER JOIN kategori k ON b.id_kategori = k.id_kategori
                INNER JOIN lokasi l ON b.id_lokasi = l.id_lokasi
                ORDER BY b.id_barang DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT k.kategori as nama_kategori, k.id_kategori as id_kategori,
                l.lokasi as nama_lokasi, l.id_lokasi as id_lokasi,
                b.id_barang, b.kode_inventaris, b.nama, b.jumlah, b.harga, b.tanggal_beli, b.status
                FROM " . $this->table_name . " b 
                INNER JOIN kategori k ON b.id_kategori = k.id_kategori
                INNER JOIN lokasi l ON b.id_lokasi = l.id_lokasi
                WHERE b.id_barang = ?
                LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_barang); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        $this->kode_inventaris = $row['kode_inventaris'];
        $this->nama = $row['nama'];
        $this->jumlah = $row['jumlah'];
        $this->harga = $row['harga'];
        $this->tanggal_beli = $row['tanggal_beli'];
        $this->status = $row['status'];
        $this->id_kategori = $row['id_kategori'];
        $this->nama_kategori = $row['nama_kategori'];    
        $this->id_lokasi = $row['id_lokasi'];
        $this->nama_lokasi = $row['nama_lokasi'];    
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET kode_inventaris=:kode_inventaris, nama=:nama, jumlah=:jumlah, harga=:harga, tanggal_beli=:tanggal_beli, status=:status, id_kategori=:id_kategori, id_lokasi=:id_lokasi";
                
        $stmt = $this->conn->prepare($query);

        $this->kode_inventaris=htmlspecialchars(strip_tags($this->kode_inventaris));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));
        $this->harga=htmlspecialchars(strip_tags($this->harga));
        $this->tanggal_beli=htmlspecialchars(strip_tags($this->tanggal_beli));
        $this->id_kategori=htmlspecialchars(strip_tags($this->id_kategori));
        $this->id_lokasi=htmlspecialchars(strip_tags($this->id_lokasi));

        $stmt->bindParam(":kode_inventaris", $this->kode_inventaris);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":jumlah", $this->jumlah);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":tanggal_beli", $this->tanggal_beli);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id_kategori", $this->id_kategori);
        $stmt->bindParam(":id_lokasi", $this->id_lokasi);

        if($stmt->execute()) {
            return true;
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET kode_inventaris=:kode_inventaris, nama=:nama, jumlah=:jumlah, harga=:harga, tanggal_beli=:tanggal_beli, status=:status, id_kategori=:id_kategori, id_lokasi=:id_lokasi
                WHERE
                    id_barang=:id_barang";
        
        $stmt = $this->conn->prepare($query);

        $this->kode_inventaris=htmlspecialchars(strip_tags($this->kode_inventaris));
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));
        $this->harga=htmlspecialchars(strip_tags($this->harga));
        $this->tanggal_beli=htmlspecialchars(strip_tags($this->tanggal_beli));
        $this->id_kategori=htmlspecialchars(strip_tags($this->id_kategori));
        $this->id_lokasi=htmlspecialchars(strip_tags($this->id_lokasi));
        $this->id_barang=htmlspecialchars(strip_tags($this->id_barang));

        $stmt->bindParam(":kode_inventaris", $this->kode_inventaris);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":jumlah", $this->jumlah);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":tanggal_beli", $this->tanggal_beli);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id_kategori", $this->id_kategori);
        $stmt->bindParam(":id_lokasi", $this->id_lokasi);
        $stmt->bindParam(":id_barang", $this->id_barang);

        if($stmt->execute()) {
            return true;
        }
        return false;

    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_barang = ?";

        $stmt = $this->conn->prepare($query);
        $this->id_barang = htmlspecialchars(strip_tags($this->id_barang));
        $stmt->bindParam(1, $this->id_barang);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>