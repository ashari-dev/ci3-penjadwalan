<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_Mapel");
		$this->load->model("M_User");
		$this->load->model("M_Tahun");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function tahun_akademik()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
        $data['aside']='tahun_bar';
        $this->load->view('head',$data);   
        $this->load->view('tahun_akademik');   
        $this->load->view('footer');   
	}
	
	public function cek_tahun(){
		$result = $this->M_Tahun->cek_tahun();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function detail_tahun(){
		$result = $this->M_Tahun->detail_tahun();
		echo json_encode($result);
	}
	
	public function semua_tahun(){
		$result = $this->M_Tahun->semua_tahun();
		echo json_encode($result);
	}
	
	public function simpan_tahun(){
		
	        $tahun= $this->input->post('tahun');
	        $result= $this->M_Tahun->simpan_tahun($tahun);
	        echo json_encode($result);
		}
		
		
	public function simpan_edit($id){
		$result = $this->M_Tahun->edit_tahun($id);
		echo json_encode($result);
	}

	public function hapus_tahun($id){

			$delete = $this->M_Tahun->hapus_tahun($id);			
			echo json_encode($delete);
	}	
	
	
}
?>