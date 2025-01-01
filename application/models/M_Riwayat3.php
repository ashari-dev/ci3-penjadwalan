<?php

class M_Riwayat3 extends CI_Model{

	public $limit;
	public $offset;
	public $sort;
	public $order;

	function __construct(){

		parent::__construct();

	}
	
	function get($semester_tipe,$tahun_akademik){
		$rs = $this->db->query(	"SELECT  e.nama as hari,".
								
								"        b.kuota,".
								"        c.nama as nama_mk,".
								"        c.jumlah_jam as jumlah_jam,".
								"        c.semester as semester,".
								"        d.nama as guru,".
								"        f.nama as ruang, ".
								"        g.range_jam as jam_kuliah, ".
								"        g.sesi , ".
								"        f.kapasitas , ".
								"       h.kode as `kode_kelas`,".
								"       h.nama_kelas as  `nama_kelas`,".
								"       i.kode as `kode_prodi`,".
								"       i.nama_prodi as  `nama_prodi`,".
								"       j.kode as `kode_semester_tipe`,".
								"       j.tipe_semester as  `semester_tipe`,".
								"       k.kode as `kode_tahun`,".
								"       k.tahun as  `nama_tahun`,".
								"       l.kode as `kode_semester`,".
								"       l.nama_semester as  `nama_semester`,".
								"       m.kode as `kode_jurusan`,".
								"       m.nama_jurusan as  `nama_jurusan`".
								"FROM riwayat_penjadwalan a ".
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
								"WHERE l.semester_tipe='$semester_tipe' AND b.tahun_akademik='$tahun_akademik'".
								"order by e.kode asc,Jam_Kuliah asc;");
		return $rs;
	}

	function get_perprodi($semester_tipe,$tahun_akademik,$jurusan){
		$rs = $this->db->query(	"SELECT  e.nama as hari,".
								"        b.kuota,".
								"        c.nama as nama_mk,".
								"        c.jumlah_jam as jumlah_jam,".
								"        c.semester as semester,".
								"        d.nama as guru,".
								"        f.nama as ruang, ".
								"        g.range_jam as jam_kuliah, ".
								"        g.sesi , ".
								"        f.kapasitas , ".
								"       h.kode as `kode_kelas`,".
								"       h.nama_kelas as  `nama_kelas`,".
								"       i.kode as `kode_prodi`,".
								"       i.nama_prodi as  `nama_prodi`,".
								"       j.kode as `kode_semester_tipe`,".
								"       j.tipe_semester as  `semester_tipe`,".
								"       k.kode as `kode_tahun`,".
								"       k.tahun as  `nama_tahun`,".
								"       l.kode as `kode_semester`,".
								"       l.nama_semester as  `nama_semester`,".
								"       m.kode as `kode_jurusan`,".
								"       m.nama_jurusan as  `nama_jurusan`".
								"FROM riwayat_penjadwalan a ".
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
								"WHERE l.semester_tipe='$semester_tipe' AND b.tahun_akademik='$tahun_akademik' AND b.kode_prodi='$jurusan'".
								"order by e.kode asc,Jam_Kuliah asc;");
		return $rs;
	}

	function print_semua_jurusan($semester_tipe,$tahun_akademik){
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
								"        d.nama as guru,".
								"        f.nama as ruang, ".
								"       h.kode as `kode_kelas`,".
								"       h.nama_kelas as  `nama_kelas`,".
								"       i.kode as `kode_prodi`,".
								"       i.nama_prodi as  `nama_prodi`,".
								"       j.kode as `kode_semester_tipe`,".
								"       j.tipe_semester as  `semester_tipe`,".
								"       k.kode as `kode_tahun`,".
								"       k.tahun as  `nama_tahun`,".
								"       l.nama_semester as  `nama_semester`,".
								"       m.nama_jurusan as  `nama_jurusan`".
								"FROM riwayat_penjadwalan a ".
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
								"LEFT JOIN jam g ".
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
								"WHERE l.semester_tipe='$semester_tipe' AND b.tahun_akademik='$tahun_akademik'".
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
	
	public function semua_jadwal(){
		$query = $this->db->query("SELECT * FROM jadwalpelajaran ");
		return $query->result();
	
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
	
	public function hapus_semua_jadwal($semester_tipe,$tahun_akademik){
		$query = $this->db->query("DELETE riwayat_penjadwalan  FROM riwayat_penjadwalan  
								  LEFT JOIN pengampu 
								  ON riwayat_penjadwalan.kode_pengampu = pengampu.kode
								  LEFT JOIN semester  
								  ON pengampu.semester = semester.kode
								  WHERE semester.semester_tipe = '$semester_tipe' AND pengampu.tahun_akademik = '$tahun_akademik' 
								  ");
		return $query;
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
}