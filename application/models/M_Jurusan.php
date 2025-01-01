<?php
class M_Jurusan extends CI_Model{	
	
	public function cek_jurusan(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama_jurusan FROM jurusan WHERE nama_jurusan='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_jurusan(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM jurusan WHERE kode='$id'" );
		return $query->result();

	}
	
	public function per_jurusan($id){
		$query = $this->db->query("SELECT * FROM jurusan WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_jurusan($id){
		$nama= $this->input->post('nama');
	        
		$data = array(
						'nama_jurusan' => $nama
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('jurusan', $data);
		return $result;
	}
	
	public function hapus_jurusan($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('jurusan');
		return $result;
	}
	
	public function semua_jurusan(){
		$query = $this->db->query("SELECT * FROM jurusan order by kode asc");
		return $query->result();
	
	}
	
	
	public function simpan_jurusan($nama){
		
		$data = array(
						'nama_jurusan' => $nama
					);
		$result=$this->db->insert('jurusan',$data);
		
		return $result;
	}
	
	
}
?>
