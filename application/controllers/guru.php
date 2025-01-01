<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_Mapel");
		$this->load->model("M_Ruang");
		$this->load->model("M_User");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
		
		$data['aside']='guru_bar';
        $this->load->view('head',$data);   
        $this->load->view('guru');   
        $this->load->view('footer');   
	}
	
	public function cek_guru($id){
		$result = $this->M_Guru->cek_guru($id);
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_guru_awal(){
		$result = $this->M_Guru->cek_guru_awal();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_guru(){
		
	        $nama= $this->input->post('nama');
	        $alamat= $this->input->post('alamat');
	        $telepon= $this->input->post('telepon');
	        $nip= $this->input->post('nip');
	        $status= $this->input->post('status');
			
	        $result= $this->M_Guru->simpan_guru($nama,$alamat,$telepon,$nip,$status);
	        echo json_encode($result);
		}
		
	public function detail_guru(){
		$result = $this->M_Guru->detail_guru();
		echo json_encode($result);
	}
	
	public function semua_guru(){
		$result = $this->M_Guru->semua_guru();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Guru->edit_guru($id);
		echo json_encode($result);
	}

	public function hapus_guru($id){

			$delete = $this->M_Guru->hapus_guru($id);			
			echo json_encode($delete);
	}	
	
	
}
?>