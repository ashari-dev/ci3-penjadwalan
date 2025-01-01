<?php

class M_Penjadwalan3 extends CI_Model{

	public $limit;
	public $offset;
	public $sort;
	public $order;

	function __construct(){

		parent::__construct();

	}
	
	function get(){
		$rs = $this->db->query(	"SELECT  e.nama as hari,".
			   
								
								"        a.kode_pengampu,".
								"        a.kode_hari,".
								"        a.kode_jam,".
								"        a.kode_ruang,".
								"        b.kode,".
								"        b.kuota,".
								"        f.kapasitas, ".
								"        b.tahun_akademik,".
								"        b.kode_prodi ,".
								"        c.id_mapel,".
								"        c.jumlah_jam as jumlah_jam,".
								"        e.id_hari,".
								"        c.nama as nama_mk,".
								"        c.semester as semester,".
								"        d.id_guru,".
								"        d.nama as guru,".
								"        f.id_ruang, ".
								"        f.nama as ruang, ".
								"        g.id_jam, ".
								"        g.range_jam as jam_kuliah, ".
								"        g.sesi as sesi, ".
								"       h.id_kelas,".
								"       h.kode as `kode_kelas`,".
								"       h.nama_kelas as  `nama_kelas`,".
								"       i.id_prodi,".
								"       i.kode ,".
								"       i.nama_prodi as  `nama_prodi`,".
								"       j.kode as `kode_semester_tipe`,".
								"       j.tipe_semester as  `tipe_semester`,".
								"       k.kode as `kode_tahun`,".
								"       k.tahun as  `nama_tahun`,".
								"       l.id_semester,".
								"       l.kode as `kode_semester`,".
								"       l.nama_semester as  `nama_semester`,".
								"       l.semester_tipe as  `semester_tipe`,".
								"       m.nama_jurusan as  `nama_jurusan`,".
								"       m.kode as  `kode_jurusan`".
								"FROM jadwalpelajaran a ".
								"LEFT JOIN pengampu b ".
								"ON a.kode_pengampu = b.kode ".
								"LEFT JOIN matapelajaran c ".
								"ON b.kode_mk = c.kode ".
								"LEFT JOIN guru d ".
								"ON b.kode_guru = d.kode ".
								"LEFT JOIN hari e ".
								"ON a.kode_hari = e.kode ".
								"LEFT JOIN ruang f ".
								"ON a.kode_ruang = f.kode ".
								"LEFT JOIN jam2 g ".
								"ON a.kode_jam = g.kode ".
								"LEFT JOIN kelas h ".
								"ON b.kelas = h.kode ".
								"LEFT JOIN prodi i ".
								"ON b.kode_prodi = i.kode ".
								"LEFT JOIN semester_tipe j ".
								"ON c.semester = j.kode ".
								"LEFT JOIN tahun_akademik k ".
								"ON b.tahun_akademik = k.kode ".
								"LEFT JOIN semester l ".
								"ON b.semester = l.kode ".
								"LEFT JOIN jurusan m ".
								"ON i.kode_jurusan = m.kode ".
								"order by e.kode asc,Jam_Kuliah asc;");
		return $rs;
	}
	
	

	function getPerGuru($id_guru=null){
		$rs = $this->db->query(	"SELECT  e.nama as hari,".
								"          Concat_WS('-',  concat('(', g.kode), concat( (SELECT kode".  
								"                                  FROM jam ". 
								"                                  WHERE kode = (SELECT jm.kode ".
								"                                                FROM jam jm  ".
								"                                                WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1)),')')) as sesi, ". 
								" 		  Concat_WS('-', MID(g.range_jam,1,5),".
								"                (SELECT MID(range_jam,7,5) ".
								"                 FROM jam ".
								"                 WHERE kode = (SELECT jm.kode ".
								"                               FROM jam jm ".
								"                               WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1))) as jam_kuliah, ".
			   
								"        c.nama as nama_mk,".
								"        c.jumlah_jam as jumlah_jam,".
								"        c.semester as semester,".
								"        b.kelas as kelas,".
								"        d.nama as guru,".
								"        f.nama as ruang ".
								"FROM jadwalpelajaran as a, pengampu as b, matapelajaran as c, guru as d, hari as e, ruang as f, jam as g WHERE ".
								"a.kode_pengampu = b.kode AND ".
								"b.kode_mk = c.kode AND ".
								"b.kode_guru = d.kode AND ".
								"b.kode_guru = $id_guru AND ".
								"a.kode_hari = e.kode AND ".
								"a.kode_ruang = f.kode AND ".
								"a.kode_jam = g.kode ".
								"order by e.kode asc,Jam_Kuliah asc;");
		return $rs;
	}
	
