<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . 'libraries/REST_Controller.php');

class AdminController extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('AuthModel');
		$this->load->model('AdminModel');
        $this->data["title"] = "";
        date_default_timezone_set("Asia/Jakarta"); 
        $this->dateToday = date("Y-m-d H:i:s");
    }

    function tampilkanDataMember_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->AdminModel->getAllMember()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function tampilkanDataLakon_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->AdminModel->getAllLakon()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function tampilkanDataKategori_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->AdminModel->getAllKategori()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function tampilkanDataIklan_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $result = $this->AdminModel->getAllIklan()->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function tampilkanDataTransaksiPending_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $status = 'pending';
            $result = $this->AdminModel->getTransaksi($status)->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function tampilkanDataTransaksiExpired_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $status = 'ditolak';
            $result = $this->AdminModel->getTransaksi($status)->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function tampilkanDataTransaksiAktif_get(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $status = 'sukses';
            $result = $this->AdminModel->getTransaksi($status)->result();
            $this->response(array('status' => 'success','msg' => 'Show list data', 'data' => $result));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function hapusIklan_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_iklan = $this->input->post('id_iklan');
            $result = $this->AdminModel->deleteIklan($id_iklan);
            $this->response(array('status' => 'success', 'code' => 200,'msg' => 'delete data is success'));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
    
    function hapusKategori_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check > 0){
            $id_kategori = $this->input->post('id_kategori');
            $result = $this->AdminModel->deleteKategori($id_kategori);
            $this->response(array('status' => 'success', 'code' => 200,'msg' => 'delete data is success'));
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
}