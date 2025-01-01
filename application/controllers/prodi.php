<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_Prodi");
		$this->load->model("M_Jurusan");
		$this->load->model("M_Mapel");
		$this->load->model("M_Kelas");
		$this->load->model("M_Pengampu");
		$this->load->model("M_User");
		$this->load->model("M_Tahun");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
        $data['aside']='prodi_bar';
        $this->load->view('head',$data);   
        $this->load->view('prodi');   
        $this->load->view('footer');   
	}
	
	public function cek_prodi($id){
		$result = $this->M_Prodi->cek_prodi($id);
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_prodi_awal(){
		$result = $this->M_Prodi->cek_prodi_awal();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_prodi(){
		
	        $nama= $this->input->post('nama');
	        $kode_jurusan= $this->input->post('jurusan');
	        $result= $this->M_Prodi->simpan_prodi($nama,$kode_jurusan);
	        echo json_encode($result);
		}
		
	public function detail_prodi(){
		$result = $this->M_Prodi->detail_prodi();
		echo json_encode($result);
	}
	
	public function semua_prodi(){
		$result = $this->M_Prodi->semua_Prodi();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Prodi->edit_prodi($id);
		echo json_encode($result);
	}

	public function hapus_prodi($id){

			$delete = $this->M_Prodi->hapus_prodi($id);			
			echo json_encode($delete);
	}	
	
	
}
?>