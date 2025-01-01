<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengampu extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Jam");
		$this->load->model("M_Waktu_Tidak_Bersedia");
		$this->load->model("M_Kelas");
		$this->load->model("M_Prodi");
		$this->load->model("M_Jurusan");
		$this->load->model("M_Semester");
		$this->load->model("M_Pengampu");
		$this->load->model("M_Tahun");
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
	
	function index($semester_tipe = null , $tahun_akademik = null, $prodi = null){	
		$data = array();
		$data['ses_nama'] = $this->session->userdata('ses_nama');
		$data['ses_level'] = $this->session->userdata('ses_level');
		/*
			jika null maka
				jika session ada maka gunakan session
				jika session null maka default
			else
				ubah session
		*/
		
		//echo $this->session->userdata('pengampu_semester_tipe');
		//echo $this->session->userdata('pengampu_tahun_akademik');
		
		
		if(!$this->session->userdata('pengampu_semester_tipe') && !$this->session->userdata('tahun_akademik') && !$this->session->userdata('prodi1')){
			$this->session->set_userdata('pengampu_semester_tipe',1);
			$this->session->set_userdata('tahun_akademik',7);
			$this->session->set_userdata('prodi1','0');
		}
		
		
		if($semester_tipe == null && $tahun_akademik == null && $prodi == null){
			$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
			$tahun_akademik = $this->session->userdata('tahun_akademik');
			$prodi = $this->session->userdata('prodi1');
		}else{
			
			$this->session->set_userdata('pengampu_semester_tipe',$semester_tipe);
			$this->session->set_userdata('tahun_akademik',$tahun_akademik);
			$this->session->set_userdata('prodi1',$prodi);
			
			$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
			$tahun_akademik = $this->session->userdata('tahun_akademik');
			$prodi = $this->session->userdata('prodi1');
		}
		
		
		if($prodi==0){
        $data['rs_pengampu'] = $this->M_Pengampu->get($semester_tipe,$tahun_akademik);
		}
		else{
		$data['rs_pengampu'] = $this->M_Pengampu->get_perprodi($semester_tipe,$tahun_akademik,$prodi);
		}
		
		$data['semester_a'] = $semester_tipe;
		$data['tahun_a'] = $tahun_akademik;
		$data['prodi'] = $prodi;
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		
		//$data['semester_tipe'] = $semester_tipe;
		//$data['tahun_akademik'] = $tahun_akademik;		
		
		
		$datas['aside']='pengampu_bar';
        $this->load->view('head',$datas);   
        $this->load->view('pengampu',$data);   
        $this->load->view('footer');   		
		
	}
	
	public function simpan_edit($id){
		
			$result= $this->M_Pengampu->edit_pengampu($id);
		
		echo json_encode($result);
	}
	
	function pengampu_search(){
		$search_query = $this->input->post('search_query');
		$semester_tipe = $this->input->post('semester_tipe');
		$tahun_akademik  = $this->input->post('tahun_akademik');
		$data['rs_pengampu'] = $this->M_Pengampu->get_search($search_query, $semester_tipe,$tahun_akademik);
		$data['page_title'] = 'Cari Pengampu';
		$data['page_name'] = 'pengampu';	
		$data['search_query'] = $search_query;
		$data['semester_tipe'] = $semester_tipe;
		$data['tahun_akademik'] = $tahun_akademik;
		$data['start_number'] = 0;
		$this->load->view('head');   
		$result=$this->db->insert('pengampu',$data);
        $this->load->view('pengampu',$data);   
        $this->load->view('footer');   		
	}
	
	public function simpan_pengampu(){
		
			$result= $this->M_Pengampu->simpan_pengampu();
		
		echo json_encode($result);
	}
	
	public function detail_pengampu(){
		$result = $this->M_Pengampu->detail_pengampu();
		echo json_encode($result);
	}
	
	public function hapus_pengampu($id){

			$delete = $this->M_Pengampu->hapus_pengampu($id);			
			echo json_encode($delete);
	}	
}
?>