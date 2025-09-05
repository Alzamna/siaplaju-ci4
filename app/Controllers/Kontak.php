<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kontak extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app');
		$this->load->helper('date');
		$this->load->library('googlemaps');
	}
	
	public function index(){
		$confmap = array(
			'center'=>'-7.006282, 109.139990',
			'zoom'=>17,
			'map_height'=>400,
			'map_type'=>'HYBRID',
		);
		$this->googlemaps->initialize($confmap);
		
		$marker=array(
			'position'=>'-7.006282, 109.139990',
			'animation'=>'DROP',
			//'infowindow_content'=>'<b>Dinas Pekerjaan Umum Kabupaten Cilacap</b></br>alamat : Jl. Kusuma Bangsa No.45, Kandang Panjang, Pekalongan Utara, Kabupaten Cilacap, Jawa Tengah 51115<br/>Telp : (0285) 423222',
			'title'=>'TIM PJU DINAS PERHUBUNGAN KABUPATEN TEGAL',
		);
		$this->googlemaps->add_marker($marker);
		
		$data=array(
			'title'=>'Kontak TIM PJU Dinas Perhubungan Kabupaten Tegal',
			'aktif_kontak'=>'active',
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/pages/v_kontak');
		$this->load->view('home/pages/v_footer');
	}
}