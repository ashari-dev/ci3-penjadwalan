<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_Mapel");
		$this->load->model("M_User");
		$this->load->model("M_Prodi");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
		
		
        $data['aside']='matkul_bar';
        $this->load->view('head',$data);   
        $this->load->view('mapel');   
        $this->load->view('footer');   
	}
	
	public function cek_mapel($id){
		$result = $this->M_Mapel->cek_mapel($id);
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_mapel_awal(){
		$result = $this->M_Mapel->cek_mapel_awal();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_mapel(){
		
	        $kode_matkul= $this->input->post('kode_matkul');
	        $nama= $this->input->post('nama');
	        $jenis= $this->input->post('kategori');	
	        $semester= $this->input->post('semester_tipe');
	        $jumlah_jam= $this->input->post('jumlah_jam');
	        $prodi= $this->input->post('prodi');
			
	        $result= $this->M_Mapel->simpan_mapel($kode_matkul,$nama,$jumlah_jam,$semester,$jenis,$prodi);
	        echo json_encode($result);
		}
		
	public function detail_mapel(){
		$result = $this->M_Mapel->detail_mapel();
		echo json_encode($result);
	}
	
	public function get_mapel(){
		$result = $this->M_Mapel->get_mapel();
		echo json_encode($result);
	}
	
	public function jenis_mapel(){
		$result = $this->M_Mapel->jenis_mapel();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Mapel->edit_mapel($id);
		echo json_encode($result);
	}

	public function hapus_mapel($id){

			$delete = $this->M_Mapel->hapus_mapel($id);			
			echo json_encode($delete);
	}	
	
	
}
?>