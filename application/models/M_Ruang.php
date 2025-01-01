<?php
class M_Ruang extends CI_Model{	
	
	public function cek_ruang($id){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM ruang WHERE nama='$nama'" );
		$query2 = $this->db->query("SELECT * FROM ruang WHERE nama='$nama' AND kode='$id'" );
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
	
	public function cek_ruang_awal(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM ruang WHERE nama='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_ruang(){
		$id = $this->input->get('id');
		$query = $this->db->query(
		"SELECT a.*,
		b.nama_jurusan, 
		b.kode as kode_jurusan FROM ruang a 
		LEFT JOIN jurusan b 
		ON a.kode_jurusan = b.kode
		WHERE a.kode='$id'");
		return $query->result();

	}
	
	public function edit_ruang($id){
			$nama= $this->input->post('nama');
	        $kapasitas= $this->input->post('kapasitas');
	        $jenis= $this->input->post('kategori');
	        $lantai= $this->input->post('lantai');
	        $jurusan= $this->input->post('jurusan');
	        
		$data = array(
						'nama' => $nama,
						'kapasitas' => $kapasitas,
						'jenis' => $jenis,
						'kode_jurusan' => $jurusan,
						'lantai' => $lantai
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('ruang', $data);
		return $result;
	}
	
	public function hapus_ruang($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('ruang');
		return $result;
	}
	
	public function semua_ruang(){
		$query = $this->db->query(
		"SELECT a.*,
		b.nama_jurusan, 
		b.kode as kode_jurusan FROM ruang a 
		LEFT JOIN jurusan b 
		ON a.kode_jurusan = b.kode
		order by a.kode asc");
		return $query->result();
	
	}
	
	public function ruang_perjurusan($jurusan){
		
		$query = $this->db->query(
		"SELECT * FROM ruang WHERE kode_jurusan='$jurusan' or kode_jurusan='0' order by nama asc");
		return $query->result();
	
	}
	
	
	public function simpan_ruang($nama,$kapasitas,$jenis,$kode_jurusan,$lantai){
		
		$data = array(
						'nama' => $nama,
						'kapasitas' => $kapasitas,
						'jenis' => $jenis,
						'kode_jurusan' => $kode_jurusan,
						'lantai' => $lantai
					);
		$result=$this->db->insert('ruang',$data);
		
		return $result;
	}
	
	
}
?>
