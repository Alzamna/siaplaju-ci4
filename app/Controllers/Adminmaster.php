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
		echo view('pages/v_header',$data);
		echo view('master/v_master_admin');
		echo view('pages/v_footer');
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
		return redirect()->to('adminmaster/admin');
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
		return redirect()->to('adminmaster/admin');
	}
	
	public function hapus_user(){
		$id['id_user'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_user',$id);
		return redirect()->to('master/admin');
	}
	
	public function rayon(){
		$data=array(
			'title'=>'Data rayon',
			'open_master'=>'open',
			'master_rayon'=>'active',
			'dt_rayon'=>$this->model->getAllData('tbl_rayon'),
		);
		echo view('pages/v_header',$data);
		echo view('master/v_master_rayon');
		echo view('pages/v_footer');
	}
	
	public function proses_tambah_rayon(){
		$data=array(
			'nama_rayon'=>$this->request->getPost('nama_rayon'),
		);
		$this->model->insertData('tbl_rayon',$data);
		return redirect()->to('adminmaster/rayon');
	}
	
	public function proses_edit_rayon(){
		$id['id_rayon'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'nama_rayon'=>$this->request->getPost('nama_rayon'),
		);
		$this->model->updateData('tbl_rayon',$data,$id);
		return redirect()->to('adminmaster/rayon');
	}
	
	public function hapus_rayon(){
		$id['id_rayon'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_rayon',$id);
        return redirect()->to('adminmaster/rayon');
	}
	
	public function kecamatan(){
		$data=array(
			'title'=>'Data Kecamatan',
			'open_master'=>'open',
			'master_kecamatan'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_rayon'=>$this->model->getAllData('tbl_rayon'),
		);
		echo view('pages/v_header',$data);
		echo view('master/v_master_kecamatan');
		echo view('pages/v_footer');
	}
	
	public function proses_tambah_kecamatan(){
		$data=array(
			'nama_kecamatan'=>$this->request->getPost('nama_kecamatan'),
			'id_rayon'=>$this->request->getPost('rayon'),
		);
		$this->model->insertData('tbl_kecamatan',$data);
		return redirect()->to('adminmaster/kecamatan');
	}
	
	public function proses_edit_kecamatan(){
		$id['id_kecamatan'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'nama_kecamatan'=>$this->request->getPost('nama_kecamatan'),
			'id_rayon'=>$this->request->getPost('rayon'),
		);
		$this->model->updateData('tbl_kecamatan',$data,$id);
		return redirect()->to('adminmaster/kecamatan');
	}
	
	public function hapus_kecamatan(){
		$id['id_kecamatan'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_kecamatan',$id);
        return redirect()->to('adminmaster/kecamatan');
	}
	
	public function jalan()
	{
		$page = $this->request->getVar('page') ?? 1;
		$perPage = 20;
		$dari = ($page - 1) * $perPage;

		$num = $this->model->getJmlJalan(); // total rows
		$dt_jalan = $this->model->getAllJalan($perPage, $dari);

		$pager = \Config\Services::pager();
		$pager->makeLinks($page, $perPage, $num); // bikin link manual

		$data = [
			'title' => 'Data Jalan Kabupaten Tegal',
			'open_master' => 'open',
			'master_jalan' => 'active',
			'dt_jalan' => $dt_jalan,
			'dt_kecamatan' => $this->model->getAllKecamatan(),
			'start' => $dari,
			'pager' => $pager
		];

		echo view('pages/v_header', $data);
		echo view('master/v_master_jalan', $data);
		echo view('pages/v_footer');
	}

	
	public function proses_tambah_jalan(){
		$data=array(
			'nama_jalan'=>$this->request->getPost('nama_jalan'),
			'id_kecamatan'=>$this->request->getPost('kecamatan'),
			'status_jalan'=>$this->request->getPost('status_jalan'),
			'panjang_jalan'=>$this->request->getPost('panjang_jalan'),
		);
		$this->model->insertData('tbl_jalan',$data);
		return redirect()->to('adminmaster/jalan');
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
		return redirect()->to('adminmaster/jalan');
	}
	
	public function hapus_jalan(){
		$id['id_jalan'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_jalan',$id);
        return redirect()->to('adminmaster/jalan');
	}

}