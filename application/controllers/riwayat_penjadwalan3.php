<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_Penjadwalan3 extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->database();
		$this->load->model("M_Jam");
		$this->load->model("M_Riwayat3");
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
		
		
		if(!$this->session->userdata('pengampu_semester_tipe') && !$this->session->userdata('tahun_akademik') && !$this->session->userdata('prodi')){
			$this->session->set_userdata('pengampu_semester_tipe',1);
			$this->session->set_userdata('tahun_akademik',7);
			$this->session->set_userdata('prodi','0');
		}
		
		
		if($semester_tipe == null && $tahun_akademik == null && $prodi == null){
			$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
			$tahun_akademik = $this->session->userdata('tahun_akademik');
			$prodi = $this->session->userdata('prodi');
		}else{
			
			$this->session->set_userdata('pengampu_semester_tipe',$semester_tipe);
			$this->session->set_userdata('tahun_akademik',$tahun_akademik);
			$this->session->set_userdata('prodi',$prodi);
			
			$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
			$tahun_akademik = $this->session->userdata('tahun_akademik');
			$prodi = $this->session->userdata('prodi');
		}
		
		
		if($prodi==0){
        $data['rs_riwayat'] = $this->M_Riwayat3->get($semester_tipe,$tahun_akademik);
		}
		else{
		$data['rs_riwayat'] = $this->M_Riwayat3->get_perprodi($semester_tipe,$tahun_akademik,$prodi);
		}
		
		$data['semester_a'] = $semester_tipe;
		$data['tahun_a'] = $tahun_akademik;
		$data['prodi'] = $prodi;
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		
		//$data['semester_tipe'] = $semester_tipe;
		//$data['tahun_akademik'] = $tahun_akademik;		
		
		
		$datas['aside']='riwayat_bar';
        $this->load->view('head',$datas);   
        $this->load->view('riwayat_penjadwalan',$data);   
        $this->load->view('footer');   		
		
	}
	
	
	
	function excel_report(){
	
		$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
				$tahun_akademik = $this->session->userdata('tahun_akademik');
				$prodi = $this->session->userdata('prodi');
		if($prodi==0){		
			$query = $this->M_Riwayat3->get($semester_tipe,$tahun_akademik);
		}
		else{
			$query=$this->M_Riwayat3->get_perprodi($semester_tipe,$tahun_akademik,$prodi);
		}	
		if(!$query)
            return false;
		
		// Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
		
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
		 // Field names in the first row
        $fields =  array("hari", "sesi", "jam_kuliah", "nama_mk", "guru", 
						"jumlah_jam", "nama_kelas", "nama_semester", "nama_prodi", "kuota", "nama_jurusan", "ruang", "kapasitas");
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
		
		// Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
		
		$objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
	}
	
	
	public function hapus_jadwal(){
			$semester_tipe = $this->session->userdata('pengampu_semester_tipe');
			$tahun_akademik = $this->session->userdata('tahun_akademik');
			$prodi = $this->session->userdata('prodi');
		
		if($prodi==0){
			$this->M_Riwayat3->hapus_semua_jadwal($semester_tipe,$tahun_akademik);
		}
		else{
			$this->M_Riwayat3->hapus_jadwal($semester_tipe,$tahun_akademik,$prodi);
		}
		
		if($prodi==0){
        $data['rs_riwayat'] = $this->M_Riwayat3->get($semester_tipe,$tahun_akademik);
		}
		else{
		$data['rs_riwayat'] = $this->M_Riwayat3->get_perprodi($semester_tipe,$tahun_akademik,$prodi);
		}
		
		$data['semester_a'] = $semester_tipe;
		$data['tahun_a'] = $tahun_akademik;
		$data['prodi'] = $prodi;
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		$data['hapus'] = "Berhasil menghapus jadwal";	
		//$data['semester_tipe'] = $semester_tipe;
		//$data['tahun_akademik'] = $tahun_akademik;		
		
		
		$datas['aside']='riwayat_bar';
        $this->load->view('head',$datas);   
        $this->load->view('riwayat_penjadwalan',$data);   
        $this->load->view('footer');   		
	}
}
?>