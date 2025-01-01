<?php
class M_Mapel extends CI_Model{	
	
	public function cek_mapel($id){
			$kode_matkul= $this->input->post('kode_matkul');
	        $nama= $this->input->post('nama');
	        $jenis= $this->input->post('kategori');	
	        $semester= $this->input->post('semester_tipe');
	        $jumlah_jam= $this->input->post('jumlah_jam');
	        $prodi= $this->input->post('prodi');
		
		$query = $this->db->query("SELECT * FROM matapelajaran WHERE nama_kode='$kode_matkul' and nama='$nama' and jenis='$jenis' and semester='$semester' 
								  and jumlah_jam='$jumlah_jam' and kode_prodi='$prodi'" );
		$query2 = $this->db->query("SELECT * FROM matapelajaran WHERE nama_kode='$kode_matkul' and nama='$nama' and jenis='$jenis' and semester='$semester' 
								  and jumlah_jam='$jumlah_jam' and kode_prodi='$prodi' AND kode='$id'" );
		if($query2->num_rows() > 0){
			return false;
		}else{
			if($query->num_rows() > 0){
				return $query->result();
			}
			else{
				return false;
			}	
		}

	
		$kode_mapel = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM matapelajaran WHERE nama='$kode_mapel'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function cek_mapel_awal(){
		
		$kode_matkul= $this->input->post('kode_matkul');
	        $nama= $this->input->post('nama');
	        $jenis= $this->input->post('kategori');	
	        $semester= $this->input->post('semester_tipe');
	        $jumlah_jam= $this->input->post('jumlah_jam');
	        $prodi= $this->input->post('prodi');
		
		$query = $this->db->query("SELECT * FROM matapelajaran WHERE nama_kode='$kode_matkul' and nama='$nama' and jenis='$jenis' and semester='$semester' 
								  and jumlah_jam='$jumlah_jam' and kode_prodi='$prodi'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_mapel(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT   a.kode as kode_matkul ,"
                                    . "       a.jenis ,"
                                    . "       a.semester ,"
                                    . "       a.jumlah_jam ,"
                                    . "       a.nama ,"
                                    . "       a.nama_kode ,"
                                    . "       c.kode ,"
                                    . "       a.kode_prodi,"
                                    . "       c.nama_prodi,"
                                    . "       b.kode as kode_semester,"
                                    . "       b.tipe_semester "
                                    . "FROM matapelajaran a "
                                    . "LEFT JOIN semester_tipe b "
                                    . "ON a.semester = b.kode 
									LEFT JOIN prodi c 
									ON a.kode_prodi= c.kode 
									where a.kode='$id'");
		return $query->result();

	}
	
	public function edit_mapel($id){
		$kode_matkul= $this->input->post('kode_matkul');
	        $nama= $this->input->post('nama');
	        $jenis= $this->input->post('kategori');	
	        $semester= $this->input->post('semester_tipe');
	        $jumlah_jam= $this->input->post('jumlah_jam');
	        $prodi= $this->input->post('prodi');
		
		$data = array(
						'nama' => $nama,
						'jumlah_jam' => $jumlah_jam,
						'semester' => $semester,
						'jenis' => $jenis,
						'nama_kode' => $kode_matkul,
						'kode_prodi' => $prodi
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('matapelajaran', $data);
		return $result;
	}
	
	public function get_mapel(){
		$id = $this->input->get('s');
		$prodi = $this->input->get('p');
		$jenis = $this->input->get('j');
		$query = $this->db->query("SELECT * FROM matapelajaran WHERE jenis='$jenis' and semester='$id' and kode_prodi='$prodi' order by nama asc" );
		return $query->result();

	}
	
	public function jenis_mapel(){
		$id = $this->input->get('s');
		$prodi = $this->input->get('p');
		$query = $this->db->query("SELECT DISTINCT jenis as jenis_mapel FROM matapelajaran WHERE semester='$id' and kode_prodi='$prodi'" );
		return $query->result();

	}
	
	public function jumlah_jam($id){
		$query = $this->db->query("SELECT * FROM matapelajaran WHERE kode='$id'" );
		return $query->result();

	}
	
	public function hapus_mapel($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('matapelajaran');
		return $result;
	}
	
	public function mapel_persemester($semester,$prodi){
		$query = $this->db->query("SELECT * FROM matapelajaran WHERE semester='$semester'  and kode_prodi='$prodi'");
		return $query->result();
	
	}
	
	public function semua_mapel(){
		$query = $this->db->query("SELECT   a.kode as kode_matkul ,"
                                    . "       a.jenis ,"
                                    . "       a.semester ,"
                                    . "       a.jumlah_jam ,"
                                    . "       a.id_mapel ,"
                                    . "       a.nama ,"
                                    . "       a.nama_kode ,"
                                    . "       c.kode ,"
                                    . "       c.nama_prodi,"
                                    . "       b.kode as kode_semester,"
                                    . "       b.tipe_semester "
                                    . "FROM matapelajaran a "
                                    . "LEFT JOIN semester_tipe b "
                                    . "ON a.semester = b.kode 
									LEFT JOIN prodi c 
									ON a.kode_prodi= c.kode 
									order by a.kode_prodi asc ");
		return $query->result();
	
	}
	
	
	public function simpan_mapel($kode_matkul,$nama,$jumlah_jam,$semester,$jenis,$prodi){
		
		$data = array(
						'nama' => $nama,
						'jumlah_jam' => $jumlah_jam,
						'semester' => $semester,
						'jenis' => $jenis,
						'nama_kode' => $kode_matkul,
						'kode_prodi' => $prodi
					);
		$result=$this->db->insert('matapelajaran',$data);
		
		return $result;
	}
	
	
}
?>
