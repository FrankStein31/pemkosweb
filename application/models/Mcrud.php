<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcrud extends CI_Model {

	//GET
	
	
	public function getkos()
	{
		$abk = $this->db->query("SELECT * FROM kos");
	
		return $abk;
	}

	public function getanakkos()
	{
		$abk = $this->db->query("SELECT *, a.kode as kode, b.kode as kode_kamar, a.foto as foto, b.foto as foto_kamar, a.gender as gender  FROM anak_kos a LEFT JOIN kamar b ON a.id_kamar = b.id_kamar order by a.id_anak_kos desc");
	
		return $abk;
	}

	public function searchanakkos($id, $keyword)
	{
		$abk = $this->db->query("SELECT * FROM anak_kos WHERE nama like '%$keyword%' order by id_anak_kos desc");
		return $abk;
	}

	public function getAnakKosById($id)
	{
		$query = $this->db->query("SELECT * FROM anak_kos WHERE id_anak_kos = ?", array($id));
		
		if ($query->num_rows() == 1) {
			return $query->row(); // Mengembalikan satu baris data sebagai objek
		} else {
			return null; // atau sesuaikan dengan logika Anda untuk penanganan jika data tidak ditemukan
		}
	}

	public function getBillByFilter($status, $selectedMonth, $selectedYear) {
		$this->db->select('*, b.kode as kode, c.kode as kode_kamar, b.foto as foto');
		$this->db->from('bill a');
		$this->db->join('anak_kos b', 'a.id_anak_kos = b.id_anak_kos');
		$this->db->join('kamar c', 'b.id_kamar = c.id_kamar', 'left');
		$this->db->order_by('a.tgl_bill', 'asc');
	
		if ($status !== 'all') {
			$this->db->where('a.status', $status === 'lunas' ? 1 : 0);
		}
	
		$this->db->where('MONTH(a.tgl_bill)', $selectedMonth);
		$this->db->where('YEAR(a.tgl_bill)', $selectedYear);
	
		return $this->db->get();
	}
	
	


	public function getIdKamarByIdAnakKos($id)
	{
		$kamar = $this->db->query("SELECT * FROM anak_kos WHERE id_anak_kos = '$id' ");
		
		return $kamar;
	}


	// public function getkamar()
	// {
	// 	$kamar = $this->db->query("SELECT * FROM kamar a join kos b ON a.id_kos = b.id_kos order by a.id_kamar desc");
	// 	return $kamar;
	// }
	public function getkamar()
	{
		$query = "
			SELECT a.*, b.*, p.id_anak_kos, ak.nama AS nama_anak_kos 
			FROM kamar a 
			JOIN kos b ON a.id_kos = b.id_kos 
			LEFT JOIN penghuni p ON a.id_kamar = p.id_kamar 
			LEFT JOIN anak_kos ak ON p.id_anak_kos = ak.id_anak_kos 
			ORDER BY a.id_kamar DESC
		";
		$kamar = $this->db->query($query);
		return $kamar;
	}


	public function getkamarbyid($id)
	{
		$kamar = $this->db->query("SELECT * FROM kamar WHERE id_kamar = '$id' ");
		
		return $kamar;
	}

	public function searchkamar($keyword)
	{
		$abk = $this->db->query("SELECT * FROM kamar  WHERE nama like '%$keyword%' order by id_kamar desc");
		return $abk;
	}



	public function getBill()
	{
		$data = $this->db->query("SELECT *, b.kode as kode, c.kode as kode_kamar, b.foto as foto FROM bill a JOIN anak_kos b ON a.id_anak_kos = b.id_anak_kos LEFT JOIN kamar c ON b.id_kamar = c.id_kamar order by a.tgl_bill asc");
	
		return $data;
	}

	public function getBillById($id)
	{

		$query = $this->db->query("SELECT * FROM bill WHERE id_bill = '$id'");
		return $query->row(); // Menggunakan row() untuk mengembalikan satu baris hasil query
	}

	public function getBillByIdAnakKos($id)
	{
		$query = $this->db->query("SELECT *, b.kode as kode, c.kode as kode_kamar, b.foto as foto 
			FROM bill a 
			JOIN anak_kos b ON a.id_anak_kos = b.id_anak_kos 
			LEFT JOIN kamar c ON b.id_kamar = c.id_kamar 
			WHERE a.id_anak_kos = '$id' 
			ORDER BY a.tgl_bill asc
		");
		return $query->result();

	}



	public function getBillByMonth($bulan, $tahun)
	{
		$data = $this->db->query("SELECT *, b.kode as kode, c.kode as kode_kamar, b.foto as foto FROM bill a JOIN anak_kos b ON a.id_anak_kos = b.id_anak_kos  LEFT JOIN kamar c ON b.id_kamar = c.id_kamar WHERE MONTH(tgl_bill) = $bulan AND YEAR(tgl_bill) = $tahun order by a.tgl_bill asc");
	
		return $data;
	}

	public function getBillAnakKosBaru($bulan, $tahun)
	{
		$data = $this->db->query("SELECT *, a.kode as kode, b.kode as kode_kamar, a.foto as foto, b.foto as foto_kamar, a.gender as gender  FROM anak_kos a JOIN kamar b ON a.id_kamar = b.id_kamar 
		WHERE a.id_anak_kos NOT IN (
			SELECT id_anak_kos FROM bill WHERE MONTH(tgl_bill) = $bulan AND YEAR(tgl_bill) = $tahun
		) order by a.tgl_masuk desc");
	
		return $data;
	}

	public function getpengaduanbyuserid($id)
	{
		$pengaduan = $this->db->query("SELECT * FROM pengaduan a join jenis_keluhan b on a.id_jenis_keluhan = b.id_jenis_keluhan where id_pengguna = '$id'");
		return $pengaduan;
	}

	public function getadmin()
	{
		$admin = $this->db->query('SELECT*FROM admin order by id_admin desc');
		return $admin;
	}

	
	
	
	//OPERATION
	public function tambah($tabel, $data){
		$add=$this->db->insert($tabel, $data);

		return $add;
	}

	function ubah($tabel="",$data="",$where="",$id=""){

		$this->db->where($where, $id);
		return $this->db->update($tabel, $data);
	}

	public function hapus($tabel, $id){
		$this->db->query("DELETE FROM $tabel where $id");
		return $this->db->affected_rows();
	}

	public function update($tabel, $data, $id){
		$this->db->query("UPDATE $tabel set $data where $id");
		return $this->db->affected_rows();
	}

	function uploadGambar($nama_file='',$folder='') {
		$this->pathgambar= realpath(APPPATH . "../$folder");
		$config = array(
	'allowed_types' => 'jpg|png|gif|jpeg',
			'upload_path' => $this->pathgambar
		);
		$this->load->library('upload', $config);
		$this->upload->do_upload($nama_file);
		$file_data = $this->upload->data();
		$nama_file = $file_data['file_name'];
		return $nama_file;
	}

	function deleteFile($namagambar='',$folder=''){
		$this->pathgambar = realpath(APPPATH . "../$folder");
		unlink($this->pathgambar."/".$namagambar);
	}


}
