<?php
class Lokasi {
    private $conn;
    private $table_name = 'lokasi';

    public $id_lokasi;
    public $lokasi;
    public $alamat;

    public function __construct($db) {
        $this->conn = $db;
    }

    function readAll() {
        $query = "SELECT id_lokasi, lokasi, alamat
                FROM " . $this->table_name . " 
                ORDER BY lokasi";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function read() {
        $query = "SELECT id_lokasi, lokasi, alamat
                FROM " . $this->table_name . " 
                ORDER BY lokasi";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT id_lokasi, lokasi, alamat
                FROM " . $this->table_name . " 
                WHERE id_lokasi = ?
                LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_lokasi); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        $this->lokasi = $row['lokasi'];
        $this->alamat = $row['alamat'];    
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET lokasi=:lokasi, alamat=:alamat";
                
        $stmt = $this->conn->prepare($query);

        $this->lokasi=htmlspecialchars(strip_tags($this->lokasi));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));

        $stmt->bindParam(":lokasi", $this->lokasi);
        $stmt->bindParam(":alamat", $this->alamat);

        if($stmt->execute()) {
            return true;
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET lokasi=:lokasi,
                alamat=:alamat 
                WHERE
                    id_lokasi=:id_lokasi";
        
        $stmt = $this->conn->prepare($query);

        $this->lokasi=htmlspecialchars(strip_tags($this->lokasi));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));
        $this->id_lokasi=htmlspecialchars(strip_tags($this->id_lokasi)); 

        $stmt->bindParam(":lokasi", $this->lokasi);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":id_lokasi", $this->id_lokasi);

        if($stmt->execute()) {
            return true;
        }
        return false;

    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_lokasi = ?";

        $stmt = $this->conn->prepare($query);
        $this->id_lokasi = htmlspecialchars(strip_tags($this->id_lokasi));
        $stmt->bindParam(1, $this->id_lokasi);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>