<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		
		
		$this->load->helper(array('url','download'));
		
		
	}
	public function index()
	{	
		if($this->session->userdata('logged_in')==false) redirect('admin/index');
        $data['aside']='dashboard_bar';
        $this->load->view('head',$data);   
        $this->load->view('dashboard');   
        $this->load->view('footer');   
	}
	
	
	
	
}
?>