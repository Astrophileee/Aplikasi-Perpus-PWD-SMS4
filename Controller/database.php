<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'perpustakaan');

class Database{
    private $pdo;

    function __construct(){
        try {
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

function checkUser($table, $username, $password) {
    $sql = "SELECT * FROM $table WHERE username = :username";
    $query = $this->pdo->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        if (password_verify($password, $user['password'])) {
            var_dump('password sama');
            return $user;
        } else {
            var_dump('password tidak sama');
            return false;
        }
    } else {
        return false;
    }
}

    function select($table, $condition = null){
        $sql = "SELECT * FROM $table";
        if ($condition) {
            $sql .= " $condition";
        }
    
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
}

    function insert($table, $rows){
    $keys = array_keys($rows);
    $sql = "INSERT INTO $table (" . implode(',', $keys) . ") VALUES (:" . implode(',:', $keys) . ")";
    $query = $this->pdo->prepare($sql);
    foreach ($rows as $key => &$value) {
        $query->bindParam(":$key", $value);
    }
    $query->execute();
}

    function update($table, $data, $where){
    $set = '';
    foreach ($data as $key => $value) {
        $set .= "$key = :$key, ";
    }
    $set = rtrim($set, ', ');
    $whereClause = '';
    foreach ($where as $key => $value) {
        $whereClause .= "$key = :where_$key AND ";
    }
    $whereClause = rtrim($whereClause, ' AND ');

    $sql = "UPDATE $table SET $set WHERE $whereClause";

    $stmt = $this->pdo->prepare($sql);

    foreach ($data as $key => &$value) {
        $stmt->bindParam(":$key", $value);
    }

    foreach ($where as $key => &$value) {
        $stmt->bindParam(":where_$key", $value);
    }

    $stmt->execute();
}
    function delete($table, $where){
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "$key = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');

        $sql = "DELETE FROM $table WHERE $whereClause";

        $stmt = $this->pdo->prepare($sql);

        foreach ($where as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();

    }

    function updateDenda($table){
        $sql = "UPDATE $table SET 
        denda = TIMESTAMPDIFF(DAY, tenggat_pengembalian, NOW()) * 100000 
        WHERE tenggat_pengembalian < NOW() AND denda < TIMESTAMPDIFF(DAY, tenggat_pengembalian, NOW()) * 100000";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    function checkBuku($id_buku){
        $sql_check = "SELECT jumlah FROM buku WHERE id = :id_buku";
        $query_check = $this->pdo->prepare($sql_check);
        $query_check->bindParam(':id_buku', $id_buku);
        $query_check->execute();
        $jumlah_buku = $query_check->fetchColumn();
        if ($jumlah_buku > 0) {
            $sql = "UPDATE buku SET jumlah = jumlah - 1 WHERE id = :id_buku";
            $query = $this->pdo->prepare($sql);
            $query->bindParam(':id_buku', $id_buku);
            $query->execute();
            return true;
        } else {
            return;
        }
    }
    function tambahStockBuku($id_buku){
        $sql = "UPDATE buku SET jumlah = jumlah + 1 WHERE id = :id_buku";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':id_buku', $id_buku);
        $query->execute();
    }

    public function updateStatus($kode_peminjaman) {
        $waktu_pengembalian = date('Y-m-d H:i:s');
        $sql = "UPDATE peminjaman SET status_pengembalian = true, waktu_pengembalian = :waktu_pengembalian WHERE kode_peminjaman = :kode_peminjaman";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':waktu_pengembalian', $waktu_pengembalian);
        $query->bindParam(':kode_peminjaman', $kode_peminjaman);
        $query->execute();
    }




}
