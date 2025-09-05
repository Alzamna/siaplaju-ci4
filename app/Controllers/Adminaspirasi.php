<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminaspirasi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_backend','model');
		$this->load->library('pagination');
		$this->load->library('googlemaps');
		$this->load->helper('text');
		$this->load->library('upload');
		$this->load->library('image_lib');
		if($this->session->userdata('login') != 1 ){
            redirect('login');
        };
	}
	
	public function index(){
		if($this->uri->segment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->uri->segment(3);
		};

		$num = $this->model->getJmlAspirasi();
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
			'title'=>'Aspirasi LPJU Kabupaten Tegal',
			'open_aspirasi'=>'open',
			'aktif_aspirasi'=>'active',
			'dt_aspirasi'=>$this->model->getAllAspirasi($config['per_page'],$dari),
			'start'=>$dari,
		);
		$this->pagination->initialize($config);
		$this->load->view('pages/v_header',$data);
		$this->load->view('aspirasi/v_aspirasi');
		$this->load->view('pages/v_footer');
	}
	
	public function verifikasi(){
		$id = $this->uri->segment(3);
		$confmap = array(
			'center'=>'-6.99926531, 109.13596825',
			'zoom'=>11,
			'map_height'=>500,
			'map_type'=>'HYBRID',
			'places'=>TRUE,
			'placesAutocompleteInputID'=>'cari_lokasi',
			'placesAutocompleteBoundsMap'=>TRUE,
			'placesAutocompleteOnChange'=>'PlacesLokasi();',
			'onclick'=>'updateKoordinat(event.latLng.lat(), event.latLng.lng());setMapOnAll(map);clearMarker(); createMarker_map({ map: map, position:event.latLng });',
		);
		$this->googlemaps->initialize($confmap);
		
		$data=array(
			'title'=>'Verifikasi Aspirasi LPJU',
			'open_aspirasi'=>'open',
			'aktif_aspirasi'=>'active',
			'dt_aspirasi'=>$this->model->getDataAspirasi($id),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('aspirasi/v_verifikasi');
		$this->load->view('pages/v_footer');
	}
	
	public function lihat(){
		$id = $this->uri->segment(3);
		$idx['id_aspirasi'] = $this->uri->segment(3);
		$asp = $this->model->getDataAspirasi($id);
		
		foreach($asp as $row){
			$confmap = array(
				'map_height'=>400,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>17,
			);
			$this->googlemaps->initialize($confmap);
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'animation'=>'DROP',
				//'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		$data=array(
			'title'=>'Lihat Aspirasi',
			'open_aspirasi'=>'open',
			'aktif_aspirasi'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_aspirasi'=>$asp,
			'dt_foto'=>$this->model->getSelectedData('tbl_aspirasi_foto',$idx)->result(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('aspirasi/v_lihat_aspirasi');
		$this->load->view('pages/v_footer');
	}
	
	public function cari(){
		$id = $this->input->post('cari');
		$data=array(
			'title'=>'Aspirasi LPJU Kabupaten Tegal',
			'open_aspirasi'=>'open',
			'aktif_aspirasi'=>'active',
			'dt_aspirasi'=>$this->model->getCariAspirasi($id),
			'start'=>0,
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('aspirasi/v_aspirasi');
		$this->load->view('pages/v_footer');
	}
	
	public function hapus(){
		$id['id_aspirasi'] = $this->uri->segment(3);
		$data=array(
			'aktif'=>0,
		);
		$this->model_app->updateData('tbl_aspirasi',$data,$idx);
		redirect('adminaspirasi');
	}
}