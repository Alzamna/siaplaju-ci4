<?php 
namespace App\Controllers;

use App\Models\Model_backend;   // model yang kamu pakai
use CodeIgniter\Controller;

class Adminmaster extends BaseController{
	protected $model;
	protected $pager;
	protected $session;

	public function __construct()
	{
		$this->model = new Model_backend();
		$this->session = \Config\Services::session();
		helper('date'); // load helper
	}
	
	public function admin(){
		$data=array(
			'title'=>'Admin Sipelaju',
			'open_master'=>'open',
			'master_admin'=>'active',
			'dt_user'=>$this->model->getAllAdmin(),
			'dt_akses'=>$this->model->getAllData('tbl_akses'),
		);
		return view('pages/v_header',$data);
		return view('master/v_master_admin');
		return view('pages/v_footer');
	}
	
	public function proses_tambah_admin(){
		$user=array(
			'id_akses'=>$this->request->getPost('akses'),
			'nama'=>$this->request->getPost('nama'),
			'alamat'=>$this->request->getPost('alamat'),
			'telp'=>$this->request->getPost('telp'),
			'username'=>$this->request->getPost('username'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
		);
		$this->model->insertData('tbl_user',$user);
		redirect('adminmaster/admin');
	}
	
	public function proses_edit_admin(){
		$id['id_user'] = $this->request->getUri()->getSegment(3);
		$user=array(
			'id_akses'=>$this->request->getPost('akses'),
			'nama'=>$this->request->getPost('nama'),
			'alamat'=>$this->request->getPost('alamat'),
			'telp'=>$this->request->getPost('telp'),
			'username'=>$this->request->getPost('username'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
		);
		$this->model->updateData('tbl_user',$user,$id);
		redirect('adminmaster/admin');
	}
	
	public function hapus_user(){
		$id['id_user'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_user',$id);
        redirect('master/admin');
	}
	
	public function rayon(){
		$data=array(
			'title'=>'Data rayon',
			'open_master'=>'open',
			'master_rayon'=>'active',
			'dt_rayon'=>$this->model->getAllData('tbl_rayon'),
		);
		return view('pages/v_header',$data);
		return view('master/v_master_rayon');
		return view('pages/v_footer');
	}
	
	public function proses_tambah_rayon(){
		$data=array(
			'nama_rayon'=>$this->request->getPost('nama_rayon'),
		);
		$this->model->insertData('tbl_rayon',$data);
		redirect('adminmaster/rayon');
	}
	
	public function proses_edit_rayon(){
		$id['id_rayon'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'nama_rayon'=>$this->request->getPost('nama_rayon'),
		);
		$this->model->updateData('tbl_rayon',$data,$id);
		redirect('adminmaster/rayon');
	}
	
	public function hapus_rayon(){
		$id['id_rayon'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_rayon',$id);
        redirect('adminmaster/rayon');
	}
	
	public function kecamatan(){
		$data=array(
			'title'=>'Data Kecamatan',
			'open_master'=>'open',
			'master_kecamatan'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_rayon'=>$this->model->getAllData('tbl_rayon'),
		);
		return view('pages/v_header',$data);
		return view('master/v_master_kecamatan');
		return view('pages/v_footer');
	}
	
	public function proses_tambah_kecamatan(){
		$data=array(
			'nama_kecamatan'=>$this->request->getPost('nama_kecamatan'),
			'id_rayon'=>$this->request->getPost('rayon'),
		);
		$this->model->insertData('tbl_kecamatan',$data);
		redirect('adminmaster/kecamatan');
	}
	
	public function proses_edit_kecamatan(){
		$id['id_kecamatan'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'nama_kecamatan'=>$this->request->getPost('nama_kecamatan'),
			'id_rayon'=>$this->request->getPost('rayon'),
		);
		$this->model->updateData('tbl_kecamatan',$data,$id);
		redirect('adminmaster/kecamatan');
	}
	
	public function hapus_kecamatan(){
		$id['id_kecamatan'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_kecamatan',$id);
        redirect('adminmaster/kecamatan');
	}
	
	public function jalan(){
		if($this->request->getUri()->getSegment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->request->getUri()->getSegment(3);
		};

		$num = $this->model->getJmlJalan();
		$config=array(
			'base_url' => base_url() . service('router')->controllerName() . '/' . service('router')->methodName(),
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
			'dt_jalan'=>$this->model->getAllJalan($config['per_page'],$dari),
			'dt_kecamatan'=>$this->model->getAllData('tbl_kecamatan'),
			'start'=>$dari,
		);
		$data['dt_jalan'] = $this->model->paginate(20);
		$data['pager'] = $this->model->pager;
		return view('pages/v_header',$data);
		return view('master/v_master_jalan');
		return view('pages/v_footer');
	}
	
	public function proses_tambah_jalan(){
		$data=array(
			'nama_jalan'=>$this->request->getPost('nama_jalan'),
			'id_kecamatan'=>$this->request->getPost('kecamatan'),
			'status_jalan'=>$this->request->getPost('status_jalan'),
			'panjang_jalan'=>$this->request->getPost('panjang_jalan'),
		);
		$this->model->insertData('tbl_jalan',$data);
		redirect('adminmaster/jalan');
	}
	
	public function proses_edit_jalan(){
		$id['id_jalan'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'nama_jalan'=>$this->request->getPost('nama_jalan'),
			'id_kecamatan'=>$this->request->getPost('kecamatan'),
			'status_jalan'=>$this->request->getPost('status_jalan'),
			'panjang_jalan'=>$this->request->getPost('panjang_jalan'),
		);
		$this->model->updateData('tbl_jalan',$data,$id);
		redirect('adminmaster/jalan');
	}
	
	public function hapus_jalan(){
		$id['id_jalan'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_jalan',$id);
        redirect('adminmaster/jalan');
	}
}