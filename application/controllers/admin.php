<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Guru");
		$this->load->model("M_User");
		$this->load->model("M_Ruang");
		$this->load->model("M_Admin");
		$this->load->library('pagination');
		$this->load->helper("date");
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{
        $this->load->view('login');   
	}
	
	function login(){
		if($this->session->userdata('logged_in')==TRUE) redirect('dashboard/index');
		
		$email = $_POST['email'];
		$password = md5($_POST['password']);
        
        $cek=$this->M_User->cek_login($email,$password);
		if($cek==true){
			foreach($cek as $a);
				$email=$a->email;
				$password=$a->password;
				$nama=$a->nama;
				$id_admin=$a->kode;
				$this->session->set_userdata(array(
								'email'=>$email,
								'nama'=>$nama,
								'password'=>$password,
								'id'=>$id_admin,
								'logged_in'=>TRUE
								));
				echo "<script>alert('Selamat Datang $nama ');window.location='/jadwal2/index.php/dashboard/index';</script>";
			
        }
		else{
            echo "<script>alert('Email atau password salah');window.location='../admin/index';</script>";
			
        }
		
		
	}
	
	function logout()
	{
    	$this->session->sess_destroy();
    	redirect('admin/index');
	}
	
	public function index2()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
		
		$data['aside']='admin_bar';
        $this->load->view('head',$data);   
        $this->load->view('admin');   
        $this->load->view('footer');   
	}
	
	public function cek_admin($id){
		$result = $this->M_Admin->cek_admin($id);
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function cek_admin_awal(){
		$result = $this->M_Admin->cek_admin_awal();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}
	
	public function simpan_admin(){
		
	        $nama= $this->input->post('nama');
	        $email= $this->input->post('email');
	        $password= md5($this->input->post('password'));
			
	        $result= $this->M_Admin->simpan_admin($email,$nama,$password);
	        echo json_encode($result);
		}
		
	public function detail_admin(){
		$result = $this->M_Admin->detail_admin();
		echo json_encode($result);
	}
	
	public function semua_admin(){
		$result = $this->M_Admin->semua_admin();
		echo json_encode($result);
	}
		
	public function simpan_edit($id){
		$result = $this->M_Admin->edit_admin($id);
		echo json_encode($result);
	}

	public function hapus_admin($id){

			$delete = $this->M_Admin->hapus_admin($id);			
			echo json_encode($delete);
	}	
	
}
?>