<?php
class M_Admin extends CI_Model{	
	
	public function cek_admin($id){
		$email = $this->input->post('email');
		
		$query = $this->db->query("SELECT email FROM user WHERE email='$email'" );
		$query2 = $this->db->query("SELECT * FROM user WHERE email='$email' AND kode='$id'" );
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
	
	public function cek_admin_awal(){
		$email = $this->input->post('email');
		
		$query = $this->db->query("SELECT email FROM user WHERE email='$email'" );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_admin(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM user WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_admin($id){
		$nama= $this->input->post('nama');
	        $email= $this->input->post('email');
	        $password= md5($this->input->post('password'));
	        if($this->input->post('password') == null){
				$data = array(
						'email' => $email,
						'nama' => $nama
					);
			}
			else{
				$data = array(
						'email' => $email,
						'password' => $password,
						'nama' => $nama
					);
			}
		$this->db->where('kode', $id);
		$result = $this->db->update('user', $data);
		return $result;
	}
	
	public function hapus_admin($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('user');
		return $result;
	}
	
	public function semua_admin(){
		$query = $this->db->query("SELECT * FROM user order by nama asc");
		return $query->result();
	
	}
	
	public function banyak_admin(){
		$query = $this->db->query("SELECT * FROM user order by nama asc");
		return $query->num_rows();
	
	}
	
	public function simpan_admin($email,$nama,$password){
		
		$data = array(
						'email' => $email,
						'password' => $password,
						'nama' => $nama
					);
		$result=$this->db->insert('user',$data);
		
		return $result;
	}
	
	
}
?>
