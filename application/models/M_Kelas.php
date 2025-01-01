<?php
class M_Kelas extends CI_Model{	
	
	public function cek_kelas(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama_kelas FROM kelas WHERE nama_kelas='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_kelas(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM kelas WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_kelas($id){
		$nama= $this->input->post('nama');
	        
		$data = array(
						'nama_kelas' => $nama
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('kelas', $data);
		return $result;
	}
	
	public function hapus_kelas($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('kelas');
		return $result;
	}
	
	public function semua_kelas(){
		$query = $this->db->query("SELECT * FROM kelas order by kode asc");
		return $query->result();
	
	}
	
	
	public function simpan_kelas($nama){
		
		$data = array(
						'nama_kelas' => $nama
					);
		$result=$this->db->insert('kelas',$data);
		
		return $result;
	}
	
	
}
?>
