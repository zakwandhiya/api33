<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . 'libraries/REST_Controller.php');

class MasterController extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        // parent::__construct();
        $this->load->model('AuthModel');
        $this->load->model('MasterModel');
        $this->data["title"] = "";
        date_default_timezone_set("Asia/Jakarta"); 
        $this->dateToday = date("Y-m-d H:i:s");
        $this->timeToday = date("h:i:s");
    }

    function dataLakonAll_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->MasterModel->getLakonAll()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function dataUserAll_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->MasterModel->getUserAll()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function dataKategori_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->MasterModel->getKategori()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function tampilkanIklan_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->MasterModel->getIklan()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function hasilPencarian_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $cari = $this->input->post('cari');
            $result = $this->MasterModel->getPencarian($cari)->result();
            $this->response(array('status' => 'success','msg' => 'Search is correct!', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function infoAkun_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $result = $this->MasterModel->getInfoAkun($id);
            $check = $result->num_rows();
            if($check > 0){
                $result = $result->row();
                $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $result));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Get information is Incorrect!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function updateInfoAkun_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $kolom = $this->input->post('kolom');
            $nilai = $this->input->post('nilai');
            $data = array(
                $kolom => $nilai,
                'tanggal_diubah' => $this->dateToday
            );
            $update = $this->AuthModel->userUpdate($id, $data);
            if($update>0){
                $this->response(array('status' => 'success','msg' => 'Update is success!', 'affected' => $update));
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function infoHarga_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $result = $this->MasterModel->getInfoHargaAll($id);
            $check = $result->num_rows();
            if($check > 0){
                $result = $result->result();
                $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $result));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Get information is Incorrect!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function updateInfoHarga_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_layanan = $this->input->post('id_layanan');
            $nama_layanan = $this->input->post('nama_layanan');
            $deskripsi = $this->input->post('deskripsi');
            $harga = $this->input->post('harga');
            $harga_promo = $this->input->post('harga_promo');
            if($harga > $harga_promo){
                $status_promo = 1;
            }
            else if($harga <= $harga_promo){
                $status_promo = 0;
            }
            else{
                $status_promo = 0;
            }
            $data = array(
                'nama_layanan' => $nama_layanan,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'status_promo' => $status_promo,
                'harga_promo' => $harga_promo
            );
            $update = $this->MasterModel->updateInfoHarga($data, $id_layanan);
            if($update > 0){
                $this->response(array('status' => 'success','msg' => 'Update is success!'));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function deleteInfoHarga_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_layanan = $this->input->post('id_layanan');
            $delete = $this->MasterModel->deleteInfoHarga($id_layanan);
            if($delete > 0){
                $this->response(array('status' => 'success','msg' => 'Delete is success!', 'affected rows' => $delete));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Delete is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function infoGaleri_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $result = $this->MasterModel->getInfoGaleri($id);
            $check = $result->num_rows();
            if($check > 0){
                $result = $result->result();
                $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $result));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Get information is Incorrect!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function masukkanHargaLayanan_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $user = $this->AuthModel->userDataById($id);
            $check = $user->num_rows();
            if($check > 0){
                $id_pelakon = $user->row('id');
                $nama_layanan = $this->input->post('nama_layanan');
                $deskripsi = $this->input->post('deskripsi');
                $harga = $this->input->post('harga');
                $harga_promo = $this->input->post('harga_promo');
                if($harga > $harga_promo){
                    $status_promo = 1;
                }
                else if($harga <= $harga_promo){
                    $status_promo = 0;
                }
                else{
                    $status_promo = 0;
                }
                $data = array(
                    'id_pelakon' => $id_pelakon,
                    'nama_layanan' => $nama_layanan,
                    'deskripsi' => $deskripsi,
                    'harga' => $harga,
                    'status_promo' => $status_promo,
                    'harga_promo' =>$harga_promo
                );
                $insert = $this->MasterModel->insertInfoHarga($data);
                if($insert > 0){
                    $this->response(array('status' => 'success','msg' => 'Insert is success!','affected' => $insert));
                }
                else{
                    $this->response(array('status' => 'failed','msg' => 'Insert is failed!'));
                }
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Get information is Incorrect!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function updateInfoGaleri_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_foto = $this->input->post('id_foto');
            //$id_pelakon = $this->input->post('id_pelakon');
            $foto_url = $this->input->post('foto_url');
            $data = array(
                'foto_url' => $foto_url
            );
            $update = $this->MasterModel->updateInfoGaleri($data, $id_foto);
            if($update > 0){
                $this->response(array('status' => 'success','msg' => 'Update is success!'));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function masukkanTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            //data transaksi
            $id_pelakon = $this->input->post('id_pelakon');
            $id_member = $this->input->post('id_member');
            $jam = $this->input->post('jam');
            $tanggal = $this->input->post('tanggal');
            $keterangan = $this->input->post('keterangan');
            $alamat = $this->input->post('alamat');
            //masukkan ke database
            $data = array(
                'id_pelakon' => $id_pelakon,
                'id_member' => $id_member,
                'jam' => $jam,
                'tanggal' => $tanggal,
                'tipe_pembayaran' => 'cash',
                'keterangan' => $keterangan,
                'alamat' => $alamat,
                'status_kesepakatan' => 'pending',
                'status_pembayaran' => 'pending',
                'tanggal_dibuat' => $this->dateToday,
                'tanggal_diubah' => $this->dateToday,
                'ongkos' => 2500
            );
            $insert = $this->MasterModel->insertTransaksi($data);
            $id_pemesanan = $insert;
            if(isset($id_pemesanan) > 0){
                //data transaksi item yang masuk
                $id_layanan = $this->input->post('id_layanan'); //tipe string. ex: 1,2,3
                $jumlah_layanan = $this->input->post('jumlah_layanan'); //tipe string, ex: 2,4,6
                $kuantitas = $this->input->post('kuantitas');
                $array_layanan = explode(',', $id_layanan); //pemecahan string menjadi array 2 dimensi
                $array_jumlah_layanan = explode(',', $jumlah_layanan); //pemecahan string menjadi array 2 dimensi
                $array_kuantitas = explode(',', $kuantitas);
                //untuk memasukkan item ke db, ambil id dari transaksi terlebih dahulu
                //$idTransaksi = insert traksai ke model -> ini isinya id transaksi yg terakhir kali di insertin = 10
                for($i = 0; $i < count($array_layanan); $i++){
                    $layanan = $this->MasterModel->getLayananById($array_layanan[$i]);
                    $data2 = array(
                        'id_pemesanan' => $id_pemesanan,
                        'id_layanan' => $array_layanan[$i],
                        'nama_layanan' => $layanan->row('nama_layanan'),
                        'harga_satuan' => $layanan->row('harga'), //masukkan dengan id, bukan inputan user
                        'kuantitas' => $array_kuantitas[$i],
                        'harga_total' => $layanan->row('harga')*$array_kuantitas[$i]
                    );
                    $insert = $this->MasterModel->insertTransaksiItem($data2);
                } 
                $data_nego = array(
                    'id_transaksi' => $id_pemesanan,
                    'id_pengirim' => $id_member,
                    'jam' => $jam,
                    'tanggal' => $tanggal,
                    'alamat' => $alamat,
                    'keterangan' => $keterangan,
                    'tanggal_dibuat' => $this->dateToday,
                    'tanggal_diubah' => $this->dateToday,
                );
                $insert = $this->MasterModel->insertNego($data_nego);
               $this->response(array('status' => 'success','msg' => 'Insert Item is correct!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function daftarTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $role = $this->input->post('role');
            if($role == 'member'){
                $result = $this->MasterModel->getTransaksiMember($id);
                $check2 = $result->num_rows();
                if($check2 > 0){
                    $arrayData = array();
                    $i = 0;
                    foreach($result->result() as $row){
                        $arrayData[$i]['id_pemesanan']= $row->id_pemesanan;
                        $arrayData[$i]['id_pelakon'] = $row->id_pelakon;
                        $arrayData[$i]['id_member'] = $row->id_member;
                        $arrayData[$i]['nama_pelakon'] = $this->MasterModel->getTransaksiUser($row->id_pelakon)->row('nama');
                        $arrayData[$i]['nama_member'] = $this->MasterModel->getTransaksiUser($row->id_member)->row('nama');
                        $arrayData[$i]['jam'] = $row->jam;
                        $arrayData[$i]['tanggal'] = $row->tanggal;
                        $arrayData[$i]['ongkos'] = $row->ongkos;
                        $arrayData[$i]['keterangan'] = $row->keterangan;
                        $arrayData[$i]['alamat'] = $row->alamat;
                        $arrayData[$i]['tipe_pembayaran'] = $row->tipe_pembayaran;
                        $arrayData[$i]['status_kesepakatan'] = $row->status_kesepakatan;
                        $arrayData[$i]['status_pembayaran'] = $row->status_pembayaran;
                        $id = $row->id_pemesanan;
                        $resultItem = $this->MasterModel->getTransaksiItem($id)->result();
                        $j = 0;
                        $arrayData[$i]['transaksi_item'] = array();
                        $total_harga = 0;
                        foreach($resultItem as $r){
                            $arrayData[$i]['transaksi_item'][$j]['id_item']= $r->id_item;
                            $arrayData[$i]['transaksi_item'][$j]['id_layanan']= $r->id_layanan;
                            $arrayData[$i]['transaksi_item'][$j]['nama_layanan']= $r->nama_layanan;
                            $arrayData[$i]['transaksi_item'][$j]['harga_satuan']= $r->harga_satuan;
                            $arrayData[$i]['transaksi_item'][$j]['kuantitas']= $r->kuantitas;
                            $total_harga = $total_harga + ($r->kuantitas * $r->harga_satuan);
                            $j++;
                        };
                    };
                    $arrayData[$i]['total_harga'] = (string)$total_harga;
                    $i++;
                    $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $arrayData));
                }
                else{
                    $this->response(array('status' => 'failed','msg' => 'Data not found! please try different data', 'tipe' => '3'));
                }
            }
            else if($role == 'lakon'){
                $result = $this->MasterModel->getTransaksiLakon($id);
                $check2 = $result->num_rows();
                if($check2 > 0){
                    $nama = $this->MasterModel->getTransaksiUser($id, $role)->row('nama');
                    $arrayData = array();
                    $i = 0;
                    foreach($result->result() as $row){
                        $arrayData[$i]['id_pemesanan']= $row->id_pemesanan;
                        $arrayData[$i]['id_pelakon'] = $row->id_pelakon;
                        $arrayData[$i]['id_member'] = $row->id_member;
                        $arrayData[$i]['nama_pelakon'] = $this->MasterModel->getTransaksiUser($row->id_pelakon)->row('nama');
                        $arrayData[$i]['nama_member'] = $this->MasterModel->getTransaksiUser($row->id_member)->row('nama');
                        $arrayData[$i]['jam'] = $row->jam;
                        $arrayData[$i]['tanggal'] = $row->tanggal;
                        $arrayData[$i]['ongkos'] = $row->ongkos;
                        $arrayData[$i]['keterangan'] = $row->keterangan;
                        $arrayData[$i]['alamat'] = $row->alamat;
                        $arrayData[$i]['tipe_pembayaran'] = $row->tipe_pembayaran;
                        $arrayData[$i]['status_kesepakatan'] = $row->status_kesepakatan;
                        $arrayData[$i]['status_pembayaran'] = $row->status_pembayaran;
                        $id = $row->id_pemesanan;
                        $resultItem = $this->MasterModel->getTransaksiItem($id)->result();
                        $j = 0;
                        $arrayData[$i]['transaksi_item'] = array();
                        $total_harga = 0;
                        foreach($resultItem as $r){
                            $arrayData[$i]['transaksi_item'][$j]['id_item']= $r->id_item;
                            $arrayData[$i]['transaksi_item'][$j]['id_layanan']= $r->id_layanan;
                            $arrayData[$i]['transaksi_item'][$j]['nama_layanan']= $r->nama_layanan;
                            $arrayData[$i]['transaksi_item'][$j]['harga_satuan']= $r->harga_satuan;
                            $arrayData[$i]['transaksi_item'][$j]['kuantitas']= $r->kuantitas;
                            $total_harga = $total_harga + ($r->kuantitas * $r->harga_satuan);
                            $j++;
                        };
                        $arrayData[$i]['total_harga'] = (string)$total_harga;
                        $i++;
                    }
                    $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $arrayData));
                }
                else{
                    $this->response(array('status' => 'failed','msg' => 'Data not found! please try different data', 'tipe' => '3'));
                }
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'User Not Found!', 'tipe' => '3'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!', 'tipe' => '2'));
        }
    }

    function detailTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id = $this->input->post('id');
            $result = $this->MasterModel->getTransaksiDetail($id)->result();
            $arrayData = array();
            $i = 0;
            foreach($result as $row){
                $arrayData[$i]['id_pemesanan']= $row->id_pemesanan;
                $arrayData[$i]['id_pelakon'] = $row->id_pelakon;
                $arrayData[$i]['id_member'] = $row->id_member;
                $arrayData[$i]['total'] = $row->total;
                $arrayData[$i]['jam'] = $row->jam;
                $arrayData[$i]['tanggal'] = $row->tanggal;
                $arrayData[$i]['tipe_pembayaran'] = $row->tipe_pembayaran;
                $arrayData[$i]['status_kesepakatan'] = $row->status_kesepakatan;
                $arrayData[$i]['status_pembayaran'] = $row->status_pembayaran;
                $id = $row->id_pemesanan;
                $resultItem = $this->MasterModel->getTransaksiItem($id)->result();
                $j = 0;
                $arrayData[$i]['transaksi_item'] = array();
                foreach($resultItem as $r){
                    $arrayData[$i]['transaksi_item'][$j]['id_item']= $r->id_item;
                    $arrayData[$i]['transaksi_item'][$j]['id_layanan']= $r->id_layanan;
                    $arrayData[$i]['transaksi_item'][$j]['nama_layanan']= $r->nama_layanan;
                    $arrayData[$i]['transaksi_item'][$j]['harga_satuan']= $r->harga_satuan;
                    $arrayData[$i]['transaksi_item'][$j]['kuantitas']= $r->kuantitas;
                    $j++;
                }
                $i++;
            }
            $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $arrayData, 'tipe' => '1'));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!', 'tipe' => '2'));
        }
    }

    function detailTransaksiUpdated_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_transaksi = $this->input->post('id_transaksi');
            $result = $this->MasterModel->getTransaksiDetail($id_transaksi)->result();
            
            $arrayData = array();
            $i = 0;
            foreach($result as $row){
                $arrayData[$i]['id_pemesanan']= $row->id_pemesanan;
                $arrayData[$i]['id_pelakon'] = $row->id_pelakon;
                $arrayData[$i]['id_member'] = $row->id_member;
                $arrayData[$i]['nama_pelakon'] = $this->MasterModel->getTransaksiUser($row->id_pelakon)->row('nama');
                $arrayData[$i]['nama_member'] = $this->MasterModel->getTransaksiUser($row->id_member)->row('nama');
                $arrayData[$i]['jam'] = $row->jam;
                $arrayData[$i]['tanggal'] = $row->tanggal;
                $arrayData[$i]['ongkos'] = $row->ongkos;
                $arrayData[$i]['keterangan'] = $row->keterangan;
                $arrayData[$i]['alamat'] = $row->alamat;
                $arrayData[$i]['tipe_pembayaran'] = $row->tipe_pembayaran;
                $arrayData[$i]['status_kesepakatan'] = $row->status_kesepakatan;
                $arrayData[$i]['status_pembayaran'] = $row->status_pembayaran;
                
                $id = $row->id_pemesanan;
                $resultItem = $this->MasterModel->getTransaksiItem($id)->result();
                
                $arrayData[$i]['transaksi_item'] = array();
                $total_harga = 0;
                $j = 0;
                foreach($resultItem as $r){
                    $arrayData[$i]['transaksi_item'][$j]['id_item']= $r->id_item;
                    $arrayData[$i]['transaksi_item'][$j]['id_layanan']= $r->id_layanan;
                    $arrayData[$i]['transaksi_item'][$j]['nama_layanan']= $r->nama_layanan;
                    $arrayData[$i]['transaksi_item'][$j]['harga_satuan']= $r->harga_satuan;
                    $arrayData[$i]['transaksi_item'][$j]['kuantitas']= $r->kuantitas;
                    $total_harga = $total_harga + ($r->kuantitas * $r->harga_satuan);
                    $j++;
                };
                $arrayData[$i]['total_harga'] = (string)$total_harga;
                $i++;
            }
            $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $arrayData));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function masukkanNego_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_transaksi = $this->input->post('id_pemesanan');
            $id_pengirim = $this->input->post('id_pengirim');
            $jam = $this->input->post('jam');
            $tanggal = $this->input->post('tanggal');
            $alamat = $this->input->post('alamat');
            $keterangan = $this->input->post('keterangan');
            $data = array(
                'id_transaksi' => $id_transaksi,
                'id_pengirim' => $id_pengirim,
                'jam' => $jam,
                'tanggal' => $tanggal,
                'alamat' => $alamat,
                'keterangan' => $keterangan,
                'tanggal_dibuat' => $this->dateToday,
                'tanggal_diubah' => $this->dateToday
            );
            $insert = $this->MasterModel->insertNego($data);
            if(isset($insert)){
                $this->response(array('status' => 'success','msg' => 'Insert Item is success!'));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Failed to Insert! please try again'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function detailNego_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_transaksi = $this->input->post('id_transaksi');
            $result = $this->MasterModel->getNego($id_transaksi);
            if($result->num_rows() > 0){
                $this->response(array('status' => 'success','msg' => 'Get Information is success!', 'data' => $result->result()));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Failed to get Informastion! please try again'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function masukkanNotifikasi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_pengirim = $this->input->post('id_pengirim');
            $id_penerima = $this->input->post('id_penerima');
            $id_transaksi = $this->input->post('id_transaksi');
            $teks_notifikasi = $this->input->post('teks_notifikasi');
            $tipe_notifikasi = $this->input->post('tipe_notifikasi');
            $data = array(
                'id_pengirim' => $id_pengirim,
                'id_penerima' => $id_penerima,
                'id_transaksi' => $id_transaksi,
                'teks_notifikasi' => $teks_notifikasi,
                'tanggal_dibuat' => $this->dateToday,
                'tanggal_diubah' => $this->dateToday,
                'tipe_notifikasi' => $tipe_notifikasi
            );
            $insert = $this->MasterModel->insertNotifikasi($data);
            if($insert > 0){
                $this->response(array('status' => 'success','msg' => 'Insert Notification is success!'));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Failed to Insert! please try again'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function updateNotifikasiTerbaca_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_notifikasi = $this->input->post('id_notifikasi');
            $data = array(
                'dibaca' => 1
            );
            $update = $this->MasterModel->updateReadNotifikasi($id_notifikasi, $data);
            if($update > 0){
                $this->response(array('status' => 'success','msg' => 'Update is success!'));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function detailNotifikasi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_penerima = $this->input->post('id_penerima');
            $result = $this->MasterModel->getNotifikasiByPenerima($id_penerima);
            if($result->num_rows() > 0){
                $this->response(array('status' => 'success','msg' => 'Get information is correct!', 'data' => $result->result()));
            }
            else{
                $this->response(array('status' => 'failed','msg' => 'Failed to get Informastion! please try again', 'tipe' => '1'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!', 'tipe' => '2'));
        }
    }

    function updateTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_pemesanan = $this->input->post('id_pemesanan');
            $kolom = $this->input->post('kolom');
            $nilai = $this->input->post('nilai');
            $data = array(
                $kolom => $nilai,
                'tanggal_diubah' => $this->dateToday
            );
            $update = $this->MasterModel->updateTransaksi($id_pemesanan, $data);
            if($update>0){
                $this->response(array('status' => 'success','msg' => 'Update is success!', 'affected' => $update));
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function terimaTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_pemesanan = $this->input->post('id_pemesanan');
            $jam = $this->input->post('jam');
            $tanggal = $this->input->post('tanggal');
            $alamat = $this->input->post('alamat');
            $data = array(
                'jam' => $jam,
                'tanggal' => $tanggal,
                'alamat' => $alamat,
                'status_kesepakatan' => 'disetujui',
                'tanggal_diubah' => $this->dateToday
            );
            $update = $this->MasterModel->updateTransaksi($id_pemesanan, $data);
            if($update>0){
                $id_pengirim = $this->input->post('id_pengirim_notif');
                $id_penerima = $this->input->post('id_penerima_notif');
                $id_pemesanan = $this->input->post('id_pemesanan');
                $data_notifikasi = array(
                    'id_pengirim' => $id_pengirim,
                    'id_penerima' => $id_penerima,
                    'id_transaksi' => $id_pemesanan,
                    'teks_notifikasi' => 'transaksi diterima',
                    'tanggal_dibuat' => $this->dateToday,
                    'tanggal_diubah' => $this->dateToday,
                    'tipe_notifikasi' => '11'
                );
                $insert_notifikasi = $this->MasterModel->insertNotifikasi($data_notifikasi);
                if($insert_notifikasi > 0){
                    $this->response(array('status' => 'success','msg' => 'Update is success!', 'affected' => $update));
                }else{
                    $this->response(array('status' => 'failed','msg' => 'Insert notification is failed! Try to update different data value'));
                }
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function tolakTransaksi_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_pemesanan = $this->input->post('id_pemesanan');
            $jam = $this->input->post('jam');
            $tanggal = $this->input->post('tanggal');
            $alamat = $this->input->post('alamat');
            $data = array(
                'status_kesepakatan' => 'ditolak',
                'tanggal_diubah' => $this->dateToday
            );
            $update = $this->MasterModel->updateTransaksi($id_pemesanan, $data);
            if($update>0){
                $id_pengirim = $this->input->post('id_pengirim_notif');
                $id_penerima = $this->input->post('id_penerima_notif');
                $id_pemesanan = $this->input->post('id_pemesanan');
                $teks_notifikasi = $this->input->post('teks_notifikasi');
                $data_notifikasi = array(
                    'id_pengirim' => $id_pengirim,
                    'id_penerima' => $id_penerima,
                    'id_transaksi' => $id_pemesanan,
                    'teks_notifikasi' => $teks_notifikasi,
                    'tanggal_dibuat' => $this->dateToday,
                    'tanggal_diubah' => $this->dateToday,
                    'tipe_notifikasi' => '10'
                );
                $insert_notifikasi = $this->MasterModel->insertNotifikasi($data_notifikasi);
                if($insert_notifikasi > 0){
                    $this->response(array('status' => 'success','msg' => 'Update is success!', 'affected' => $update));
                }else{
                    $this->response(array('status' => 'failed','msg' => 'Insert notification is failed! Try to update different data value'));
                }
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function masukanNegoUpdate_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_transaksi = $this->input->post('id_pemesanan');
            $id_pengirim = $this->input->post('id_pengirim');
            $jam = $this->input->post('jam');
            $tanggal = $this->input->post('tanggal');
            $alamat = $this->input->post('alamat');
            $keterangan = $this->input->post('keterangan');
            $data = array(
                'id_transaksi' => $id_transaksi,
                'id_pengirim' => $id_pengirim,
                'jam' => $jam,
                'tanggal' => $tanggal,
                'alamat' => $alamat,
                'keterangan' => $keterangan,
                'tanggal_dibuat' => $this->dateToday,
                'tanggal_diubah' => $this->dateToday
            );
            $insert = $this->MasterModel->insertNego($data);
            if(isset($insert)){
                $id_pengirim = $this->input->post('id_pengirim_notif');
                $id_penerima = $this->input->post('id_penerima_notif');
                $id_pemesanan = $this->input->post('id_pemesanan');
                $data_notifikasi = array(
                    'id_pengirim' => $id_pengirim,
                    'id_penerima' => $id_penerima,
                    'id_transaksi' => $id_pemesanan,
                    'teks_notifikasi' => 'penambahan nego',
                    'tanggal_dibuat' => $this->dateToday,
                    'tanggal_diubah' => $this->dateToday,
                    'tipe_notifikasi' => '21'
                );
                $insert_notifikasi = $this->MasterModel->insertNotifikasi($data_notifikasi);
                if($insert_notifikasi > 0){
                    $this->response(array('status' => 'success','msg' => 'Update is success!', 'affected' => $insert_notifikasi));
                }else{
                    $this->response(array('status' => 'failed','msg' => 'Insert notification is failed! Try to update different data value'));
                }
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed! Try to update different data value'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

}