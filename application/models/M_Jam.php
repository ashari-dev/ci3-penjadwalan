<?php
class M_Jam extends CI_Model{	
	
	public function cek_jam(){
		$range_jam = $this->input->post('range_jam');
		
		$query = $this->db->query("SELECT range_jam FROM jam WHERE range_jam='$range_jam'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_jam(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM jam WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_jam($id){
			$range_jam= $this->input->post('range_jam');
	        
		$data = array(
						'range_jam' => $range_jam
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('jam', $data);
		return $result;
	}
	
	public function hapus_jam($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('jam');
		return $result;
	}
	
	public function semua_jam(){
		$query = $this->db->query("SELECT * FROM jam order by range_jam asc");
		return $query->result();
	
	}
	
	
	public function simpan_jam($range_jam){
		
		$data = array(
						'range_jam' => $range_jam
					);
		$result=$this->db->insert('jam',$data);
		
		return $result;
	}
	
	
}
?>
