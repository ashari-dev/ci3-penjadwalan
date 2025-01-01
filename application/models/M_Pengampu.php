<?php

class M_Pengampu extends CI_Model{

	public $limit;
	public $offset;
	public $sort;
	public $order;

	function __construct(){

		parent::__construct();

	}
		function count_pengampu(){
		$sql  = "SELECT count(kode) as jumlah  from guru";
		
		$rs = $this->db->query($sql);
		return $rs;
	}
	
	function get($semester_tipe,$tahun_akademik){
	
		$sql  = "SELECT a.kode as kode,".
				"       a.kode_ruang,".
				"       a.kuota,".
				"       a.kelas ,".
				"       a.semester ,".
				"       b.kode as `kode_mk`,".
				"       b.id_mapel,".
				"       b.nama as `nama_mk`,".
				"       b.jenis as `jenis_mk`,".
				"       c.kode as `kode_guru`,".
				"       c.id_guru,".
				"       c.nama as  `nama_guru`,".
				"       d.kode as `kode_tahun`,".
				"       d.tahun as  `tahun_akademik`,".
				"       e.id_kelas,".
				"       e.kode as `kode_kelas`,".
				"       e.nama_kelas as  `nama_kelas`,".
				"       f.id_prodi,".
				"       f.kode as `kode_prodi`,".
				"       f.nama_prodi as  `nama_prodi`,".
				"       g.id_semester,".
				"       g.kode as `kode_semester`,".
				"       g.nama_semester as  `nama_semester`,".
				"       i.nama as  `nama_ruang`".
				"FROM pengampu a ".
				"LEFT JOIN matapelajaran b ".
				"ON a.kode_mk = b.kode ".
				"LEFT JOIN guru c ".
				"ON a.kode_guru = c.kode ".
				"LEFT JOIN tahun_akademik d ".
				"ON a.tahun_akademik = d.kode ".
				"LEFT JOIN kelas e ".
				"ON a.kelas = e.kode ".
				"LEFT JOIN prodi f ".
				"ON a.kode_prodi = f.kode ".
				"LEFT JOIN semester g ".
				"ON a.semester = g.kode ".
				"LEFT JOIN jurusan h ".
				"ON f.kode_jurusan = h.kode ".
				"LEFT JOIN ruang i ".
				"ON a.kode_ruang = i.kode ".
				"WHERE b.semester%2='$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' order by a.kode_prodi asc";
		
		$rs = $this->db->query($sql);
		return $rs;
	}
	
	function get_perprodi($semester_tipe,$tahun_akademik,$prodi){
	
		$sql  = "SELECT a.kode as kode,".
				"       a.kode_ruang,".
				"       a.kuota,".
				"       a.kelas ,".
				"       a.semester ,".
				"       b.kode as `kode_mk`,".
				"       b.nama as `nama_mk`,".
				"       b.jenis as `jenis_mk`,".
				"       c.kode as `kode_guru`,".
				"       c.nama as  `nama_guru`,".
				"       d.kode as `kode_tahun`,".
				"       d.tahun as  `tahun_akademik`,".
				"       e.kode as `kode_kelas`,".
				"       e.nama_kelas as  `nama_kelas`,".
				"       f.kode as `kode_prodi`,".
				"       f.nama_prodi as  `nama_prodi`,".
				"       g.kode as `kode_semester`,".
				"       g.nama_semester as  `nama_semester`,".
				"       i.nama as  `nama_ruang`".
				"FROM pengampu a ".
				"LEFT JOIN matapelajaran b ".
				"ON a.kode_mk = b.kode ".
				"LEFT JOIN guru c ".
				"ON a.kode_guru = c.kode ".
				"LEFT JOIN tahun_akademik d ".
				"ON a.tahun_akademik = d.kode ".
				"LEFT JOIN kelas e ".
				"ON a.kelas = e.kode ".
				"LEFT JOIN prodi f ".
				"ON a.kode_prodi = f.kode ".
				"LEFT JOIN semester g ".
				"ON a.semester = g.kode ".
				"LEFT JOIN jurusan h ".
				"ON f.kode_jurusan = h.kode ".
				"LEFT JOIN ruang i ".
				"ON a.kode_ruang = i.kode ".
				"WHERE b.semester='$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' and a.kode_prodi='$prodi' order by a.kode asc ";
		
		$rs = $this->db->query($sql);
		return $rs;
	}
	
