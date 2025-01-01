<?php
class M_Tahun extends CI_Model{	
	
	public function cek_tahun(){
		$tahun = $this->input->post('tahun');
		
		$query = $this->db->query("SELECT tahun FROM tahun_akademik WHERE tahun='$tahun'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_tahun(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM tahun_akademik WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_tahun($id){
		$tahun= $this->input->post('tahun');
	        
		$data = array(
						'tahun' => $tahun
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('tahun_akademik', $data);
		return $result;
	}
	
	public function hapus_tahun($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('tahun_akademik');
		return $result;
	}
	
	public function semua_tahun(){
		$query = $this->db->query("SELECT * FROM tahun_akademik order by kode asc");
		return $query->result();
	
	}
	
	public function tahun_awal($id){
		$query = $this->db->query("SELECT * FROM tahun_akademik WHERE kode='$id' ");
		return $query->result();
	
	}
	
	public function simpan_tahun($tahun){
		
		$data = array(
						'tahun' => $tahun
					);
		$result=$this->db->insert('tahun_akademik',$data);
		
		return $result;
	}
	
	
}
?>
