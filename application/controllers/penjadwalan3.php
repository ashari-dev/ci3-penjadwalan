<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjadwalan3 extends CI_Controller {

private $PRAKTIKUM = 'PRAKTIKUM';
    private $TEORI = 'TEORI';
    private $Normal = 'Normal';
    private $LABORATORIUM = 'LABORATORIUM';
    
    private $kap=true;
    private $kode_pengampu;
    private $jenis_semester;
    private $tahun_akademik;
    private $populasi;
    private $crossOver;
    private $mutasi;
    
    private $pengampuu = array();
    private $pengampu = array();
    private $individu = array(array(array()));
    private $sks = array();
    private $guru = array();
    private $status = array();
    private $status_dosen = array();
	private $prodi = array();
	private $jurusan ;
	private $kelas = array();
	private $semester = array();
	private $kuota_pengampu = array();
	private $ruang_pilihan = array();
    
    private $jam1 = array();
    private $jam2 = array();
    private $jam3 = array();
    private $jam4 = array();
    private $sesi1 = array();
    private $sesi2 = array();
    private $sesi3 = array();
    private $sesi4 = array();
    private $hari = array();
    private $iguru = array();
    private $itersedia = array();
    private $itersimpan = array();
    private $itersimpann = array();
    private $itersediaa = array();
    
    //waktu keinginan guru
    private $waktu_guru = array(array());
    private $waktu_tersedia = array(array());
    private $waktu_tersimpan = array(array());
    private $jenis_mk = array(); //reguler or praktikum
    
	private $kuota_ruangReguler = array();
    private $kuota_ruangLaboratorium = array();
    private $ruangLaboratorium = array();
    private $ruangReguler = array();
    private $logAmbilData;
    private $logInisialisasi;
    
    
    private $induk = array();
    
    //jumat
    private $kode_jumat;
    private $range_jumat = array();
    private $kode_dhuhur;
    private $is_waktu_guru_tidak_bersedia_empty;


	function __construct(){
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->database();
		$this->load->model("M_Jam");
		$this->load->model("M_Waktu_Tidak_Bersedia");
		$this->load->model("M_Kelas");
		$this->load->model("M_Prodi");
		$this->load->model("M_Jurusan");
		$this->load->model("M_Semester");
		$this->load->model("M_Penjadwalan3");
		$this->load->model("M_Pengampu");
		$this->load->model("M_Tahun");
		$this->load->model("M_Guru");
		$this->load->model("M_Hari");
		$this->load->model("M_User");
		$this->load->model("M_Mapel");
		$this->load->model("M_Riwayat3");
		$this->load->model("M_Ruang");
		$this->load->library('pagination');
		
		$this->load->helper("date");
		define('IS_TEST','FALSE');
		$this->load->helper(array('url','download','security'));
		
		
	}
	
	function index(){
	if($this->session->userdata('logged_in')==false) redirect('admin/index');
		
		$data = array();

		if(!empty($_POST)){
			$this->form_validation->set_rules('semester_tipe','Semester','xss_clean|required');
			$this->form_validation->set_rules('tahun_akademik','Tahun Akademik','xss_clean|required');
			$this->form_validation->set_rules('jumlah_populasi','Jumlah Populiasi','xss_clean|required');
			$this->form_validation->set_rules('probabilitas_crossover','Probabilitas CrossOver','xss_clean|required');
			$this->form_validation->set_rules('probabilitas_mutasi','Probabilitas Mutasi','xss_clean|required');
			$this->form_validation->set_rules('jumlah_generasi','Jumlah Generasi','xss_clean|required');
			
			if($this->form_validation->run() == TRUE){
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;			
				//tempat keajaiban dimulai. SEMANGAAAAAATTTTTTT BANZAIIIIIIIIIIIII !
				
				$jenis_semester = $this->input->post('semester_tipe');
				$prodi = $this->input->post('prodi');
				
				
				$tahun_akademik = $this->input->post('tahun_akademik');
				
				$crossOver = $this->input->post('probabilitas_crossover');
				$mutasi = $this->input->post('probabilitas_mutasi');
				$jumlah_generasi = $this->input->post('jumlah_generasi');
				$data['semester_a'] = $jenis_semester;
				$data['tahun_a'] = $tahun_akademik;
				$data['prodi'] = $prodi;
				$datas['semester_tipe'] = $jenis_semester;
				$datas['tahun_akademik'] = $tahun_akademik;
				
				$datas['probabilitas_crossover'] = $crossOver;
				$datas['probabilitas_mutasi'] = $mutasi;
				$datas['jumlah_generasi'] = $jumlah_generasi;
				
				if($prodi==true){
			    $rs_data = $this->db->query("SELECT  a.kode "
                                    . "FROM pengampu a "
                                    . "LEFT JOIN semester b "
                                    . "ON a.semester = b.kode "
									. "LEFT JOIN tahun_akademik c "
									. "ON a.tahun_akademik = c.kode "
                                    . "WHERE b.semester_tipe = $jenis_semester "
                                    . "      AND a.tahun_akademik = '$tahun_akademik' and a.kode_prodi='$prodi'");
									
				}
				else{
				$rs_data = $this->db->query("SELECT  a.kode "
                                    . "FROM pengampu a "
                                    . "LEFT JOIN semester b "
                                    . "ON a.semester = b.kode "
									. "LEFT JOIN tahun_akademik c "
									. "ON a.tahun_akademik = c.kode "
                                    . "WHERE b.semester_tipe = $jenis_semester "
                                    . "      AND a.tahun_akademik = '$tahun_akademik' ");
				
				}
				if($rs_data->num_rows() == 0){
					
					$data['msg'] = 'Tidak Ada Data dengan Semester dan Tahun Akademik ini <br>Data yang tampil dibawah adalah data dari proses sebelumnya';
					
					//redirect(base_url() . 'web/penjadwalan','reload');
				}else{
					$n=0;
					
					if($rs_data->num_rows() % 2 == 0 ){
						$jumlah_populasi =$rs_data->num_rows();
					}
					else{
						$jumlah_populasi =$rs_data->num_rows() + 1;
					}
					
					$banyak_populasi= intval($rs_data->num_rows()/2);
					
					$e=0;
					$c=0;
					$this->db->query("TRUNCATE TABLE jadwalpelajaran");	
					for($f = 0;$f <= $banyak_populasi;$f++ ){
					$query='asc limit '.$e.',2';
						$mod = intval($rs_data->num_rows() % 2);
						$banyak_populasi= intval($rs_data->num_rows()/2);
						if($f == $banyak_populasi){
							$query='asc limit '.$e.','.$mod;
						}
						
						$this->AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi,$prodi,$query,$e,$mod);
						
						$this->Inisialisai($jumlah_populasi);
						if($this->kap==false){
						$this->db->query("TRUNCATE TABLE jadwalpelajaran");		
							break ;
						}
						
						
						$found = false;
						
						for($i = 0;$i < $jumlah_generasi;$i++ ){
							$fitness = $this->HitungFitness($jumlah_populasi,$prodi);
							
							//if($i == 100){
							//	var_dump($fitness);
							//	exit();
							//}
							
							$this->Seleksi($fitness,$jumlah_populasi);
							$this->StartCrossOver($jumlah_populasi,$crossOver);
							
							$fitnessAfterMutation = $this->Mutasi($jumlah_populasi,$mutasi,$prodi);
							
							for ($j = 0; $j < count($fitnessAfterMutation); $j++){
								//test here
								if($fitnessAfterMutation[$j] == 1){
									
									
									
									$jadwal_kuliah = array(array());
									$jadwal_kuliah = $this->GetIndividu($j);
									
									
									
									for($k = 0; $k < count($jadwal_kuliah);$k++){
										
										$kode_pengampu = intval($jadwal_kuliah[$k][0]);
										$kode_jam = intval($jadwal_kuliah[$k][1]);
										$kode_hari = intval($jadwal_kuliah[$k][2]);
										$kode_ruang = intval($jadwal_kuliah[$k][3]);
										$this->db->query("INSERT INTO jadwalpelajaran(kode_pengampu,kode_jam,kode_hari,kode_ruang) ".
														 "VALUES($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang)");									
										
									}
									
									//var_dump($jadwal_kuliah);
									//exit();
									
									$found = true;
									$this->kap = true;
								}
								
								if($found){break;}
							}
							
							if($found){break;}
						}
						
						$e = $e + 2;
						$c= $c+1;
					}
					
					if ($this->kap==false ){
					foreach($this->M_Penjadwalan3->detail_pengampu($this->kode_pengampu) as $d);
						$data['msg'] = 'Tidak ada kapasitas ruangan yang sesuai dengan kuota matakuliah '.$d->nama_mk.' kelas '.$d->nama_kelas ;
					}
					else if(!$found){
						$data['msg'] = 'Tidak Ditemukan Solusi Optimal';
					}
					else{
					$this->db->query("DELETE FROM jadwalpelajaran  WHERE kode IN
					(SELECT * FROM (SELECT kode FROM jadwalpelajaran GROUP BY kode_pengampu HAVING (COUNT(*) > 1)) AS A);");
					
					$time = microtime();
					$time = explode(' ', $time);
					$time = $time[1] + $time[0];
					$finish = $time;
					$total_time = $finish - $start ;
					$total_menit = round(($total_time / 60), 4) ;
					$data['waktu'] = "Selesai dalam ".$total_menit." menit";	
					}
					
				}
			
			}else{
				$data['msg'] = validation_errors();
			}
		}
		
		
		$data['page_name'] = 'penjadwalan';
		$data['page_title'] = 'Penjadwalan';
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		
			$data['rs_jadwal'] = $this->M_Penjadwalan3->get();
		$datas['aside']='penjadwalan_bar';
		$this->load->view('head',$datas);   
        $this->load->view('penjadwalan',$data);   
        $this->load->view('footer');   		
	}
	
	    public function AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi,$prodi,$query,$e,$mod)
    {		
			
			$this->jenis_semester = $jenis_semester;
			$this->tahun_akademik = $tahun_akademik;
			$this->populasi       = $jumlah_populasi;
			
	
		if($prodi==true){
			$rs_data = $this->db->query("SELECT   a.kode,"
                                    . "       b.jumlah_jam,"
                                    . "       a.kode_guru,"
									. "       a.kode_prodi,"
                                    . "       a.kelas,"
									. "       a.kode_ruang,"
									. "       a.kuota,"
                                    . "       a.semester as kode_sem,"
                                    . "       b.jenis, "
                                    . "       c.kode as kode_kelas, "
                                    . "       c.nama_kelas, "
									. "       d.kode as kode_prod, "
                                    . "       d.nama_prodi, "
									. "       d.kode_jurusan, "
									. "       e.kode as kode_semester, "
                                    . "       e.nama_semester, "
                                    . "       f.status_dosen, "
                                    . "       g.status "
                                    . "FROM pengampu a "
                                    . "LEFT JOIN matapelajaran b "
                                    . "ON a.kode_mk = b.kode "
									. "LEFT JOIN kelas c "
                                    . "ON a.kelas = c.kode "
									. "LEFT JOIN prodi d "
                                    . "ON a.kode_prodi = d.kode "
									. "LEFT JOIN semester e "
                                    . "ON a.semester = e.kode "
									. "LEFT JOIN guru f "
                                    . "ON a.kode_guru = f.kode "
									. "LEFT JOIN status_dosen g "
                                    . "ON f.status_dosen = g.kode "
                                    . "WHERE b.semester = $this->jenis_semester"
                                    . " AND a.tahun_akademik = '$this->tahun_akademik' and a.kode_prodi ='$prodi' order by a.kode $query ");
			
		
           
        }
		else{
		   $rs_data = $this->db->query("SELECT   a.kode,"
                                    . "       b.jumlah_jam,"
                                    . "       a.kode_guru,"
									. "       a.kode_prodi,"
                                    . "       a.kelas,"
									. "       a.kode_ruang,"
									. "       a.kuota,"
                                    . "       a.semester as kode_sem,"
                                    . "       b.jenis, "
                                    . "       c.kode as kode_kelas, "
                                    . "       c.nama_kelas, "
									. "       d.kode as kode_prod, "
                                    . "       d.nama_prodi, "
									. "       d.kode_jurusan, "
									. "       e.kode as kode_semester, "
                                    . "       e.nama_semester, "
									. "       f.status_dosen, "
                                    . "       g.status "
                                    . "FROM pengampu a "
                                    . "LEFT JOIN matapelajaran b "
                                    . "ON a.kode_mk = b.kode "
									. "LEFT JOIN kelas c "
                                    . "ON a.kelas = c.kode "
									. "LEFT JOIN prodi d "
                                    . "ON a.kode_prodi = d.kode "
									. "LEFT JOIN semester e "
                                    . "ON a.semester = e.kode "
									. "LEFT JOIN guru f "
                                    . "ON a.kode_guru = f.kode "
									. "LEFT JOIN status_dosen g "
                                    . "ON f.status_dosen = g.kode "
                                    . "WHERE b.semester = $this->jenis_semester "
                                    . " AND a.tahun_akademik = '$this->tahun_akademik' order by a.kode $query ");
		
		}
        $i = 0;
        foreach ($rs_data->result() as $data) {
            $this->pengampu[$i] = intval($data->kode);
            $this->sks[$i]         = intval($data->jumlah_jam);
            $this->guru[$i]       = intval($data->kode_guru);
            $this->status_dosen[$i]       = intval($data->status_dosen);
            $this->status[$i]       = $data->status;
			$this->prodi[$i]       = intval($data->kode_prodi);
			$this->semester[$i]       = intval($data->kode_sem);
			$this->kelas[$i]       = intval($data->kelas);
			$this->ruang_pilihan[$i]       = intval($data->kode_ruang);
			$this->kuota_pengampu[$i]       = intval($data->kuota);
            $this->jenis_mk[$i]    = $data->jenis;
            $this->jurusan[$i]    = intval($data->kode_jurusan);
            $i++;
        }
		
		
        
		
        //var_dump($this->jenis_mk);
        //exit();
        
        //Fill Array of Jam Variables
        $rs_jam1 = $this->db->query("SELECT * FROM jam2 where sks='1'");
		$b      = 0;
		foreach ($rs_jam1->result() as $data) {
			$this->jam1[$b] = intval($data->kode);
			$this->sesi1[$b] = intval($data->sesi);
			$b++;
		}
		
		$rs_jam2 = $this->db->query("SELECT * FROM jam2 where sks='2'");
		$b      = 0;
		foreach ($rs_jam2->result() as $data) {
			$this->jam2[$b] = intval($data->kode);
			$this->sesi2[$b] = intval($data->sesi);
			$b++;
		}
        
		$rs_jam3 = $this->db->query("SELECT * FROM jam2 where sks='3'");
		$b      = 0;
		foreach ($rs_jam3->result() as $data) {
			$this->jam3[$b] = intval($data->kode);
			$this->sesi3[$b] = intval($data->sesi);
			$b++;
		}
		
		$rs_jam4 = $this->db->query("SELECT * FROM jam2 where sks='4'");
		$b      = 0;
		foreach ($rs_jam4->result() as $data) {
			$this->jam4[$b] = intval($data->kode);
			$this->sesi4[$b] = intval($data->sesi);
			$b++;
		}
		
        //Fill Array of Hari Variables
        $rs_hari = $this->db->query("SELECT kode FROM hari");
        $i       = 0;
        foreach ($rs_hari->result() as $data) {
            $this->hari[$i] = intval($data->kode);
            $i++;
        }
        
        
        //var_dump($this->ruangLaboratorium);
        //exit(0);
        
        $rs_Waktuguru = $this->db->query("SELECT a.kode_guru,".
                                          "CONCAT_WS(':',a.kode_hari,b.sesi) as kode_hari_jam ".
                                          "FROM waktu_tidak_bersedia a
										  LEFT JOIN jam2 b
										  ON a.kode_jam = b.kode");        
        $i             = 0;
		
		foreach ($rs_Waktuguru->result() as $data) {
            $this->iguru[$i]         = intval($data->kode_guru);
            $this->waktu_guru[$i][0] = intval($data->kode_guru);
            $this->waktu_guru[$i][1] = $data->kode_hari_jam;
            $i++;
        }  
		
		if($prodi==true){
						$rs_Waktutersedia = $this->db->query("SELECT a.kode,".		
											  "a.kode_pengampu,".
											  "b.kode,".
											  "b.kode_guru,".
											  "CONCAT_WS(':',a.kode_hari,d.sesi,a.kode_ruang,b.kode_guru) as kode_hari_ruang , ".
											  "c.kode ,".
											  "c.semester_tipe ".
											  "FROM riwayat_penjadwalan a ".
											  "LEFT JOIN pengampu b ".
											  "ON a.kode_pengampu = b.kode ".
											  "LEFT JOIN semester c ".
											  "ON b.semester = c.kode ".
											  "LEFT JOIN jam2 d ".
											  "ON a.kode_jam = d.kode ".
											  "WHERE c.semester_tipe = '$this->jenis_semester' ".
											  " AND b.tahun_akademik = '$this->tahun_akademik' AND b.kode_prodi != '$prodi'");
				$i             = 0;
				foreach ($rs_Waktutersedia->result() as $data) {
					$this->itersedia[$i]         = intval($data->kode_guru);
					$this->itersediaa[$i]         = $data->kode_guru;
					$this->waktu_tersedia[$i][0] = intval($data->kode_guru);
					$this->waktu_tersedia[$i][1] = $data->kode_hari_ruang;
					$i++;
				}  												
		}
		if($prodi==true){
		
		
		
						$rs_Waktutersimpan = $this->db->query("SELECT a.kode,".		
											  "a.kode_pengampu,".
											  "b.kode,".
											  "b.kode_guru,".
											  "CONCAT_WS(':',a.kode_hari,d.sesi,a.kode_ruang,b.semester,b.kelas,b.kode_guru,b.kode_prodi) as kode_hari_ruang , ".
											  "c.kode ,".
											  "c.semester_tipe ".
											  "FROM jadwalpelajaran a ".
											  "LEFT JOIN pengampu b ".
											  "ON a.kode_pengampu = b.kode ".
											  "LEFT JOIN semester c ".
											  "ON b.semester = c.kode ".
											  "LEFT JOIN jam2 d ".
											  "ON a.kode_jam = d.kode ".
											  "WHERE c.semester_tipe = '$this->jenis_semester' ".
											  " AND b.tahun_akademik = '$this->tahun_akademik' AND b.kode_prodi = '$prodi'");
				$i             = 0;
				foreach ($rs_Waktutersimpan->result() as $data) {
					$this->itersimpan[$i]         = intval($data->kode_guru);
					$this->itersimpann[$i]         = $data->kode_guru;
					$this->waktu_tersimpan[$i][0] = intval($data->kode_guru);
					$this->waktu_tersimpan[$i][1] = $data->kode_hari_ruang;
					$i++;
				}  												
		}
		else{
			
						$rs_Waktutersimpan = $this->db->query("SELECT a.kode,".		
											  "a.kode_pengampu,".
											  "b.kode,".
											  "b.kode_guru,".
											  "CONCAT_WS(':',a.kode_hari,d.sesi,a.kode_ruang,b.semester,b.kelas,b.kode_guru,b.kode_prodi) as kode_hari_ruang , ".
											  "c.kode ,".
											  "c.semester_tipe ".
											  "FROM jadwalpelajaran a ".
											  "LEFT JOIN pengampu b ".
											  "ON a.kode_pengampu = b.kode ".
											  "LEFT JOIN semester c ".
											  "ON b.semester = c.kode ".
											  "LEFT JOIN jam2 d ".
											  "ON a.kode_jam = d.kode ".
											  "WHERE c.semester_tipe = '$this->jenis_semester' ".
											  " AND b.tahun_akademik = '$this->tahun_akademik' ");
				$i             = 0;
				foreach ($rs_Waktutersimpan->result() as $data) {
					$this->itersimpan[$i]         = intval($data->kode_guru);
					$this->itersimpann[$i]         = $data->kode_guru;
					$this->waktu_tersimpan[$i][0] = intval($data->kode_guru);
					$this->waktu_tersimpan[$i][1] = $data->kode_hari_ruang;
					$i++;
				}  													
		
		}
        
     
        
    }
    
    
    public function Inisialisai($jumlah_populasi)
    {
        $this->populasi       = $jumlah_populasi;
        $jumlah_pengampu = count($this->pengampu);        
        
        $jumlah_hari = count($this->hari);
        
        $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                
                $sks = $this->sks[$j];

                
                $this->individu[$i][$j][0] = $j;
					
                // Penentuan jam secara acak ketika 1 sks 
                
                if ($sks == 1) {
					$jumlah_jam = count($this->jam1);
                    $this->individu[$i][$j][1] = intval($this->jam1[mt_rand(0, $jumlah_jam - 1)]);
                    
					
                }
                
                // Penentuan jam secara acak ketika 2 sks 
                if ($sks == 2) {
					$jumlah_jam = count($this->jam2);
                    $this->individu[$i][$j][1] = intval($this->jam2[mt_rand(0, $jumlah_jam - 1)]);
                }
                
                // Penentuan jam secara acak ketika 3 sks
                if ($sks == 3) {
					$jumlah_jam = count($this->jam3);
                    $this->individu[$i][$j][1] = intval($this->jam3[mt_rand(0, $jumlah_jam - 1)]);
                }
                
                // Penentuan jam secara acak ketika 4 jam
                if ($sks == 4) {
					$jumlah_jam = count($this->jam4);
                    $this->individu[$i][$j][1] = intval($this->jam4[mt_rand(0, $jumlah_jam - 1)]);
                }
                
                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1); // Penentuan hari secara acak 
                $jurusan=intval($this->jurusan[$j]);
                if ($this->jenis_mk[$j] === $this->TEORI) {
						if($this->ruang_pilihan[$j] == true){
							$this->individu[$i][$j][3] = intval($this->ruang_pilihan[$j]);				
						}
						else if($this->status[$j] != 'Normal'){
							$this->ruangReguler=false;
							$kuota=intval($this->kuota_pengampu[$j]);	
							$rs_RuangReguler = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = '$this->TEORI' and kode_jurusan='$jurusan' and kapasitas >='$kuota' and lantai='1' ");
							$k               = 0;
							if($rs_RuangReguler->num_rows()==0){
							
							$this->kap=false;
							$this->kode_pengampu = $this->pengampu[$j];
								break ;
							}
							foreach ($rs_RuangReguler->result() as $data) {
								$this->ruangReguler[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_reguler = count($this->ruangReguler);
							$this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
						}
						else{
							$this->ruangReguler=false;
							$kuota=intval($this->kuota_pengampu[$j]);	
							$rs_RuangReguler = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE kapasitas >='$kuota' and jenis = '$this->TEORI' and kode_jurusan='$jurusan' ");
							$k               = 0;
							if($rs_RuangReguler->num_rows()==0){
							
							$this->kap=false;
							$this->kode_pengampu = $this->pengampu[$j];
								break ;
							}
							
							foreach ($rs_RuangReguler->result() as $data) {
								$this->ruangReguler[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_reguler = count($this->ruangReguler);
							$this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
						}
					} else if ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
						if($this->ruang_pilihan[$j] == true){
							$this->individu[$i][$j][3] = intval($this->ruang_pilihan[$j]);				
						}
						else if($this->status[$j] != 'Normal' ){
							$this->ruangLaboratorium=false;
							$kuota=intval($this->kuota_pengampu[$j]);	
							$rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = 'LABORATORIUM' and kode_jurusan='$jurusan' and lantai='1' and kapasitas >='$kuota' ");
							$k               = 0;
							
							
								
							if($rs_RuangLaboratorium->num_rows()==0){
							
							$this->kap=false;
							$this->kode_pengampu = $this->pengampu[$j];
								break ;
							}
							foreach ($rs_RuangLaboratorium->result() as $data) {
								$this->ruangLaboratorium[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_lab = count($this->ruangLaboratorium);
							$this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
						}
						else{
							$this->ruangLaboratorium=false;
							$kuota=intval($this->kuota_pengampu[$j]);	
							$rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE kapasitas >='$kuota' and jenis = '$this->LABORATORIUM' and kode_jurusan='$jurusan' ");
							$k               = 0;
							if($rs_RuangLaboratorium->num_rows()==0){
							
							$this->kap=false;
							$this->kode_pengampu = $this->pengampu[$j];
								break ;
							}
							foreach ($rs_RuangLaboratorium->result() as $data) {
								$this->ruangLaboratorium[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_lab = count($this->ruangLaboratorium);
							$this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
						}
					}
					else{}
				
            }
        }
		
    }
    
    private function CekFitness($indv,$prodi)
    {
        $this->kode_jumat     = intval(5);
        $this->range_jumat    = explode('-','6-7');//$hari_jam = explode(':', $this->waktu_guru[$j][1]);
        $this->kode_dhuhur    = intval(6);
		$penalty = 0;
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $hari_jumat = intval($this->kode_jumat);
        $jumat_0 = intval($this->range_jumat[0]);
        $jumat_1 = intval($this->range_jumat[1]);
        
        
        //var_dump($this->range_jumat);
        //exit();
        
        $jumlah_pengampu = count($this->pengampu);
        
        for ($i = 0; $i < $jumlah_pengampu; $i++)
        {
          
          $sks = intval($this->sks[$i]);
          
                    
          $jam_a =  intval($this->individu[$indv][$i][1]);
          $hari_a = intval($this->individu[$indv][$i][2]);
          $ruang_a = intval($this->individu[$indv][$i][3]);
          
          $guru_a = intval($this->guru[$i]);        
          /*
		  $jenis_mk = $this->jenis_mk[$i];
		  if($jenis_mk=='PRAKTIKUM'){
			$jenis_mk='LABORATORIUM';
		  }
		  */
          $kuota = intval($this->kuota_pengampu[$i]);        
          $semester_a = intval($this->semester[$i]);        
          $kelas_a = intval($this->kelas[$i]);        
		  $prodi_a = intval($this->prodi[$i]);        
		  $jurusan=intval($this->jurusan[$i]);
		  
		  /*
		  $cek_ruang = $this->db->query("SELECT * FROM ruang where kode='$ruang_a'");
		  foreach ($cek_ruang->result() as $c);
		  if($this->ruang_pilihan[$i] == 0){
			if($c->kapasitas<$kuota){
				$pilih_ruang= $this->db->query("SELECT * FROM ruang where jenis = '$jenis_mk' and kode_jurusan='$jurusan' and kapasitas >='$kuota'");
				foreach ($pilih_ruang->result() as $p);
				$this->individu[$indv][$i][3]=$p->kode;
				$ruang_a = intval($this->individu[$indv][$i][3]);
			}
		  }
		  */
			
			
			$rs_jam1 = $this->db->query("SELECT * FROM jam2 where kode='$jam_a'");
			foreach ($rs_jam1->result() as $data); 
			$sesiJam_a = $data->sesi;
			
			if($sks==2 || $sks==3 || $sks==4){	
			  if(($hari_a  + 1) != $hari_jumat){
				if($sesiJam_a==5){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='3'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=3;	
				}
				if($sesiJam_a==6){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='4'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=4;	
				}
			  }
			}
			
			  if(($hari_a  + 1) == $hari_jumat){
				if($sesiJam_a==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=1;	
				}
				if($sesiJam_a==4){
					if($sks==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=1;	
					}
					else{
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='2'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=2;	
					}	
				}
				if($sesiJam_a==2){
					if($sks==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->result() as $q);
						$this->individu[$indv][$i][1]= $q->kode;
						$sesiJam_a=1;	
					}	
				}
			  }
			
            for ($j = 0; $j < $jumlah_pengampu; $j++) {                 
				
                    
				$jam_b =  intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);
          
                $guru_b = intval($this->guru[$j]);
                $semester_b = intval($this->semester[$j]);
                $kelas_b = intval($this->kelas[$j]);
                $prodi_b = intval($this->prodi[$j]);
                $rs_jam2 = $this->db->query("SELECT * FROM jam2 where kode='$jam_b'");
				foreach ($rs_jam2->result() as $data1); 
				$sesiJam_b = $data1->sesi;
                //1.bentrok ruang dan waktu dan 3.bentrok guru
                
                //ketika pemasaran matapelajaran sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;
                
                //#region Bentrok Ruang dan Waktu
                //Ketika jam,hari dan ruangnya sama, maka penalty + satu
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
					if (
					$sesiJam_a == $sesiJam_b &&
						$hari_a == $hari_b &&
						$ruang_a == $ruang_b)
					{
						$penalty += 1;
					}
				}
                
				
				//#region Bentrok Ruang dan Waktu
                //Ketika jam,hari dan semester sama, maka penalty + satu
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
						if (
						$prodi_a == $prodi_b &&
						$sesiJam_a == $sesiJam_b &&
						$hari_a == $hari_b &&
						$kelas_a == $kelas_b &&
						$semester_a == $semester_b)
						{
							$penalty += 1;
						}
					}
					
                
                //______________________BENTROK guru
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
					if (
					//ketika jam sama
						$sesiJam_a == $sesiJam_b &&
					//dan hari sama
						$hari_a == $hari_b && 
					//dan gurunya sama
						$guru_a == $guru_b)
					{
					  //maka...
					  $penalty += 1;
					}
				}            
            }
            //#endregion
            
            //#region Bentrok dengan Waktu Keinginan guru
            //Boolean penaltyForKeinginanguru = false;
            
            $jumlah_waktu_tidak_bersedia = count($this->iguru);
            
            for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++)
            {
                if ($guru_a == $this->iguru[$j] )
                {
                    $hari_jam = explode(':', $this->waktu_guru[$j][1]);
                    
                    if ($sesiJam_a == $hari_jam[1] &&
                        $this->hari[$hari_a] == $hari_jam[0])
                    {                    
                        $penalty += 1;                        
                    }
                }                            
				
            }
			//#endregion
            
            //#region Bentrok dengan Waktu Yang Sudah Terpakai
			if($prodi==true){
				$jumlah_waktu_tersedia = count($this->itersedia);
				
				for ($j = 0; $j < $jumlah_waktu_tersedia; $j++)
				{
					
						$hari_ruang = explode(':', $this->waktu_tersedia[$j][1]);
						
						if ($guru_a == $hari_ruang[3] &&
							$this->hari[$hari_a]  == $hari_ruang[0] &&
							$sesiJam_a == $hari_ruang[1])
						{
							 $penalty += 1;	   
						 }
						
						if ($this->hari[$hari_a]   == $hari_ruang[0]  && $ruang_a  == $hari_ruang[2])
						{   
							if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
							{
							   if ($sesiJam_a == $hari_ruang[1]  )
							   {	   
								   $penalty += 1;
							   }
							}                    
						}					 
					 
				}
			}
			//#endregion
			
			//#region Bentrok dengan Waktu Yang Sudah Tersimpan di tabel jadwalpelajaran
			
			$jumlah_waktu_tersimpan = count($this->itersimpan);
            
            for ($j = 0; $j < $jumlah_waktu_tersimpan; $j++)
            {
                
                $hari_ruang = explode(':', $this->waktu_tersimpan[$j][1]);
					
				if ($guru_a == $hari_ruang[5] &&
					$this->hari[$hari_a]  == $hari_ruang[0] &&
					$sesiJam_a == $hari_ruang[1])
                {
					 $penalty += 1;	   
                 }
				 
				 if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
				 {
					if ( $prodi_a == $hari_ruang[6] &&
						$sesiJam_a == $hari_ruang[1]  &&
						$this->hari[$hari_a]  == $hari_ruang[0]&&
						$kelas_a == $hari_ruang[4] &&
						$semester_a == $hari_ruang[3])
					{
						$penalty += 1;
					}
				}
				    
					if ($this->hari[$hari_a]   == $hari_ruang[0]  && $ruang_a  == $hari_ruang[2])
                    {   
                        if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
						{
						   if ($sesiJam_a == $hari_ruang[1])
						   {
							   $penalty += 1;
						   }
						}
                    }
				}
			
			//#endregion
			
        }      
        
        $fitness = floatval(1 / (1 + $penalty));  
        
        return $fitness;        
    }
    
    public function HitungFitness($jumlah_populasi,$prodi)
    {
	
		$this->populasi       = $jumlah_populasi;
        //hard constraint
        //1.bentrok ruang dan waktu
        //2.bentrok sholat jumat
        //3.bentrok guru
        //4.bentrok keinginan waktu guru 
        //5.bentrok waktu dhuhur 
        //=>6.praktikum harus pada ruang lab {telah ditetapkan dari awal perandoman
        //    bahwa jika praktikum harus ada pada LAB dan mata kuliah reguler harus 
        //    pada kelas reguler
        
        
        //soft constraint //TODO
        //$fitness = array();
        
        for ($indv = 0; $indv < $this->populasi; $indv++)
        {            
            $fitness[$indv] = $this->CekFitness($indv,$prodi);            
        }
        
        return $fitness;
    }
    
    #endregion
    
    #region Seleksi
    public function Seleksi($fitness,$jumlah_populasi)
    {
		$this->populasi       = $jumlah_populasi;
        $jumlah = 0;
        $rank   = array();
        
        
        for ($i = 0; $i < $this->populasi; $i++)
        {
          //proses ranking berdasarkan nilai fitness
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++)
            {
              //ketika nilai fitness jadwal sekarang lebih dari nilai fitness jadwal yang lain,
              //ranking + 1;
              //if (i == j) continue;
                
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);
                
                if ( $fitnessA > $fitnessB)
                {
                    $rank[$i] += 1;                    
                }
            }
            
            $jumlah += $rank[$i];
        }
        
        $jumlah_rank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++)
        {
            //proses seleksi berdasarkan ranking yang telah dibuat
            //int nexRandom = random.Next(1, jumlah);
            //random = new Random(nexRandom);
            $target = mt_rand(0, $jumlah - 1);           
          
            $cek    = 0;
            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }
    //#endregion
    
    public function StartCrossOver($jumlah_populasi,$crossOver)
    {
		$this->populasi       = $jumlah_populasi;
        $this->crossOver      = $crossOver;
        $individu_baru = array(array(array()));
        $jumlah_pengampu = count($this->pengampu);;
        
        for ($i = 0; $i < $this->populasi; $i+=2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            
            //Two point crossover
            if (floatval($cr) < floatval($this->crossOver)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, $jumlah_pengampu - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jumlah_pengampu - 1);
                }
                
                
                //var_dump($this->induk);
                
                
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {                        
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                
                //Penentuan jadwal baru dai titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }
                
                //penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $jumlah_pengampu = count($this->pengampu);
        
        for ($i = 0; $i < $this->populasi; $i += 2) {
          for ($j = 0; $j < $jumlah_pengampu ; $j++) {
            for ($k = 0; $k < 4; $k++) {
                $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
            }
          }
        }

        return $individu_baru;
    }
    
    public function Mutasi($jumlah_populasi,$mutasi,$prodi)
    {
        $this->populasi       = $jumlah_populasi;
        $this->mutasi         = $mutasi;
		
		$fitness = array();
        //proses perandoman atau penggantian komponen untuk tiap jadwal baru
        $r       = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $jumlah_pengampu = count($this->pengampu);
        
        $jumlah_hari = count($this->hari);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            //Ketika nilai random kurang dari nilai probalitas Mutasi, 
            //maka terjadi penggantian komponen
            
            if ($r < $this->mutasi) {
                //Penentuan pada matapelajaran dan kelas yang mana yang akan dirandomkan atau diganti 
                $krom = mt_rand(0, $jumlah_pengampu - 1);
                
                $j = intval($this->sks[$krom]);
                
                switch ($j) {
                    case 1:
						$jumlah_jam = count($this->jam1);
                        $this->individu[$i][$krom][1] = $this->jam1[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 2:
						$jumlah_jam = count($this->jam2);
                        $this->individu[$i][$krom][1] = $this->jam2[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 3:
						$jumlah_jam = count($this->jam3);
                        $this->individu[$i][$krom][1] = $this->jam3[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 4:
						$jumlah_jam = count($this->jam4	);
						$this->individu[$i][$krom][1] = $this->jam4[mt_rand(0, $jumlah_jam - 1)];
                        break;
                }
                //Proses penggantian hari
                $this->individu[$i][$krom][2] = mt_rand(0, $jumlah_hari - 1);
                $jurusan=intval($this->jurusan[$krom]);
                //proses penggantian ruang               
				if ($this->jenis_mk[$krom] === $this->TEORI) {
						if($this->ruang_pilihan[$krom] == true){
							$this->individu[$i][$krom][3] = intval($this->ruang_pilihan[$krom]);				
						}
						else if($this->status[$krom] != 'Normal'){
							$this->ruangReguler=false;
							$kuota=intval($this->kuota_pengampu[$krom]);	
							$rs_RuangReguler = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = '$this->TEORI' and kode_jurusan='$jurusan' and kapasitas >='$kuota' and lantai='1' ");
							$k               = 0;
							foreach ($rs_RuangReguler->result() as $data) {
								$this->ruangReguler[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_reguler = count($this->ruangReguler);
							$this->individu[$i][$krom][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
						}
						else{
							$k=0;
							$this->ruangReguler=false;
							$kuota=intval($this->kuota_pengampu[$krom]);	
							$rs_RuangReguler = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = '$this->TEORI' and kode_jurusan='$jurusan' and kapasitas >='$kuota' ");
							foreach ($rs_RuangReguler->result() as $data) {
								$this->ruangReguler[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_reguler = count($this->ruangReguler);
							$this->individu[$i][$krom][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
						}
					} else if ($this->jenis_mk[$krom] === $this->PRAKTIKUM) {
						if($this->ruang_pilihan[$krom] == true){
							$this->individu[$i][$krom][3] = intval($this->ruang_pilihan[$krom]);				
						}
						else if($this->status[$krom] != 'Normal'){
							$this->ruangLaboratorium=false;	
							$kuota=intval($this->kuota_pengampu[$krom]);	
							$rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = 'LABORATORIUM' and kode_jurusan='$jurusan'  and lantai='1' and kapasitas >='$kuota'  ");
						
							
							foreach ($rs_RuangLaboratorium->result() as $data) {
								$this->ruangLaboratorium[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_lab = count($this->ruangLaboratorium);
							$this->individu[$i][$krom][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
						}
						else{
							$this->ruangLaboratorium=false;
							$k=0;
							$kuota=intval($this->kuota_pengampu[$krom]);	
							$rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = '$this->LABORATORIUM' and kode_jurusan='$jurusan' and kapasitas >='$kuota' ");
							foreach ($rs_RuangLaboratorium->result() as $data) {
								$this->ruangLaboratorium[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_lab = count($this->ruangLaboratorium);
							$this->individu[$i][$krom][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
						}
					}
					else{}
                
            }
            
            $fitness[$i] = $this->CekFitness($i,$prodi);
        }
        return $fitness;
    }
    
    
    public function GetIndividu($indv)
    {
        //return individu;
        
        //int[,] individu_solusi = new int[mata_kuliah.Length, 4];
        $individu_solusi = array(array());
        
        for ($j = 0; $j < count($this->pengampu); $j++)
        {
			
            $individu_solusi[$j][0] = intval($this->pengampu[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][1] = intval($this->individu[$indv][$j][1]);            
            $individu_solusi[$j][2] = intval($this->hari[$this->individu[$indv][$j][2]]);                        
            $individu_solusi[$j][3] = intval($this->individu[$indv][$j][3]);            
        }
        
        return $individu_solusi;
    }
	
	function excel_report(){
		$query = $this->M_Penjadwalan3->get();
		if(!$query)
            return false;
		
		// Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
		
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
		 // Field names in the first row
		 
        
		//$fields =  array("hari", "sesi", "jam_kuliah", "nama_mk", "guru", 
						//"jumlah_jam", "nama_kelas", "nama_semester", "nama_prodi", "kuota", "nama_jurusan", "ruang", "kapasitas");
		$fields =  array("hari", "ruang", "jam_kuliah", "nama_mk", "guru", 
						 "nama_kelas", "nama_semester", "nama_prodi", "kuota");
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
	
	public function simpan_jadwal(){
			$jadwal=$this->M_Penjadwalan3->get();
			foreach($jadwal->result() as $k);
				$semester_tipe=$k->semester_tipe;
				$tahun_akademik=$k->tahun_akademik;
				$prodi=$k->kode_prodi;
			$banyak_prodi=$this->M_Penjadwalan3->cek_banyak_prodi($semester_tipe,$tahun_akademik);
			$riwayat=$this->M_Penjadwalan3->semua_jadwal($semester_tipe,$tahun_akademik);
			foreach($banyak_prodi as $b);
			if($b->banyak > 1 ){
			
				$this->M_Riwayat3->hapus_semua_jadwal($semester_tipe,$tahun_akademik);
					
				
				foreach($jadwal->result() as $j){
						$kode_pengampu=$j->kode_pengampu;
						$kode_jam=$j->kode_jam;
						$kode_hari=$j->kode_hari;
						$kode_ruang=$j->kode_ruang;
						$simpan=$this->M_Penjadwalan3->simpan_jadwal($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang);
					}
			}
			else{
				$cek=$this->M_Penjadwalan3->cek_jadwal($semester_tipe,$tahun_akademik,$prodi);
				if($cek==true){
				$this->M_Riwayat3->hapus_jadwal($semester_tipe,$tahun_akademik,$prodi);
					foreach($jadwal->result() as $j){
						$kode_pengampu=$j->kode_pengampu;
						$kode_jam=$j->kode_jam;
						$kode_hari=$j->kode_hari;
						$kode_ruang=$j->kode_ruang;
						
						$simpan=$this->M_Penjadwalan3->simpan_jadwal($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang);
					}
				}
				else{
					foreach($jadwal->result() as $j){
						$kode_pengampu=$j->kode_pengampu;
						$kode_jam=$j->kode_jam;
						$kode_hari=$j->kode_hari;
						$kode_ruang=$j->kode_ruang;
						
						$simpan=$this->M_Penjadwalan3->simpan_jadwal($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang);
					}
				}
			}
				
			
		
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		$data['waktu'] = "Berhasil menyimpan jadwal";	
			$data['rs_jadwal'] = $this->M_Penjadwalan3->get();
		$datas['aside']='penjadwalan_bar';
		$this->load->view('head',$datas);   
        $this->load->view('penjadwalan',$data);   
        $this->load->view('footer');   		
		
	}
	public function hapus_jadwal(){
		$this->db->query("TRUNCATE TABLE jadwalpelajaran");		
		$data['rs_tahun'] = $this->M_Tahun->semua_tahun();
		$data['hapus'] = "Berhasil menghapus jadwal";	
			$data['rs_jadwal'] = $this->M_Penjadwalan3->get();
		$datas['aside']='penjadwalan_bar';
		$this->load->view('head',$datas);   
        $this->load->view('penjadwalan',$data);   
        $this->load->view('footer');   		
	}

	public function excel_report2(){
		$data['rs_jadwal'] = $this->M_Penjadwalan3->get();

		require(APPPATH.'PHPExcel/Classes/PHPExcel.php');
		require(APPPATH.'PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();

		$object->getProperties()->setCreator("Admin");
		$object->getProperties()->setLastModifiedBy("Admin");
		$object->getProperties()->setTitle("Jadwal Pelajaran");

		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1', 'NO');
		$object->getActiveSheet()->setCellValue('B1', 'HARI');
		$object->getActiveSheet()->setCellValue('C1', 'SESI');
		$object->getActiveSheet()->setCellValue('D1', 'JAM KULIAH');
		$object->getActiveSheet()->setCellValue('E1', 'MATA PELAJARAN');
		$object->getActiveSheet()->setCellValue('F1', 'DOSEN');
		$object->getActiveSheet()->setCellValue('G1', 'SKS');
		$object->getActiveSheet()->setCellValue('H1', 'KELAS');
		$object->getActiveSheet()->setCellValue('I1', 'SEMESTER');
		$object->getActiveSheet()->setCellValue('J1', 'PRODI');
		$object->getActiveSheet()->setCellValue('K1', 'JURUSAN');
		$object->getActiveSheet()->setCellValue('L1', 'RUANGAN');

		$baris = 2;
		$no = 1;

		foreach($data['rs_jadwal']->result() as $row){
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, $row->hari);
			$object->getActiveSheet()->setCellValue('C'.$baris, $row->sesi);
			$object->getActiveSheet()->setCellValue('D'.$baris, $row->jam_kuliah);
			$object->getActiveSheet()->setCellValue('E'.$baris, $row->nama_mk);
			$object->getActiveSheet()->setCellValue('F'.$baris, $row->guru);
			$object->getActiveSheet()->setCellValue('G'.$baris, $row->jumlah_jam);
			$object->getActiveSheet()->setCellValue('H'.$baris, $row->nama_kelas);
			$object->getActiveSheet()->setCellValue('I'.$baris, $row->nama_semester);
			$object->getActiveSheet()->setCellValue('J'.$baris, $row->nama_prodi);
			$object->getActiveSheet()->setCellValue('K'.$baris, $row->nama_jurusan);
			$object->getActiveSheet()->setCellValue('L'.$baris, $row->ruang);
			$baris++;
		}

		$filename = "Jadwal_Pelajaran_".date('d-m-Y').".xlsx";

		$object->getActiveSheet()->setTitle("Jadwal");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		$writer->save('php://output');

		exit;
	}
	
}
?>
