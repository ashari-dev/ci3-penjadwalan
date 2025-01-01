<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jam extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Jam");
		$this->load->model("M_Guru");
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
        $data['aside']='jam_bar';
        $this->load->view('head',$data);   
        $this->load->view('jam');   
        $this->load->view('footer');   
	}
	
	public function cek_jam(){
		$result = $this->M_Jam->cek_jam();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_jam(){
		
	        $range_jam= $this->input->post('range_jam');
	        
	        $result= $this->M_Jam->simpan_jam($range_jam);
	        echo json_encode($result);
		}
		
	public function detail_jam(){
		$result = $this->M_Jam->detail_jam();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Jam->edit_jam($id);
		echo json_encode($result);
	}

	public function hapus_jam($id){

			$delete = $this->M_Jam->hapus_jam($id);			
			echo json_encode($delete);
	}	
	
	
}
?>