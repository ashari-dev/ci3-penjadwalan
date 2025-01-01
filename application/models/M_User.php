<?php
class M_User extends CI_Model{	
	
	
	public function cek_login($email,$password){
		
		$query = $this->db->query("SELECT * FROM user where Email ='$email' and Password ='$password'");
		return $query->result();

	}
	
	public function cek_user(){
		$email = $this->input->post('email');
		
		$query = $this->db->query("SELECT * FROM user WHERE email='$email' " );
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function detail_user(){
		$id = $this->input->get('id');
		$query = $this->db->query("SELECT * FROM user WHERE kode='$id'" );
		return $query->result();

	}
	
	public function edit_user($id){
			$nama= $this->input->post('nama');
	        $email= $this->input->post('email');
		$data = array(
						'email' => $email,
						'nama' => $nama
					);
		$this->db->where('kode', $id);
		$result = $this->db->update('user', $data);
		return $result;
	}
	
	public function hapus_user($id){
		$this->db->where('kode', $id);
		$result = $this->db->delete('user');
		return $result;
	}
	
	public function semua_user(){
		$query = $this->db->query("SELECT * FROM user order by nama asc");
		return $query->result();
	
	}
	
	
	public function simpan_user($email,$nama,$password){
		
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
