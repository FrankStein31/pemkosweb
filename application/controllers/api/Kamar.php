<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Kamar extends REST_Controller {

    public function __construct() { 
        parent::__construct();
		$this->load->model('Mcrud');
        define('UPLOAD_DIR', 'assets/image/kamar/');
    }
   
    public function index_get() {
       $data = $this->Mcrud->getkamar();
       
        if(!empty($data)){
            foreach($data->result() as $row){
                $row->foto = base_url("assets/image/kamar/$row->foto");
            }
            
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
         $kode = $this->post('kode');
         $id_kos = $this->post('id_kos');
         $tipe = $this->post('tipe');
         $gender = $this->post('gender');
         $biaya = $this->post('biaya');
         $fasilitas = $this->post('fasilitas');
         $foto = $this->post('foto');

          // Validate the post data
          $userData = array(
            'kode' => $kode,
            'id_kos' => $id_kos,
            'tipe' => $tipe,
            'biaya' => $biaya,
            'gender' => $gender,
            'fasilitas' => $fasilitas
        );

         if($foto!=""){
            $img = str_replace('data:image/png;base64,', '', $foto);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $filename = uniqid() . '.png';
            $file = UPLOAD_DIR . $filename;
            file_put_contents($file, $data);
            $userData["foto"] = $filename;
         }

         
        
        $insert = $this->Mcrud->tambah('kamar', $userData);
        
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
         $id_kamar = $this->post('id_kamar');
         $kode = $this->post('kode');
         $id_kos = $this->post('id_kos');
         $tipe = $this->post('tipe');
         $gender = $this->post('gender');
         $fasilitas = $this->post('fasilitas');
         $biaya = $this->post('biaya');
         $foto = $this->post('foto');

          // Validate the post data
          $userData = array(
            'kode' => $kode,
            'id_kos' => $id_kos,
            'tipe' => $tipe,
            'gender' => $gender,
            'biaya' => $biaya,
            'fasilitas' => $fasilitas
        );

         if($foto!=""){
            $img = str_replace('data:image/png;base64,', '', $foto);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $filename = uniqid() . '.png';
            $file = UPLOAD_DIR . $filename;
            file_put_contents($file, $data);
            $userData["foto"] = $filename;

            $gambar ="";
			$rfoto = $this->Mcrud->getkamarbyid($id_kamar);
			foreach ($rfoto->result() as $row) {
				$gambar = $row->foto;
			}
			if($gambar!="")$this->Mcrud->deleteFile($gambar,"assets/image/kamar");
         }

         
        
        $insert = $this->Mcrud->ubah('kamar', $userData,"id_kamar",$id_kamar);
        
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
        $gambar ="";
		$rfoto = $this->Mcrud->getkamarbyid($id);
		foreach ($rfoto->result() as $row) {
			$gambar = $row->foto;
		}
		if($gambar!="")$this->Mcrud->deleteFile($gambar,"assets/image/kamar");
		$data= "id_kamar='$id'";
		$hapus = $this->Mcrud->hapus('kamar', $data);

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