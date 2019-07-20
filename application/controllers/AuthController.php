<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . 'libraries/REST_Controller.php');

class AuthController extends REST_Controller {
    function __construct($config = 'rest') {
        parent::__construct($config);
        // parent::__construct();
		$this->load->model('AuthModel');
        $this->data["title"] = "";
        date_default_timezone_set("Asia/Jakarta"); 
        $this->dateToday = date("Y-m-d H:i:s");
    }

    function prosesMasuk_post(){
        //meminta header
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check>0){
            $email = $this->input->post('email');
            $check1 = $this->AuthModel->userData($email)->num_rows();
            if($check1>0){
                $data = array(
                    "status_online" => 1,
                    "tanggal_diubah" => $this->dateToday
                );
                $id = $this->AuthModel->userData($email)->row("id");
                $this->AuthModel->userUpdate($id, $data);
                $result = $this->AuthModel->infoUser($id)->result();
                $this->response(array('status' => 'success', 'phone' => '+6285376478960','msg' => 'Username or password is correct!','data' =>$result));
            }else{
                $this->response(array('status' => 'failed','msg' => 'Username or password is incorrect!'));
            }
        }else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function prosesDaftar_post(){
        //meminta header
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        if($check>0){
            $email = $this->input->post('email');
            $nama = $this->input->post('nama');
            $role = $this->input->post('role');
            $id_sosial_media = $this->input->post('id_sosial_media');
            $foto_url = $this->input->post('foto_url');
            $sosial_media = $this->input->post('sosial_media');
            $check = $this->AuthModel->userData($email)->num_rows();
            if($check==0){
                $data = array(
                    "email" => $email,
                    "nama" => $nama,
                    "foto_url" => $foto_url,
                    "sosial_media" => $sosial_media,
                    "id_sosial_media" => $id_sosial_media,
                    "role" => $role,
                    "id_sosial_media" => $id_sosial_media,
                    "status_online" => 1,
                    "tanggal_dibuat" => $this->dateToday,
                    "tanggal_diubah" => $this->dateToday
                );
                $insert = $this->AuthModel->userInsert($data);
                $result = $this->AuthModel->userData($email)->result();
                if($insert > 0){
                    $this->response(array('status' => 'success','msg' => 'Register is success!','data' =>$result));
                }else{
                    $this->response(array('status' => 'failed','msg' => 'Register is failed!'));
                }
            }else{
                $this->response(array('status' => 'failed','msg' => 'Account is registered!'));
            }
        }else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }

    function prosesKeluar_post(){
        $header = $this->input->request_headers();
        $key = $header['key'];
        $check = $this->AuthModel->getKey($key)->num_rows();
        $email = $this->input->post('email');
        if($check > 0){
            $data = array(
                "status_online" => 0,
                "tanggal_diubah" => $this->dateToday
            );
            $id = $this->AuthModel->userData($email)->row("id");
            $update = $this->AuthModel->userUpdate($id, $data);
            if($update>0){
                $this->response(array('status' => 'success','msg' => 'Update is success!'));
            }else{
                $this->response(array('status' => 'failed','msg' => 'Update is failed!'));
            }
        }
        else{
            $this->response(array('status' => 'failed','msg' => 'Header is incorrect!'));
        }
    }
}