<?php
require_once "../../../Controller/database.php";

class Peminjaman{
    private $table="peminjaman";
    private $db;

    function __construct(){
        $this->db = new Database();
    }

    function readData($condition = null){ 
        return $this->db->select($this->table, $condition);
    } 


    function createData($rows){
        $this->db->insert($this->table, $rows);
    }
    function updateData($data,$where){
        $this->db->update($this->table,$data, $where);
    }

    function deleteData($where){
        $this->db->delete($this->table, $where);
    }
    
    function tambahDenda() {
        return $this->db->updateDenda($this->table);
    }
    function bukuTersedia($id_buku){
        return $this->db->checkBuku($id_buku);
    }
    function tambahStockBuku($id_buku){
        return $this->db->tambahStockBuku($id_buku);
    }
    function updatePengembalian($kode_peminjaman){
        return $this->db->updateStatus($kode_peminjaman);
    }
}
?>
