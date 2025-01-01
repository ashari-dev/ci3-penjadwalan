<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hari extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Jam");
		$this->load->model("M_Guru");
		$this->load->model("M_Hari");
		$this->load->model("M_User");
		$this->load->model("M_Mapel");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
		$data['aside']='hari_bar';
        $this->load->view('head',$data);   
        $this->load->view('hari');   
        $this->load->view('footer');   
	}
	
	public function cek_hari(){
		$result = $this->M_Hari->cek_hari();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_hari(){
		
	        $nama= $this->input->post('nama');
	        
	        $result= $this->M_Hari->simpan_hari($nama);
	        echo json_encode($result);
		}
		
	public function detail_hari(){
		$result = $this->M_Hari->detail_hari();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Hari->edit_hari($id);
		echo json_encode($result);
	}

	public function hapus_hari($id){

			$delete = $this->M_Hari->hapus_hari($id);			
			echo json_encode($delete);
	}	
	
	
}
?>