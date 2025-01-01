<?php
class M_Hari extends CI_Model{	
	
	public function cek_hari(){
		$nama = $this->input->post('nama');
		
		$query = $this->db->query("SELECT nama FROM hari WHERE nama='$nama'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_hari(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM hari WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_hari($id){
			$nama= $this->input->post('nama');
	        
		$data = array(
						'nama' => $nama
					);
		$this->db->where('kode', $id);	
		$result = $this->db->update('hari', $data);
		return $result;
	}
	
	public function hapus_hari($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('hari');
		return $result;
	}
	
	public function semua_hari(){
		$query = $this->db->query("SELECT * FROM hari order by kode asc");
		return $query->result();
	
	}
	
	
	public function simpan_hari($nama){
		
		$data = array(
						'nama' => $nama
					);
		$result=$this->db->insert('hari',$data);
		
		return $result;
	}
	
	
}
?>
