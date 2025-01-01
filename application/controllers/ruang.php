<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_User");
		$this->load->model("M_Mapel");
		$this->load->model("M_Jurusan");
		$this->load->model("M_Prodi");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
		$semua = $this->M_Ruang->semua_ruang();
		$i=0;
		foreach($semua as $s){
		$m='R'.$i;
		
		$data = array(
						'id_ruang' => $m
					);
		$this->db->where('kode', $s->kode);
		$this->db->update('ruang', $data);
		$i++;
		}
        $data['aside']='ruang_bar';
        $this->load->view('head',$data);   
        $this->load->view('ruang');   
        $this->load->view('footer');   
	}
	
	public function cek_ruang($id){
		$result = $this->M_Ruang->cek_ruang($id);
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_ruang_awal(){
		$result = $this->M_Ruang->cek_ruang_awal();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_angka(){
		$lantai= $this->input->post('lantai');
		$msg['success'] = false;
		if(is_numeric($lantai)== true){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_ruang(){
		
	        $nama= $this->input->post('nama');
	        $kapasitas= $this->input->post('kapasitas');
	        $lantai= $this->input->post('lantai');
	        $jenis= $this->input->post('kategori');
	        $kode_jurusan= $this->input->post('jurusan');
			
	        $result= $this->M_Ruang->simpan_ruang($nama,$kapasitas,$jenis,$kode_jurusan,$lantai);
	        echo json_encode($result);
		}
		
	public function detail_ruang(){
		$result = $this->M_Ruang->detail_ruang();
		echo json_encode($result);
	}
	
	public function ruang_perjurusan(){
		$prodi = $this->input->get('p');
		$jurusan = $this->M_Prodi->kode_jurusan($prodi);
		foreach($jurusan as $j);
		$result = $this->M_Ruang->ruang_perjurusan($j->kode_jurusan);
		echo json_encode($result);
	}
	
	public function simpan_edit($id){
		$result = $this->M_Ruang->edit_ruang($id);
		echo json_encode($result);
	}

	public function hapus_ruang($id){

			$delete = $this->M_Ruang->hapus_ruang($id);			
			echo json_encode($delete);
	}	
	
	
}
?>