	public function semua_jadwal($semester_tipe,$tahun_akademik){
		$sql  = "SELECT a.kode_pengampu  ".
				"FROM riwayat_penjadwalan a ".
				"LEFT JOIN pengampu b ".
				"ON a.kode_pengampu = b.kode ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.kode ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik' ";
		
		$rs = $this->db->query($sql);
		return $rs->result();
	
	}
	
	public function hapus_jadwal($semester_tipe,$tahun_akademik,$prodi){
		$query = $this->db->query("DELETE riwayat_penjadwalan  FROM riwayat_penjadwalan  
								  LEFT JOIN pengampu 
								  ON riwayat_penjadwalan.kode_pengampu = pengampu.kode
								  LEFT JOIN semester  
								  ON pengampu.semester = semester.kode
								  WHERE semester.semester_tipe = '$semester_tipe' AND pengampu.tahun_akademik = '$tahun_akademik' AND pengampu.kode_prodi='$prodi' 
								  ");
		return $query;
	}
	
	function detail_pengampu($id){
	
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
				"WHERE a.kode='$id'";
		
		$rs = $this->db->query($sql);
		return $rs->result();
	}
	
	function cek_jadwal($semester_tipe,$tahun_akademik,$prodi){
		
		$sql  = "SELECT a.kode  ,".
				"       b.kode ,".
				"       c.kode ".
				"FROM riwayat_penjadwalan a ".
				"LEFT JOIN pengampu b ".
				"ON a.kode_pengampu = b.kode ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.kode ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik' AND b.kode_prodi = '$prodi'";
		
		$rs = $this->db->query($sql);
		return $rs->result();
		
	}
	
	function cek_jadwalpelajaran(){
		$sql  = "SELECT * FROM jadwalpelajaran";
		$rs = $this->db->query($sql);
		return $rs->result();
		
	}
	
	function cek_semua_jadwal($semester_tipe,$tahun_akademik){
		
		$sql  = "SELECT a.kode as kode_riwayat ,".
				"       b.kode ,".
				"       c.kode ".
				"FROM riwayat_penjadwalan a ".
				"LEFT JOIN pengampu b ".
				"ON a.kode_pengampu = b.kode ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.kode ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik' ";
		
		$rs = $this->db->query($sql);
		return $rs->result();
		
	}
	
	function hapus_riwayat_jadwal($id){
		
		$this->db->where('kode', $id);
		$result = $this->db->delete('riwayat_penjadwalan');
		return $result;
		
	}
	
	
	
	function cek_banyak_prodi($semester_tipe,$tahun_akademik){
		
		$sql  = "SELECT COUNT( DISTINCT b.kode_prodi ) as banyak ,".
				"       a.kode ,".
				"       c.kode ".
				"FROM jadwalpelajaran a ".
				"LEFT JOIN pengampu b ".
				"ON a.kode_pengampu = b.kode ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.kode ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik'";
		
		$rs = $this->db->query($sql);
		return $rs->result();
		
	}
	
	function cek_banyak_pengampu($semester_tipe,$tahun_akademik,$prodi){
		
		$sql  = "SELECT COUNT( a.kode ) as banyak  ".
				"FROM pengampu a ".
				"LEFT JOIN semester b ".
				"ON a.semester = b.kode ".
				"WHERE b.semester_tipe = '$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' and a.kode_prodi='$prodi'";
		
		$rs = $this->db->query($sql);
		return $rs;
		
	}
	
	public function simpan_jadwal($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang){
	        
		$data = array(
						'kode_pengampu' => $kode_pengampu,
						'kode_hari' => $kode_hari,
						'kode_jam' => $kode_jam,
						'kode_ruang' => $kode_ruang
						
					);
		$result=$this->db->insert('riwayat_penjadwalan',$data);
		
		return $result;
	}
	
	public function update_jadwal($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang){
	        
		$data = array(
						'kode_pengampu' => $kode_pengampu,
						'kode_hari' => $kode_hari,
						'kode_jam' => $kode_jam,
						'kode_ruang' => $kode_ruang
						
					);
		$this->db->where('kode_pengampu', $kode_pengampu);
		$result = $this->db->update('riwayat_penjadwalan', $data);
		
		return $result;
	}
}