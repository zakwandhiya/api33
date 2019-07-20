<?php
 date_default_timezone_set("Asia/Jakarta"); 
 if (!defined('BASEPATH'))
 	exit('No direct script access allowed');
    // date_default_timezone_set("Asia/Jakarta"); 
class AuthModel extends CI_Model {

    function getKey($key){
		$query = $this->db->query("SELECT * FROM kunci a WHERE a.kode_kunci  = '$key'");
		return $query;
    }

    function userData($email){
        $query = $this->db->get_where('user', array('email' => $email));
        //$query = $this->db->query("SELECT * FROM user a WHERE a.email = '$email'");
		return $query;
    }

    function infoUser($id){
        $query = $this->db->query("
        SELECT a.*, b.nama as 'nama_kategori'
        FROM user a
        LEFT OUTER JOIN kategori b
        ON a.id_kategori = b.id_kategori
        WHERE a.id = $id");
        return $query;
    }

    function userDataById($id){
        $query = $this->db->get_where('user', array('id' => $id));
        return $query;
    }

    function userInsert($data){
        $this->db->insert('user', $data);
        return $this->db->affected_rows();
    }

    function userUpdate($id, $data){
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }
}