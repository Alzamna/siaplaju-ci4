<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminmaster extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_backend','model');
		$this->load->library('pagination');
		$this->load->helper('date');
		if($this->session->userdata('login') != 1 ){
            redirect('login');
        };
	}
	
	public function admin(){
		$data=array(
			'title'=>'Admin Sipelaju',
			'open_master'=>'open',
			'master_admin'=>'active',
			'dt_user'=>$this->model_app->getAllAdmin(),
			'dt_akses'=>$this->model_app->getAllData('tbl_akses'),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('master/v_master_admin');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah_admin(){
		$user=array(
			'id_akses'=>$this->input->post('akses'),
			'nama'=>$this->input->post('nama'),
			'alamat'=>$this->input->post('alamat'),
			'telp'=>$this->input->post('telp'),
			'username'=>$this->input->post('username'),
			'password'=>$this->bcrypt->hash_password($this->input->post('password')),
		);
		$this->model_app->insertData('tbl_user',$user);
		redirect('adminmaster/admin');
	}
	
	public function proses_edit_admin(){
		$id['id_user'] = $this->uri->segment(3);
		$user=array(
			'id_akses'=>$this->input->post('akses'),
			'nama'=>$this->input->post('nama'),
			'alamat'=>$this->input->post('alamat'),
			'telp'=>$this->input->post('telp'),
			'username'=>$this->input->post('username'),
			'password'=>$this->bcrypt->hash_password($this->input->post('password')),
		);
		$this->model_app->updateData('tbl_user',$user,$id);
		redirect('adminmaster/admin');
	}
	
	public function hapus_user(){
		$id['id_user'] = $this->uri->segment(3);
        $this->model_app->deleteData('tbl_user',$id);
        redirect('master/admin');
	}
	
	public function rayon(){
		$data=array(
			'title'=>'Data rayon',
			'open_master'=>'open',
			'master_rayon'=>'active',
			'dt_rayon'=>$this->model_app->getAllData('tbl_rayon'),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('master/v_master_rayon');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah_rayon(){
		$data=array(
			'nama_rayon'=>$this->input->post('nama_rayon'),
		);
		$this->model_app->insertData('tbl_rayon',$data);
		redirect('adminmaster/rayon');
	}
	
	public function proses_edit_rayon(){
		$id['id_rayon'] = $this->uri->segment(3);
		$data=array(
			'nama_rayon'=>$this->input->post('nama_rayon'),
		);
		$this->model_app->updateData('tbl_rayon',$data,$id);
		redirect('adminmaster/rayon');
	}
	
	public function hapus_rayon(){
		$id['id_rayon'] = $this->uri->segment(3);
        $this->model_app->deleteData('tbl_rayon',$id);
        redirect('adminmaster/rayon');
	}
	
	public function kecamatan(){
		$data=array(
			'title'=>'Data Kecamatan',
			'open_master'=>'open',
			'master_kecamatan'=>'active',
			'dt_kecamatan'=>$this->model_app->getAllKecamatan(),
			'dt_rayon'=>$this->model_app->getAllData('tbl_rayon'),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('master/v_master_kecamatan');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah_kecamatan(){
		$data=array(
			'nama_kecamatan'=>$this->input->post('nama_kecamatan'),
			'id_rayon'=>$this->input->post('rayon'),
		);
		$this->model_app->insertData('tbl_kecamatan',$data);
		redirect('adminmaster/kecamatan');
	}
	
	public function proses_edit_kecamatan(){
		$id['id_kecamatan'] = $this->uri->segment(3);
		$data=array(
			'nama_kecamatan'=>$this->input->post('nama_kecamatan'),
			'id_rayon'=>$this->input->post('rayon'),
		);
		$this->model_app->updateData('tbl_kecamatan',$data,$id);
		redirect('adminmaster/kecamatan');
	}
	
	public function hapus_kecamatan(){
		$id['id_kecamatan'] = $this->uri->segment(3);
        $this->model_app->deleteData('tbl_kecamatan',$id);
        redirect('adminmaster/kecamatan');
	}
	
	public function jalan(){
		if($this->uri->segment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->uri->segment(3);
		};

		$num = $this->model->getJmlJalan();
		$config=array(
			'base_url'=>base_url().$this->router->fetch_class().'/'.$this->router->fetch_method(),
			'total_rows'=>$num,
			'per_page'=>20,
			'full_tag_open'=> "<ul class='pagination'>",
			'full_tag_close'=> "</ul>",
			'num_tag_open' => "<li class='page-item'><a class='page-link'",
			'num_tag_close' => '</li>',
			'cur_tag_open' => "<li class='page-item active'><a class='page-link' href='#'>",
			'cur_tag_close' => "<span class='sr-only'></span></a></li>",
			'next_tag_open' => "<li class='page-item'><a class='page-link'",
			'next_tagl_close' => "</li>",
			'prev_tag_open' => "<li class='page-item'><a class='page-link'",
			'prev_tagl_close' => "</li>",
			'first_tag_open' => "<li class='page-item'><a class='page-link'",
			'first_tagl_close' => "</li>",
			'last_tag_open' => "<li class='page-item'><a class='page-link'",
			'last_tagl_close' => "</li>"
		);
		
		$data=array(
			'title'=>'Data Jalan Kabupaten Tegal',
			'open_master'=>'open',
			'master_jalan'=>'active',
			'dt_jalan'=>$this->model_app->getAllJalan($config['per_page'],$dari),
			'dt_kecamatan'=>$this->model_app->getAllData('tbl_kecamatan'),
			'start'=>$dari,
		);
		$this->pagination->initialize($config);
		$this->load->view('pages/v_header',$data);
		$this->load->view('master/v_master_jalan');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah_jalan(){
		$data=array(
			'nama_jalan'=>$this->input->post('nama_jalan'),
			'id_kecamatan'=>$this->input->post('kecamatan'),
			'status_jalan'=>$this->input->post('status_jalan'),
			'panjang_jalan'=>$this->input->post('panjang_jalan'),
		);
		$this->model_app->insertData('tbl_jalan',$data);
		redirect('adminmaster/jalan');
	}
	
	public function proses_edit_jalan(){
		$id['id_jalan'] = $this->uri->segment(3);
		$data=array(
			'nama_jalan'=>$this->input->post('nama_jalan'),
			'id_kecamatan'=>$this->input->post('kecamatan'),
			'status_jalan'=>$this->input->post('status_jalan'),
			'panjang_jalan'=>$this->input->post('panjang_jalan'),
		);
		$this->model_app->updateData('tbl_jalan',$data,$id);
		redirect('adminmaster/jalan');
	}
	
	public function hapus_jalan(){
		$id['id_jalan'] = $this->uri->segment(3);
        $this->model_app->deleteData('tbl_jalan',$id);
        redirect('adminmaster/jalan');
	}
}