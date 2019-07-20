<?php
 date_default_timezone_set("Asia/Jakarta"); 
 if (!defined('BASEPATH'))
 	exit('No direct script access allowed');
    // date_default_timezone_set("Asia/Jakarta"); 
class AdminModel extends CI_Model {
    function getAllMember(){
        $query = $this->db->get_where('user', array('role' => 'member'));
        return $query;
    }

    function getAllLakon(){
        $query = $this->db->get_where('user', array('role' => 'lakon'));
        return $query;
    }

    function getAllKategori(){
        $query = $this->db->get('kategori');
        return $query;
    }

    function getAllIklan(){
        $query = $this->db->get('iklan');
        return $query;
    }

    function getTransaksi($status){
        //$this->db->select();
        //$this->db->from('pemesanan');
        //$this->db->where('status_kesepakatan', $status);
        $query = $this->db->query(
            "SELECT a.id_pemesanan, b.nama as 'nama_pelakon', c.nama as 'nama_member', a.tipe_pembayaran, a.keterangan, a.status_kesepakatan, a.status_pembayaran
            FROM pemesanan a
            LEFT OUTER JOIN user b
            ON a.id_pelakon = b.id
            LEFT OUTER JOIN user c
            ON a.id_member = c.id
            WHERE a.status_pembayaran = '$status'"
        );
        return $query;
    }
    
    function deleteIklan($id){
        $this->db->where('id_iklan', $id);
        $this->db->delete('iklan');
    }
    
    function deleteKategori($id){
        $this->db->where('id_kategori', $id);
        $this->db->delete('kategori');
    }
}