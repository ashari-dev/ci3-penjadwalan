<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
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
        $data['aside']='jurusan_bar';
        $this->load->view('head',$data);   
        $this->load->view('jurusan');   
        $this->load->view('footer');   
	}
	
	public function cek_jurusan(){
		$result = $this->M_Jurusan->cek_jurusan();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_jurusan(){
		
	        $nama= $this->input->post('nama');
	        $result= $this->M_Jurusan->simpan_jurusan($nama);
	        echo json_encode($result);
		}
		
	public function detail_jurusan(){
		$result = $this->M_Jurusan->detail_jurusan();
		echo json_encode($result);
	}
	
	public function semua_jurusan(){
		$result = $this->M_Jurusan->semua_jurusan();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Jurusan->edit_jurusan($id);
		echo json_encode($result);
	}

	public function hapus_jurusan($id){

			$delete = $this->M_Jurusan->hapus_jurusan($id);			
			echo json_encode($delete);
	}	
	
	
}
?>