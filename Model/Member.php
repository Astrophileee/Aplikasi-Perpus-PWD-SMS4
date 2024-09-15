<?php
require_once "../../../Controller/database.php";

class Member{
    private $table="member";
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
}
?>
