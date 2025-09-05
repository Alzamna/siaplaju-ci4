<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app','model');
		$this->load->library('form_validation');
	}
	
	public function index(){
		$this->form_validation->set_rules('login-username','Username','trim|required');
		$this->form_validation->set_rules('login-password','Password','trim|required');
		if($this->form_validation->run()== FALSE){
			$data=array(
					'title'=>'Login Admin SIAPLAJU',
				);
			$this->load->view('pages/v_login',$data);
			
		} else {
			$hasil = $this->cek_akun();
			switch ($hasil){
				case 'login_sukses':
					redirect('dashboard','refresh');
				break;
				
				case 'password_salah':
					$data=array(
						'title'=>'Login Admin SIAPLAJU',
						'error'=>'Login gagal, pastikan password yang anda masukan benar',
					);
					$this->load->view('pages/v_login',$data);
				break;
				
				case 'akun_belum_aktif':
					$data=array(
						'title'=>'Login Admin SIAPLAJU',
						'error'=>'Login gagal, akun tidak aktif. Silahkan hubungi admin',
					);
					$this->load->view('pages/v_login',$data);
				break;
				
				case 'akun_tidak_ditemukan':
					$data=array(
						'title'=>'Login Admin SIAPLAJU',
						'error'=>'Login gagal, pastikan username dan password yang anda masukan benar',
					);
					$this->load->view('pages/v_login',$data);
				break;
			}
		}
	}
	
	private function cek_akun(){
		$username = $this->input->post('login-username');
		$password = $this->input->post('login-password');
		
		$sql = "SELECT * FROM tbl_user a inner join tbl_akses b
		ON a.id_akses=b.id_akses WHERE username =".$this->db->escape($username)." LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
	
		if ($result->num_rows() === 1){
			if($row->aktif == 1){
				if($this->bcrypt->check_password($password,$row->password)){
					$id['id_user'] = $row->id_user;
					$tgl_login = date('Y-m-d H:i:s');
					$login=array(
						'last_login'=>$tgl_login,
					);
					$this->model_app->updateData('tbl_user',$login,$id);					
					$session_data = array(
						'id_user' => $row->id_user,
						'id_akses' => $row->id_akses,
						'username' => $row->username,
						'nama' => $row->nama,
						'status' => $row->akses,
					);
					$this->set_session($session_data);
					//$this->aktifitas_login($session_data);
					return 'login_sukses';
				}
				else {
					return 'password_salah';
				}
			}
			else{
				return 'akun_belum_aktif';
			}
		}
		else {
			return 'akun_tidak_ditemukan';
		}
	}
	
	private function set_session($session_data){
		$sess_data = array(
					'id_user' => $session_data['id_user'],
					'id_akses' => $session_data['id_akses'],
					'username' => $session_data['username'],
					'nama' => $session_data['nama'],
					'status' => $session_data['status'],
					'login' => 1
					);
		$this->session->set_userdata($sess_data);
	}
	
	/*
	private function aktifitas_login($session_data){
		$aktifitas = array(
			'id_user'=>$this->session->userdata('id_user'),
			'aktifitas'=>'Login dari IP '.$this->input->ip_address(),
			'modul'=>$this->router->fetch_method()
		);
		$this->db->insert('tbl_log_aktifitas',$aktifitas);
	}
	*/
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
}