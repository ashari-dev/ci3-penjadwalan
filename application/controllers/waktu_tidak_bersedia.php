<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waktu_Tidak_Bersedia extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Jam2");
		$this->load->model("M_Waktu_Tidak_Bersedia");
		$this->load->model("M_Guru");
		$this->load->model("M_Hari");
		$this->load->model("M_User");
		$this->load->model("M_Mapel");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		$this->load->helper("date");
		define('IS_TEST','FALSE');
		$this->load->helper(array('url','download'));
		
		
	}
	public function index($kode_guru = NULL)
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
        $data = array();
		
		$data['ses_nama'] = $this->session->userdata('ses_nama');
		$data['ses_level'] = $this->session->userdata('ses_level');
		$data['ses_id_guru'] = $this->session->userdata('ses_id_guru');
		if($kode_guru==NULL){
			$kode_guru = $this->db->query("SELECT kode FROM guru ORDER BY nama LIMIT 1")->row()->kode;
		} 
		if ($data['ses_id_guru']!=NULL){
			$kode_guru = $this->session->userdata('ses_id_guru');
		}

		if (array_key_exists('arr_tidak_bersedia', $_POST) && !empty($_POST['arr_tidak_bersedia'])){
			
			
			if(IS_TEST === 'FALSE'){
				$this->db->query("DELETE FROM waktu_tidak_bersedia WHERE kode_guru = $kode_guru");
				
				foreach($_POST['arr_tidak_bersedia'] as $tidak_bersedia) {				
					
					$waktu_tidak_bersedia = explode('-',$tidak_bersedia);				
					$this->db->query("INSERT INTO waktu_tidak_bersedia(kode_guru,kode_hari,kode_jam) VALUES($waktu_tidak_bersedia[0],$waktu_tidak_bersedia[1],$waktu_tidak_bersedia[2])");
				}						
				
				$data['msg'] = 'Data telah berhasil diupdate';			
			}else{
				$data['msg'] = 'WARNING: READ ONLY !';
			}
		}elseif(!empty($_POST['hide_me']) && empty($_POST['arr_tidak_bersedia'])){
			$this->db->query("DELETE FROM waktu_tidak_bersedia WHERE kode_guru = $kode_guru");
			$data['msg'] = 'Data telah berhasil diupdate';					
		}
		
		
		
		$data['rs_guru'] = $this->M_Guru->semua_guru();
		$data['rs_waktu_tidak_bersedia'] = $this->M_Waktu_Tidak_Bersedia->get_by_guru($kode_guru);
		$data['rs_hari']  =$this->M_Hari->semua_hari();
		$data['rs_jam'] = $this->M_Jam2->semua_jam();
		
		
		$data['kode_guru'] = $kode_guru;
		
		$datas['aside']='wts_bar';
        $this->load->view('head',$datas);   
        $this->load->view('waktu_tidak_bersedia',$data);   
        $this->load->view('footer');   
	}
	
	
	
}
?>