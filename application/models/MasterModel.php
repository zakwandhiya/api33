<?php
 date_default_timezone_set("Asia/Jakarta"); 
 if (!defined('BASEPATH'))
 	exit('No direct script access allowed');
    // date_default_timezone_set("Asia/Jakarta"); 
class MasterModel extends CI_Model {
    
    function getKategori(){
        $query = $this->db->get('kategori');
        return $query;
    }

    function getLayananById($id){
        $query = $this->db->get_where('layanan', array('id_layanan' => $id));
        return $query;
    }

    function getPencarian($cari){
        // $query = $this->db->query("SELECT u.*, l.* from user u, layanan l WHERE u.id = l.id_pelakon and u.role = '1' and (u.nama like '%$cari%' or l.nama_layanan like '%$cari%')");
        $query = $this->db->query("SELECT a.id_layanan , a.nama_layanan , a.deskripsi as 'deskripsi_layanan' , a.harga , a.status_promo , a.harga_promo , b.*, c.nama as 'nama_kategori' FROM layanan a
        INNER JOIN user b
        ON a.id_pelakon = b.id
        INNER JOIN kategori c
        ON b.id_kategori = c.id_kategori
        WHERE a.nama_layanan LIKE '%$cari%' or b.nama LIKE '%$cari%' or c.nama LIKE '%$cari%'");
        return $query;
    }

    function getLakonAll(){
        $query = $this->db->get_where('user', array('role' => 'lakon'));
        return $query;
    }

    function getUserAll(){
        $query = $this->db->get_where('user', array('role' => 'member'));
        return $query;
    }

    function getIklan(){
        $query = $this->db->get('iklan');
        return $query;
    }

    function getInfoAkun($id){
        $this->db->select('id, nama, email, role, latitude, longitude, status_online, status_verifikasi, deskripsi, foto_url');
        $this->db->from('user');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        return $query;
        //$query = $this->db->query("SELECT * FROM user a WHERE a.email = '$email'");
		//return $query;
    }

    function insertInfoHarga($data){
        $this->db->insert('layanan' ,$data);
        return $this->db->affected_rows();
    }

    function updateInfoHarga($data, $id){
        $this->db->where('id_layanan', $id);
        $this->db->update('layanan', $data);
        return $this->db->affected_rows();
    }

    function deleteInfoHarga($id){
        $this->db->where('id_layanan', $id);
        $this->db->delete('layanan');
        return $this->db->affected_rows();
    }

    function getInfoHargaAll($id){
        $query = $this->db->get_where('layanan', array('id_pelakon' => $id));
        return $query;
    }

    function getInfoGaleri($id){
        $query = $this->db->get_where('galeri', array('id_pelakon' => $id));
        return $query;
    }

    function updateInfoGaleri($data, $id){
        $this->db->where('id_foto', $id);
        $this->db->update('galeri', $data);
        return $this->db->affected_rows();
    }

    function getTransaksiUser($id){
        $query = $this->db->get_where('user', array('id' => $id));
        return $query;
    }

    function insertTransaksi($data){
        $this->db->insert('pemesanan', $data);
        return $this->db->insert_id();
    }
    function insertTransaksiItem($data){
        $this->db->insert('pemesanan_item', $data);
    }
    function getTransaksiItem($id){
        $query = $this->db->get_where('pemesanan_item', array('id_pemesanan' => $id));
        return $query;
    }

    function getTransaksiLakon($id){
        $query = $this->db->query(
            "SELECT * FROM pemesanan a
            WHERE a.id_pelakon = $id
            ORDER BY a.id_pemesanan DESC"
        );
        return $query;
    }

    function getTransaksiMember($id){
        $query = $this->db->query(
            "SELECT * FROM pemesanan a
            WHERE a.id_member = $id
            ORDER BY a.id_pemesanan DESC"
        );
        //SELECT b.nama as namaLakon, c.nama as namaMember, a.* FROM pemesanan a LEFT OUTER JOIN user b ON a.id_pelakon = b.id LEFT OUTER JOIN user c ON a.id_member = c.id
        return $query;
    }

    function getTransaksiDetail($id){
        $query = $this->db->get_where('pemesanan', array('id_pemesanan' => $id));
        return $query;
    }

    function updateTransaksi($id, $data){
        $this->db->where('id_pemesanan', $id);
        $this->db->update('pemesanan', $data);
        return $this->db->affected_rows();
    }

    function insertNego($data){
        $this->db->insert('nego', $data);
        return $this->db->affected_rows();
    }

    function getNego($id){
        $query = $this->db->query(
            "SELECT b.nama as 'nama_pengirim',c.status_kesepakatan as 'status_kesepakatan', a.*
            FROM nego a
            LEFT OUTER join user b
            ON a.id_pengirim = b.id
            LEFT OUTER JOIN pemesanan c
            ON a.id_transaksi = c.id_pemesanan
            where a.id_transaksi = $id
            order BY a.tanggal_diubah DESC"
        );
        return $query;
    }

    function insertNotifikasi($data){
        $this->db->insert('notifikasi', $data);
        return $this->db->affected_rows();
    }

    function getNotifikasiByPenerima($id){
        
        // "SELECT b.nama as nama_pengirim, a.*
        // FROM notifikasi a
        // INNER JOIN user b 
        // ON a.id_pengirim = b.id
        // where a.id_penerima = $id
        // order BY a.tanggal_diubah DESC"
        
        $query = $this->db->query(
            "SELECT b.nama as nama_pengirim, c.nama as nama_penerima , a.*
            FROM notifikasi a
            INNER JOIN user b 
            ON a.id_pengirim = b.id
            INNER JOIN user c 
            ON a.id_penerima = c.id
            where a.id_penerima = $id
            order BY a.tanggal_diubah DESC"
        );
        return $query;
    }
    
    function updateReadNotifikasi($id, $data){
        $this->db->where('id_notifikasi', $id);
        $this->db->update('notifikasi', $data);
        return $this->db->affected_rows();
    }
    
    /* 
    Ambil data berdasarkan interval harinya

    SELECT *, (DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)) AS diff
    FROM `pemesanan`
    WHERE tanggal_dibuat >= DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)
    ORDER BY tanggal_dibuat DESC; 
    */
}