	function detail_pengampu(){
		$kode = $this->input->get('id');
		$sql  = "SELECT a.kode as kode,".
				"       a.kuota ,".
				"       a.kode_ruang ,".
				"       b.kode as `kode_mk`,".
				"       b.nama as `nama_mk`,".
				"       b.semester as `semester`,".
				"       b.jenis as `jenis_mk`,".
				"       c.kode as `kode_guru`,".
				"       c.nama as  `nama_guru`,".
				"       d.kode as `kode_tahun`,".
				"       d.tahun as  `tahun_akademik`,".
				"       e.kode as `kode_kelas`,".
				"       e.nama_kelas as  `nama_kelas`,".
				"       f.kode as `kode_prodi`,".
				"       f.nama_prodi as  `nama_prodi`,".
				"       g.kode as `kode_semester`,".
				"       g.nama_semester as  `nama_semester`,".
				"       g.semester_tipe,".
				"       i.nama as  `nama_ruang`".
				"FROM pengampu a ".
				"LEFT JOIN matapelajaran b ".
				"ON a.kode_mk = b.kode ".
				"LEFT JOIN guru c ".
				"ON a.kode_guru = c.kode ".
				"LEFT JOIN tahun_akademik d ".
				"ON a.tahun_akademik = d.kode ".
				"LEFT JOIN kelas e ".
				"ON a.kelas = e.kode ".
				"LEFT JOIN prodi f ".
				"ON a.kode_prodi = f.kode ".
				"LEFT JOIN semester g ".
				"ON a.semester = g.kode ".
				"LEFT JOIN jurusan h ".
				"ON f.kode_jurusan = h.kode ".
				"LEFT JOIN ruang i ".
				"ON a.kode_ruang = i.kode ".
				"WHERE a.kode = '$kode'";
		
		$rs = $this->db->query($sql);
		return $rs->result();
		
	}
	
	function get_search($search_query, $semester_tipe,$tahun_akademik){
	
		$rs = $this->db->query(
							    "SELECT a.kode as kode,".
								"       b.kode as `kode_mk`,".
								"       b.nama as `nama_mk`,".
								"       c.kode as `kode_guru`,".
								"       c.nama as  `nama_guru`,".
								"       a.kelas as kelas,".
								"       a.tahun_akademik as `tahun_akademik` ".
								"FROM pengampu a ".
								"LEFT JOIN matapelajaran b ".
								"ON a.kode_mk = b.kode ".
								"LEFT JOIN guru c ".
								"ON a.kode_guru = c.kode ".
								"WHERE b.semester%2='$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' AND (c.nama LIKE '%$search_query%' OR b.nama LIKE '%$search_query%') ".                
								"ORDER BY b.nama,a.kelas");
		return $rs;
	}
	
	function num_page($semester_tipe,$tahun_akademik){
		
		
		$rs = $this->db->query(
							    "SELECT CAST(COUNT(*) AS CHAR(4)) as cnt ".
								"FROM pengampu a ".
								"LEFT JOIN matapelajaran b ".
								"ON a.kode_mk = b.kode ".
								"LEFT JOIN guru c ".
								"ON a.kode_guru = c.kode ".
								"WHERE b.semester%2='$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' ".                
								"ORDER BY b.nama,a.kelas");
		return $rs->row()->cnt;
		
	}
	
	
	function delete_by_kode_guru($kode_guru){
        $this->db->query("DELETE FROM pengampu WHERE kode_guru='$kode_guru'");
    }
	
	function delete_by_mk($kode_mk){
		$this->db->query("DELETE FROM pengampu WHERE kode_mk = '$kode_mk'");
	}
	
	function delete($kode){
		$this->db->query("DELETE FROM pengampu WHERE kode = '$kode'");		
	}
	
	public function edit_pengampu($id){
		    $mapel= $this->input->post('mapel');
	        $guru= $this->input->post('guru');
	        $kelas= $this->input->post('kelas');
	        $jurusan= $this->input->post('prodi');
	        $kuota= $this->input->post('kuota');
	        $ruang= $this->input->post('ruang');
	        $semester= $this->input->post('semester');
	        $tahun= $this->input->post('tahun');
		$data = array(
						'kode_mk' => $mapel,
						'kode_guru' => $guru,
						'kelas' => $kelas,
						'tahun_akademik' => $tahun,
						'kode_prodi' => $jurusan,
						'semester' => $semester,
						'kuota' => $kuota,
						'kode_ruang' => $ruang
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('pengampu', $data);
		return $result;
	}
	
	function cek_for_insert($kode_mk,$kode_guru,$kelas,$tahun_akademik,$kode){		
		$rs = $this->db->query(
							   "SELECT CAST(COUNT(*) AS CHAR(1)) as cnt".
                               "FROM pengampu ".
							   "WHERE kode_mk='$kode_mk' AND ".
                               "      kode_guru=$kode_guru AND ".
                               "      kelas = '$kelas' AND ".
                               "      tahun_akademik='$tahun_akademik' ");
		return $rs->row()->cnt;
	}
	
	public function simpan_pengampu(){
	        $mapel= $this->input->post('mapel');
	        $guru= $this->input->post('guru');
	        $kelas= $this->input->post('kelas');
	        $jurusan= $this->input->post('prodi');
	        $kuota= $this->input->post('kuota');
	        $ruang= $this->input->post('ruang');
	        $semester= $this->input->post('semester');
	        $tahun= $this->input->post('tahun');
		$data = array(
						'kode_mk' => $mapel,
						'kode_guru' => $guru,
						'kelas' => $kelas,
						'tahun_akademik' => $tahun,
						'kode_prodi' => $jurusan,
						'semester' => $semester,
						'kuota' => $kuota,
						'kode_ruang' => $ruang
					);
		$result=$this->db->insert('pengampu',$data);
		
		return $result;
	}
	
	public function hapus_pengampu($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('pengampu');
		return $result;
	}
}
?>