<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Kos extends REST_Controller {

    public function __construct() { 
        parent::__construct();
		$this->load->model('Mcrud');

    }
    
    public function index_get() {
       $data = $this->Mcrud->getkos();
      
        if(!empty($data)){
            
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil',
                'data'=>$data->result()], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Tidak Ditemukan.'
            ], REST_Controller::HTTP_OK);
        }
    }

    

    public function add_post() {
        // Get the post data
         $nama = strip_tags($this->post('nama'));

          // Validate the post data
          $userData = array(
            'nama_kos' => $nama,
        );
         
        
        $insert = $this->Mcrud->tambah('kos', $userData);
        
        if($insert){
            // Set the response and exit
            $this->response([
                'success' => TRUE,
                'message' => 'Berhasil.',
                'data' => $userData
            ], REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Gagal ! Coba lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function edit_post() {
        // Get the post data
         $id_kos = strip_tags($this->post('id_kos'));
         $nama = strip_tags($this->post('nama'));

          // Validate the post data
          $userData = array(
            'nama_kos' => $nama,
        );

        
        $insert = $this->Mcrud->ubah('kos', $userData,"id_kos",$id_kos);
        
        if($insert){
            // Set the response and exit
            $this->response([
                'success' => TRUE,
                'message' => 'Berhasil.',
                'data' => $userData
            ], REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Gagal ! Coba lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function delete_get($id){
        $data= "id_kos='$id'";
		$hapus = $this->Mcrud->hapus('kos', $data);

        if($hapus){
            // Set the response and exit
            $this->response([
                'success' => TRUE,
                'message' => 'Berhasil.'
            ], REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Gagal ! Coba lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    

}