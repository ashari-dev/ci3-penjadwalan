<?php
class M_Semester extends CI_Model{	
	
	public function cek_semester(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama_semester FROM semester WHERE nama_semester='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_semester(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM semester WHERE kode='$id'" );
		return $query->result();

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
								"WHERE b.tahun_akademik='9'".
								"order by rand();");
		return $rs;
	}
	
	public function edit_semester($id){
		$nama= $this->input->post('nama');
	        
		$data = array(
						'nama_semester' => $nama
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('semester', $data);
		return $result;
	}
	
	public function hapus_semester($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('semester');
		return $result;
	}
	
	public function semua_semester(){
		$query = $this->db->query("SELECT   a.kode as kode_semester,"
                                    . "       a.nama_semester ,"
                                    . "       b.kode ,"
                                    . "       a.semester_tipe,"
                                    . "       b.tipe_semester "
                                    . "FROM semester a "
                                    . "LEFT JOIN semester_tipe b "
                                    . "ON a.semester_tipe = b.kode order by kode_semester asc ");
		return $query->result();
	
	}
	
	public function persemester($semester){
		$query = $this->db->query("SELECT * FROM semester WHERE semester_tipe='$semester'");
		return $query->result();
	
	}
	
	public function get_semester(){
		$id = $this->input->get('s');
		$query = $this->db->query("SELECT * FROM semester WHERE semester_tipe='$id'" );
		return $query->result();

	}
	
	public function simpan_semester($nama){
		
		$data = array(
						'nama_semester' => $nama
					);
		$result=$this->db->insert('semester',$data);
		
		return $result;
	}
	
	
}
?>
