<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminjalan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_backend','model');
		$this->load->library('pagination');
		$this->load->library('googlemaps');
		$this->load->helper('text');
		$this->load->library('upload');
		if($this->session->userdata('login') != 1 ){
            redirect('login');
        };
	}
	
	public function index(){
		$data=array(
			'title'=>'Data Jalan Kabupaten Tegal',
			'open_jalan'=>'open',
			'aktif_jalan'=>'active',
			'dt_jalan'=>$this->model->getDataJalan(),
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('jalan/v_jalan');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah_jalan(){
		$data=array(
			'nama_jalan'=>$this->input->post('nama_jalan'),
			'id_kecamatan'=>$this->input->post('kecamatan'),
			'status_jalan'=>$this->input->post('status_jalan'),
			'panjang_jalan'=>$this->input->post('panjang_jalan'),
		);
		$this->model->insertData('tbl_jalan',$data);
		redirect('adminjalan');
	}
	
	public function proses_edit_jalan(){
		$id['id_jalan'] = $this->uri->segment(3);
		$data=array(
			'nama_jalan'=>$this->input->post('nama_jalan'),
			'id_kecamatan'=>$this->input->post('kecamatan'),
			'status_jalan'=>$this->input->post('status_jalan'),
			'panjang_jalan'=>$this->input->post('panjang_jalan'),
		);
		$this->model->updateData('tbl_jalan',$data,$id);
		redirect('adminjalan');
	}
	
	public function hapus_jalan(){
		$id['id_jalan'] = $this->uri->segment(3);
        $this->model->deleteData('tbl_jalan',$id);
        redirect('adminjalan');
	}
	
	public function lihat(){
		$id = $this->uri->segment(3);
		$pju = $this->model->getLihatJalan($id);
		
		foreach($pju as $row){
			$confmap = array(
				'map_height'=>400,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>'auto',
			);
			$this->googlemaps->initialize($confmap);
			if($row->kondisi=='H'){
				$icon = base_url().'/assets/img/lampu-on.png';
			} else {
				$icon = base_url().'/assets/img/lampu-off.png';
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'animation'=>'DROP',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		$data=array(
			'title'=>'Data Jalan',
			'open_jalan'=>'open',
			'aktif_jalan'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_jalan'=>$this->model->getJalan($id),
			'dt_perbaikan'=>$this->model->getPengaduanJalan($id),
			'dt_pju'=>$pju,
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('jalan/v_lihat_jalan');
		$this->load->view('pages/v_footer');
	}
	
	public function get_jalan(){
		$id['id_kecamatan'] = $this->input->get('id', TRUE);
		$jalan = $this->model->getSelectedData('tbl_jalan',$id)->result();
		echo json_encode($jalan);
	}
}