<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil_Model extends CI_Model {
    
    public function get_id($id){
        return $this->db->query("SELECT * from pengguna where id_pengguna = '$id'");
    }

    public function get_(){
        return $this->db->query("SELECT * from pengguna ");
    }

    function ubah($tabel="",$data="",$where="",$id=""){

        $this->db->where($where, $id);
        return $this->db->update($tabel, $data);
    }

}