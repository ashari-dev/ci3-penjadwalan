<?php
class M_Guru extends CI_Model{	
	
	public function cek_guru($id){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM guru WHERE nama='$nama'" );
		$query2 = $this->db->query("SELECT * FROM guru WHERE nama='$nama' AND kode='$id'" );
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
	
	public function cek_guru_awal(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM guru WHERE nama='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_guru(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT a.*, b.status, b.kode as kode_status FROM guru a 
									LEFT JOIN status_dosen b
									ON a.status_dosen = b.kode
									WHERE a.kode='$id' order by nama asc");
		return $query->result();

	}
	
	public function edit_guru($id){
		$nama= $this->input->post('nama');
	        $alamat= $this->input->post('alamat');
	        $telepon= $this->input->post('telepon');
	        $nip= $this->input->post('nip');
	        $status= $this->input->post('status');
		
		$data = array(
						'nip' => $nip,
						'nama' => $nama,
						'alamat' => $alamat,
						'telp' => $telepon,
						'status_dosen' => $status
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('guru', $data);
		return $result;
	}
	
	public function hapus_guru($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('guru');
		return $result;
	}
	
	public function semua_guru(){
		$query = $this->db->query("SELECT a.*, b.status, b.kode as kode_status FROM guru a 
									LEFT JOIN status_dosen b
									ON a.status_dosen = b.kode
									order by a.nama asc");
		return $query->result();
	
	}
	
	
	public function simpan_guru($nama,$alamat,$telepon,$nip,$status){
		
		$data = array(
						'nip' => $nip,
						'nama' => $nama,
						'alamat' => $alamat,
						'telp' => $telepon,
						'status_dosen' => $status
					);
		$result=$this->db->insert('guru',$data);
		
		return $result;
	}
	
	public function cek_status($id){
		$status = $this->input->post('status');
		
		$query = $this->db->query("SELECT status FROM status_dosen WHERE status='$status'" );
		$query2 = $this->db->query("SELECT * FROM status_dosen WHERE status='$status' AND kode='$id'" );
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
	
	public function cek_status_awal(){
		$status = $this->input->post('status');
		
		$query = $this->db->query("SELECT status FROM status_dosen WHERE status='$status'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_status(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM status_dosen WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_status($id){
		$status= $this->input->post('status');
		
		$data = array(
						'status' => $status
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('status_dosen', $data);
		return $result;
	}
	
	public function hapus_status($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('status_dosen');
		return $result;
	}
	
	public function semua_status(){
		$query = $this->db->query("SELECT * FROM status_dosen order by kode asc");
		return $query->result();
	
	}
	
	
	public function simpan_status($status){
		
		$data = array(
						'status' => $status
					);
		$result=$this->db->insert('status_dosen',$data);
		
		return $result;
	}
	
	
}
?>
