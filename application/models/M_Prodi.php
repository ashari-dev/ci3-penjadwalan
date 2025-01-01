<?php
class M_Prodi extends CI_Model{	
	
	public function cek_prodi($id){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama_prodi FROM prodi WHERE nama_prodi='$nama'" );
		$query2 = $this->db->query("SELECT * FROM prodi WHERE nama_prodi='$nama' AND kode='$id'" );
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

	}
	
	public function cek_prodi_awal(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama_prodi FROM prodi WHERE nama_prodi='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_prodi(){
		$id = $this->input->get('id');
		$query = $this->db->query(
		"SELECT a.*, b.kode as kode_jurusan, b.nama_jurusan 
		FROM prodi a 
		LEFT JOIN jurusan b
		ON a.kode_jurusan = b.kode 
		WHERE a.kode='$id'");
		return $query->result();

	}
	
	public function per_prodi($id){
		$query = $this->db->query("SELECT * FROM prodi WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_prodi($id){
		$nama= $this->input->post('nama');
		$kode_jurusan= $this->input->post('jurusan');
	        
		$data = array(
						'nama_prodi' => $nama,
						'kode_jurusan' => $kode_jurusan
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('prodi', $data);
		return $result;
	}
	
	public function hapus_prodi($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('prodi');
		return $result;
	}
	
	public function semua_prodi(){
		$query = $this->db->query(
		"SELECT a.*, b.kode as kode_jurusan, b.nama_jurusan 
		FROM prodi a 
		LEFT JOIN jurusan b
		ON a.kode_jurusan = b.kode order by kode asc");
		return $query->result();
	
	}
	
	public function semua_prodi2(){
		$query = $this->db->query(
		"SELECT a.*, b.kode as kode_jurusan, b.nama_jurusan 
		FROM prodi a 
		LEFT JOIN jurusan b
		ON a.kode_jurusan = b.kode WHERE a.nama_prodi !='MIPA' order by kode asc");
		return $query->result();
	
	}
		
	public function kode_jurusan($prodi){
		
		$query = $this->db->query(
		"SELECT * FROM prodi WHERE kode='$prodi'");
		return $query->result();
	
	}
	
	public function simpan_prodi($nama,$kode_jurusan){
		
		$data = array(
						'nama_prodi' => $nama,
						'kode_jurusan' => $kode_jurusan
					);
		$result=$this->db->insert('prodi',$data);
		
		return $result;
	}
	
	
}
?>
