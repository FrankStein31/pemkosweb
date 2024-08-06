<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Profil extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('Mcrud');

        define('UPLOAD_DIR', 'assets/image/sekolah/');
    }
    
    public function index_post() {
       // Get the post data
        $id_pengguna = strip_tags($this->post('id_pengguna'));
        $nama = strip_tags($this->post('nama'));
        $email = strip_tags($this->post('email'));
        //$id_gejala = 1;//strip_tags($this->post('id_gejala'));
        
        // Validate the post data
        if(!empty($id_pengguna)){
          
                $data = array(
                    'nama' => $nama,
                    'email' => $email,
                );
                $update = $this->Profil_Model->ubah("pengguna", $data,"id_pengguna",$id_pengguna);
                
                if($update){
                    // Set the response and exit
                    $this->response([
                        'success' => TRUE,
                        'message' => 'Berhasil.',
                        'data' => $update
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response([
                        'success' => FALSE,
                        'message' => "Gagal ! Coba lagi."
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
        }else{
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Coba Beberapa Saat lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function edit_post() {
        // Get the post data
         $id = strip_tags($this->post('id_sekolah'));
         $nama = strip_tags($this->post('nama_sekolah'));
         $kepsek = strip_tags($this->post('nama__kepala_sekolah'));
         $alamat = strip_tags($this->post('alamat'));
         $email = strip_tags($this->post('email'));
         $foto = strip_tags($this->post('foto'));

          // Validate the post data
          $userData = array(
            'nama_sekolah' => $nama,
            'nama_kepala_Sekolah' => $kepsek,
            'alamat' => $alamat,
            'email' => $email,
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
			$rfoto = $this->Mcrud->getsekolahbyid($id);
			foreach ($rfoto->result() as $row) {
				$gambar = $row->foto;
			}
			if($gambar!="")$this->Mcrud->deleteFile($gambar,"assets/image/sekolah");
         }

         
        
        $insert = $this->Mcrud->ubah('sekolah', $userData,"id_sekolah",$id);
        
        if($insert){
            if($foto!=""){
                $tmpfoto =  $userData["foto"];
                if($tmpfoto!="") $userData["foto"] = base_url("assets/image/sekolah/$tmpfoto");
            }
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

    public function ubahpassword_post() {
        // Get the post data
         $id = strip_tags($this->post('id'));
         $oldpwd = strip_tags($this->post('password_lama'));
         $newpwd = strip_tags($this->post('password_baru'));
         
         
         $data = $this->Mcrud->getAnakKosById($id);
         
         foreach($data->result() as $row){
         }
         if($data->num_rows() > 0 && $row->password == $oldpwd){
           
                 $data = array(
                     'password' => $newpwd
                 );
                 $update = $this->Mcrud->ubah("anak_kos", $data,"id_anak_kos",$id);
                 
                 if($update){
                     // Set the response and exit
                     $this->response([
                         'success' => TRUE,
                         'message' => 'Ubah password berhasil.',
                         'data' => $update
                     ], REST_Controller::HTTP_OK);
                 }else{
                     // Set the response and exit
                     $this->response([
                         'success' => FALSE,
                         'message' => "Gagal ! Coba lagi."
                     ], REST_Controller::HTTP_OK);
                 }
         }else{
             // Set the response and exit
             $this->response([
                 'success' => FALSE,
                 'message' => "Password salah"
             ], REST_Controller::HTTP_OK);
         }
     }


}