<?php
class User{

    private $conn;
    private $table_name = "pengguna";

    public $id_user;
    public $username;
    public $email;
    public $token;
    public $role;

    public function __construct($db){
        $this->conn = $db;
    }

    function read() {
        $query = "SELECT id_user, username, email, role
                FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET email=:email";
                
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":email", $this->email);
        if($stmt->execute()) {
            return true;
        } else {
            return $stmt->error;
        }
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_user = ?";

        $stmt = $this->conn->prepare($query);
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $stmt->bindParam(1, $this->id_user);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function cek_email($token, $email, $name) {
        $query = "SELECT * FROM " . $this->table_name . "
                    WHERE email = '" . $email . "'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount()) {
            $query_token = "UPDATE " . $this->table_name . "
                            SET token = '" . $token ."', username = '" . $name ."'
                            WHERE email = '" . $email ."'";
            $stmt_token = $this->conn->prepare($query_token);

            if($stmt_token->execute()) {
                $dt_token = $token;
                return $dt_token;
            }
        } else { 
            return false;
        }

    }

    function hapus_token($token) {
        $query = "UPDATE  " . $this->table_name . " SET token='' WHERE token = '" . $token ."'";

        $stmt = $this->conn->prepare($query);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function cek_token($token){   
        $query = "SELECT * FROM " . $this->table_name . "
                    WHERE token = '" . $token . "' LIMIT 1" ;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
}