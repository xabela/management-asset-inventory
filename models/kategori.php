<?php
class Kategori {
    private $conn;
    private $table_name = 'kategori';

    public $id_kategori;
    public $kategori;

    public function __construct($db) {
        $this->conn = $db;
    }

    //query di dropdown nanti
    function readAll() {
        $query = "SELECT id_kategori, kategori
                FROM " . $this->table_name . " 
                ORDER BY kategori";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function read() {
        $query = "SELECT id_kategori, kategori
                FROM " . $this->table_name . " 
                ORDER BY kategori";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOne() {
        $query = "SELECT id_kategori, kategori
                FROM " . $this->table_name . " 
                WHERE id_kategori = ?
                LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id_kategori); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 

        $this->kategori = $row['kategori'];
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET kategori=:kategori";
                
        $stmt = $this->conn->prepare($query);

        $this->kategori=htmlspecialchars(strip_tags($this->kategori));

        $stmt->bindParam(":kategori", $this->kategori);

        if($stmt->execute()) {
            return true;
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . "
                SET kategori=:kategori
                WHERE
                    id_kategori=:id_kategori";
        
        $stmt = $this->conn->prepare($query);

        $this->kategori=htmlspecialchars(strip_tags($this->kategori));
        $this->id_kategori=htmlspecialchars(strip_tags($this->id_kategori)); 

        $stmt->bindParam(":kategori", $this->kategori);
        $stmt->bindParam(":id_kategori", $this->id_kategori);

        if($stmt->execute()) {
            return true;
        }
        return false;

    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_kategori = ?";

        $stmt = $this->conn->prepare($query);
        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));
        $stmt->bindParam(1, $this->id_kategori);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>