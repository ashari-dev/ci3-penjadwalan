<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_Semester");
		$this->load->model("M_Jurusan");
		$this->load->model("M_Mapel");
		$this->load->model("M_Kelas");
		$this->load->model("M_Penjadwalan3");
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
        $data['aside']='semester_bar';
        $this->load->view('head',$data);   
        $this->load->view('semester');   
        $this->load->view('footer');   
	}
	
	public function cek_semester(){
		$result = $this->M_Semester->cek_semester();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_semester(){
		
	        $nama= $this->input->post('nama');
	        $result= $this->M_Semester->simpan_semester($nama);
	        echo json_encode($result);
		}
		
	public function detail_semester(){
		$result = $this->M_Semester->detail_semester();
		echo json_encode($result);
	}
	
	public function semua_semester(){
		$result = $this->M_Semester->semua_semester();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Semester->edit_semester($id);
		echo json_encode($result);
	}
	
	public function get_semester(){
		$result = $this->M_Semester->get_semester();
		echo json_encode($result);
	}

	public function hapus_semester($id){

			$delete = $this->M_Semester->hapus_semester($id);			
			echo json_encode($delete);
	}	
	
	
}
?>