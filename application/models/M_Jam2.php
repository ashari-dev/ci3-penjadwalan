<?php
class M_Jam2 extends CI_Model{	
	
	public function cek_jam(){
		$range_jam = $this->input->post('range_jam');
		$sks = $this->input->post('sks');
		$sesi = $this->input->post('sesi');
		
		$query = $this->db->query("SELECT * FROM jam2 WHERE range_jam='$range_jam' and sks='$sks' and sesi='$sesi'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_jam(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM jam2 WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_jam($id){
			$range_jam= $this->input->post('range_jam');
	        $sks = $this->input->post('sks');
			$sesi = $this->input->post('sesi');
		$data = array(
						'range_jam' => $range_jam,
						'sks' => $sks,
						'sesi' => $sesi
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('jam2', $data);
		return $result;
	}
	
	public function hapus_jam($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('jam2');
		return $result;
	}
	
	public function semua_jam(){
		$query = $this->db->query("SELECT * FROM jam2 order by range_jam asc");
		return $query->result();
	
	}
	
	
	public function simpan_jam($range_jam,$sks,$sesi){
		
		$data = array(
						'range_jam' => $range_jam,
						'sks' => $sks,
						'sesi' => $sesi
					);
		$result=$this->db->insert('jam2',$data);
		
		return $result;
	}
	
	
}
?>
