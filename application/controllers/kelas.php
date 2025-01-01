<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
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
        $data['aside']='kelas_bar';
        $this->load->view('head',$data);   
        $this->load->view('kelas');   
        $this->load->view('footer');   
	}
	
	public function cek_kelas(){
		$result = $this->M_Kelas->cek_kelas();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_kelas(){
		
	        $nama= $this->input->post('nama');
	        $result= $this->M_Kelas->simpan_kelas($nama);
	        echo json_encode($result);
		}
		
	public function detail_kelas(){
		$result = $this->M_Kelas->detail_kelas();
		echo json_encode($result);
	}
	
	public function semua_kelas(){
		$result = $this->M_Kelas->semua_kelas();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Kelas->edit_kelas($id);
		echo json_encode($result);
	}

	public function hapus_kelas($id){

			$delete = $this->M_Kelas->hapus_kelas($id);			
			echo json_encode($delete);
	}	
	
	
}
?>