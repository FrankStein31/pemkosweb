<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class AnakKos extends REST_Controller {

    public function __construct() { 
        parent::__construct();
		$this->load->model('Mcrud');

        define('UPLOAD_DIR', 'assets/image/anak_kos/');
    }
    
    public function index_get() {
       $data = $this->Mcrud->getanakkos();
      
        if(!empty($data)){
            foreach($data->result() as $row){
                if($row->foto!=null) $row->foto = base_url("assets/image/anak_kos/$row->foto");
                if($row->foto_kamar!=null) $row->foto_kamar = base_url("assets/image/kamar/$row->foto_kamar");
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

    public function search_post() {
        $id = strip_tags($this->post('id'));
        $keyword = strip_tags($this->post('keyword'));
        $data = $this->Mcrud->searchabk($id, $keyword);
        
         if(!empty($data)){
             foreach($data->result() as $row){
                $row->alamat = $row->alamat_abk;
                $row->foto = base_url("assets/image/anak_kos/$row->foto");
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

    // public function add_post() {
    //     // Get the post data
    //      $id_kamar = strip_tags($this->post('id_kamar'));
    //      $nama = strip_tags($this->post('nama'));
    //      $gender = strip_tags($this->post('gender'));
    //      $kode = strip_tags($this->post('kode'));
    //      $kontak = strip_tags($this->post('kontak'));
    //      $alamat = strip_tags($this->post('alamat'));
    //      $tgl_masuk = strip_tags($this->post('tgl_masuk'));
    //      $foto = strip_tags($this->post('foto'));

    //       // Validate the post data
    //       $userData = array(
    //         'id_kamar' => $id_kamar,
    //         'nama' => $nama,
    //         'gender' => $gender,
    //         'kode' => $kode,
    //         'kontak' => $kontak,
    //         'alamat' => $alamat,
    //         'tgl_masuk' => $tgl_masuk,
    //         'password' => '123',
    //     );

    //      if($foto!=""){
    //         $img = str_replace('data:image/png;base64,', '', $foto);
    //         $img = str_replace(' ', '+', $img);
    //         $data = base64_decode($img);
    //         $filename = uniqid() . '.png';
    //         $file = UPLOAD_DIR . $filename;
    //         file_put_contents($file, $data);
    //         $userData["foto"] = $filename;
    //      }

         
        
    //     $insert = $this->Mcrud->tambah('anak_kos', $userData);
        
    //     if($insert){

    //         $data = array(
    //             'status_kamar' => 1, // Set status to 1 (sudah diisi)
    //         );
    //         $update = $this->Mcrud->ubah('kamar', $data, array('id_kamar' => $id_kamar));
        
    //         if($update){
    //             // Set the response and exit
    //             $this->response([
    //                 'success' => TRUE,
    //                 'message' => 'Berhasil.',
    //                 'data' => $userData
    //             ], REST_Controller::HTTP_OK);
    //         }else{
    //             $this->response([
    //                 'status' => FALSE,
    //                 'message' => 'Failed to update status room.'
    //             ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    //         }
            
    //     }else{
    //         // Set the response and exit
    //         $this->response([
    //             'success' => FALSE,
    //             'message' => "Gagal ! Coba lagi."
    //         ], REST_Controller::HTTP_BAD_REQUEST);
    //     }
    // }

    public function add_post() {
        // Get the post data
        $id_kamar = strip_tags($this->post('id_kamar'));
        $nama = strip_tags($this->post('nama'));
        $gender = strip_tags($this->post('gender'));
        $kode = strip_tags($this->post('kode'));
        $kontak = strip_tags($this->post('kontak'));
        $alamat = strip_tags($this->post('alamat'));
        $tgl_masuk = strip_tags($this->post('tgl_masuk'));
        $foto = strip_tags($this->post('foto'));
    
        // Validate the post data
        $userData = array(
            'id_kamar' => $id_kamar,
            'nama' => $nama,
            'gender' => $gender,
            'kode' => $kode,
            'kontak' => $kontak,
            'alamat' => $alamat,
            'tgl_masuk' => $tgl_masuk,
            'password' => '123',
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
    
        // Insert data to anak_kos table
        $insert = $this->Mcrud->tambah('anak_kos', $userData);
    
        if($insert){
            // Get the last inserted id from anak_kos table
            $id_anak_kos = $this->db->insert_id();
    
            // Insert data to penghuni table
            $penghuniData = array(
                'id_anak_kos' => $id_anak_kos,
                'id_kamar' => $id_kamar
            );
            $insertPenghuni = $this->Mcrud->tambah('penghuni', $penghuniData);
    
            if($insertPenghuni){
                // Update the status of the room
                $data = array(
                    'status_kamar' => 1, // Set status to 1 (sudah diisi)
                );
                $update = $this->Mcrud->ubah('kamar', $data, array('id_kamar' => $id_kamar));
    
                if($update){
                    // Set the response and exit
                    $this->response([
                        'success' => TRUE,
                        'message' => 'Berhasil.',
                        'data' => $userData
                    ], REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Failed to update status room.'
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                $this->response([
                    'success' => FALSE,
                    'message' => "Failed to insert penghuni data."
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Gagal ! Coba lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    

    public function edit_post() {
        // Get the post data
         $id_anak_kos = strip_tags($this->post('id_anak_kos'));
         $id_kamar = strip_tags($this->post('id_kamar'));
         $nama = strip_tags($this->post('nama'));
         $gender = strip_tags($this->post('gender'));
         $kode = strip_tags($this->post('kode'));
         $kontak = strip_tags($this->post('kontak'));
         $alamat = strip_tags($this->post('alamat'));
         $tgl_masuk = strip_tags($this->post('tgl_masuk'));
         $foto = strip_tags($this->post('foto'));

          // Validate the post data
          $userData = array(
            'id_kamar' => $id_kamar,
            'nama' => $nama,
            'gender' => $gender,
            'kode' => $kode,
            'kontak' => $kontak,
            'tgl_masuk' => $tgl_masuk,
            'alamat' => $alamat,
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
			$rfoto = $this->Mcrud->getanakkosbyid($id_anak_kos);
			foreach ($rfoto->result() as $row) {
				$gambar = $row->foto;
			}
			if($gambar!="")$this->Mcrud->deleteFile($gambar,"assets/image/anak_kos");
         }

         
        
        $insert = $this->Mcrud->ubah('anak_kos', $userData,"id_anak_kos",$id_anak_kos);
        
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

    public function delete_delete($id) {
        $gambar = "";
        $rfoto = $this->Mcrud->getanakkosbyid($id);
    
        // Check if $rfoto is an object and contains the expected property
        if (is_object($rfoto) && isset($rfoto->foto)) {
            $gambar = $rfoto->foto;
        }
    
        // Delete the file if it exists
        if ($gambar != "") {
            $this->Mcrud->deleteFile($gambar, "assets/image/anak_kos");
        }
    
        // Prepare the data for deletion
        $data = "id_anak_kos='$id'";


        $kamar_anak_kos = $this->Mcrud->getIdKamarByIdAnakKos($id);
        $status_kamar = array(
                'status_kamar' => 0, // Set status to 0 (kamar kembali kosong)
            );
        $update = $this->Mcrud->ubah('kamar', $status_kamar, array('id_kamar' => $kamar_anak_kos->row()->id_kamar));

        
        
        if ($update) {
            $hapus = $this->Mcrud->hapus('anak_kos', $data);

            if ($hapus) {
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

            
        } else {
            // Set the response and exit
            $this->response([
                'success' => FALSE,
                'message' => "Gagal ! Coba lagi."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}