<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Aspirasi extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app','model');
		$this->load->library('googlemaps');
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->library('upload');
	}
	
	public function index(){
		if($this->uri->segment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->uri->segment(3);
		};
		
		$num = $this->model_app->getJmlAspirasi();
		$config=array(
			'base_url'=>base_url().$this->router->fetch_class().'/'.$this->router->fetch_method(),
			'total_rows'=>$num,
			'per_page'=>12,
			'full_tag_open'=> "<ul class='pagination nomargin'>",
			'full_tag_close'=> "</ul>",
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'cur_tag_open' => "<li class='disabled'><li class='active'><a href='#'>",
			'cur_tag_close' => "<span class='sr-only'></span></a></li>",
			'next_tag_open' => "<li>",
			'next_tagl_close' => "</li>",
			'prev_tag_open' => "<li>",
			'prev_tagl_close' => "</li>",
			'first_tag_open' => "<li>",
			'first_tagl_close' => "</li>",
			'last_tag_open' => "<li>",
			'last_tagl_close' => "</li>"
		);
		
		$data=array(
			'title'=>'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
			'aktif_aspirasi'=>'active',
			'dt_aspirasi'=>$this->model_app->getAllAspirasi($config['per_page'],$dari),
		);
		$this->pagination->initialize($config);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/aspirasi/v_aspirasi');
		$this->load->view('home/pages/v_footer');
	}
	
	public function input(){
		$confmap = array(
			'center'=>'-6.99926531, 109.13596825',
			'zoom'=>10,
			'map_height'=>400,
			'map_type'=>'HYBRID',
			'onload'=>'ControlLokasi();',
			'onclick'=>'updateKoordinat(event.latLng.lat(), event.latLng.lng());setMapOnAll(map);clearMarker(); createMarker_map({ map: map, position:event.latLng });',
			'places'=>TRUE,
			'placesAutocompleteInputID'=>'cari',
			'placesAutocompleteBoundsMap'=>TRUE,
			'placesAutocompleteOnChange'=>'PlacesLokasi();',
		);
		$this->googlemaps->initialize($confmap);
		
		$data=array(
			'title'=>'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
			'aktif_aspirasi'=>'active',
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/aspirasi/v_input_aspirasi');
		$this->load->view('home/pages/v_footer');
	}
	
	public function proses_aspirasi(){
		$id = $this->model_app->getKodeAspirasi();
		$foto = 'foto';
		if(!empty($_FILES['foto']['name'])){
			$length = count($_FILES['foto']['name']);
			for($i = 0; $i < $length; $i++){
				$_FILES['files']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['files']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['files']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['files']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['files']['size'] = $_FILES['foto']['size'][$i];
				
				$config=array(
					'file_name'=>'ASP'.$id.''.$i,
					'upload_path'=>'./upload/temp/',
					'allowed_types'=>'jpg|png|jpeg|bmp',
					'max_size'=>'0',
				);
				$this->upload->initialize($config);
				if($this->upload->do_upload('files')){
					$upload = $this->upload->data();
					$foto[$i]=array(
						'id_aspirasi'=>$id,
						'nama_foto'=>$upload['file_name'],
					);
					$this->model_app->insertData('tbl_aspirasi_foto',$foto[$i]);
					
					$image=array(
						'image_library'=>'gd2',
						'source_image'=>'./upload/temp/'.$upload['file_name'],
						'new_image'=>'./upload/foto/aspirasi/'.$upload['file_name'],
						'create_thumb'=>TRUE,
						'thumb_marker'=>'',
						'maintain_ratio' => TRUE,
						'width' => 1200,
					);
					$this->image_lib->initialize($image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			}
		}
		
		$data=array(
			'id_aspirasi'=>$id,
			'tgl_aspirasi'=>date('Y-m-d H:i:s'),
			'no_ktp'=>$this->input->post('no_ktp'),
			'nama'=>$this->input->post('nama'),
			'no_telp'=>$this->input->post('no_telp'),
			'alamat'=>$this->input->post('alamat'),
			'aspirasi'=>$this->input->post('aspirasi'),
			'lat'=>$this->input->post('lat'),
			'lng'=>$this->input->post('lng'),
		);
		$this->model_app->insertData('tbl_aspirasi',$data);
		$this->session->set_flashdata('sukses', '<script>alert("Terima kasih atas informasinya, Aspirasi yang anda kirimkan sebagai bahan masukan bagi kami dalam merencanakan program kerja dinas perhubungan.");</script>');
		redirect('aspirasi');
	}
}