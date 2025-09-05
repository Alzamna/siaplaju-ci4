<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app','model');
		$this->load->helper('date');
		$this->load->helper('text');
	}
	
	public function index(){
		$data=array(
			'title'=>'Sistem Informasi Alat Penerangan Lampu Jalan Umum Kabupaten Tegal',
			'aktif_beranda'=>'active',
			'dt_pengaduan'=>$this->model->getPengaduanBeranda(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/pages/v_beranda');
		$this->load->view('home/pages/v_footer');
	}
}