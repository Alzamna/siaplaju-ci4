<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminpju extends CI_Controller {
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
		if($this->uri->segment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->uri->segment(3);
		};

		$num = $this->model->getJmlPju();
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
			'title'=>'Data PJU Kabupaten Tegal',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'dt_pju'=>$this->model->getAllPju($config['per_page'],$dari),
			'start'=>$dari,
		);
		$this->pagination->initialize($config);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_pju');
		$this->load->view('pages/v_footer');
	}
	
	public function tambah(){
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
			'title'=>'Tambah Data Lampu PJU',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_tambah_pju');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_tambah(){
		if(!empty($_FILES['foto']['name'])){
			$name = date("Ymdhis");
			$length = count($_FILES['foto']['name']);
			for($i = 0; $i < $length; $i++){
				$_FILES['files']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['files']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['files']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['files']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['files']['size'] = $_FILES['foto']['size'][$i];
				
				$config=array(
					'file_name'=>$name.'_'.$i,
					'upload_path'=>'./upload/temp/',
					'allowed_types'=>'jpg|png|jpeg|bmp',
					'max_size'=>'0',
				);
				$this->upload->initialize($config);
				if($this->upload->do_upload('files')){
					$upload = $this->upload->data();
					$foto[$i]=array(
						'id_pju'=>$id,
						'nama_foto'=>$upload['file_name'],
					);
					$this->model_app->insertData('tbl_pju_foto',$foto[$i]);
					
					$image=array(
						'image_library'=>'gd2',
						'source_image'=>'./upload/temp/'.$upload['file_name'],
						'new_image'=>'./upload/foto/'.$upload['file_name'],
						'create_thumb'=>TRUE,
						'thumb_marker'=>'',
						'maintain_ratio' => TRUE,
						'width' => 600,
					);
					$this->image_lib->initialize($image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			}
		}
		
		$data=array(
			'id_jalan'=>$this->input->post('jalan'),
			'id_pel'=>$this->input->post('id_pel'),
			'no_gardu'=>$this->input->post('no_gardu'),
			'no_pal'=>$this->input->post('no_pal'),
			'jenis'=>$this->input->post('jenis'),
			'kwh'=>$this->input->post('kwh'),
			'daya'=>$this->input->post('daya'),
			'posisi'=>$this->input->post('posisi'),
			'kondisi'=>$this->input->post('kondisi'),
			'keterangan'=>$this->input->post('keterangan'),
			'lat'=>$this->input->post('lat'),
			'lng'=>$this->input->post('lng'),
		);
		$this->model_app->insertData('tbl_pju',$data);
		redirect('adminpju');
	}
	
	public function cari(){
		$id = $this->input->post('cari');
		$data=array(
			'title'=>'Data PJU Kabupaten Tegal',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'dt_pju'=>$this->model->getCariPju($id),
			'start'=>0,
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_pju');
		$this->load->view('pages/v_footer');
	}
	
	public function edit(){
		$id = $this->uri->segment(3);
		$pju = $this->model_app->getDataPju($id);
		
		foreach($pju as $row){
			$confmap = array(
				'map_height'=>300,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>19,
				'places'=>TRUE,
				'placesAutocompleteInputID'=>'cari_lokasi',
				'placesAutocompleteBoundsMap'=>TRUE,
				'placesAutocompleteOnChange'=>'PlacesLokasi();',
				'onclick'=>'updateKoordinat(event.latLng.lat(), event.latLng.lng());setMapOnAll(map);clearMarker(); createMarker_map({ map: map, position:event.latLng });',
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
			'title'=>'Edit Data PJU',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'dt_pju'=>$this->model->getDataPju($id),
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_edit_pju');
		$this->load->view('pages/v_footer');
	}
	
	public function proses_edit(){
		$id['id_pju'] = $this->uri->segment(3);
		
		if(!empty($_FILES['foto']['name'])){
			$name = date("Ymdhis");
			$length = count($_FILES['foto']['name']);
			for($i = 0; $i < $length; $i++){
				$_FILES['files']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['files']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['files']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['files']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['files']['size'] = $_FILES['foto']['size'][$i];
				
				$config=array(
					'file_name'=>$name.'_'.$i,
					'upload_path'=>'./upload/temp/',
					'allowed_types'=>'jpg|png|jpeg|bmp',
					'max_size'=>'0',
				);
				$this->upload->initialize($config);
				if($this->upload->do_upload('files')){
					$upload = $this->upload->data();
					$foto[$i]=array(
						'id_pju'=>$id,
						'nama_foto'=>$upload['file_name'],
					);
					$this->model_app->insertData('tbl_pju_foto',$foto[$i]);
					
					$image=array(
						'image_library'=>'gd2',
						'source_image'=>'./upload/temp/'.$upload['file_name'],
						'new_image'=>'./upload/foto/'.$upload['file_name'],
						'create_thumb'=>TRUE,
						'thumb_marker'=>'',
						'maintain_ratio' => TRUE,
						'width' => 600,
					);
					$this->image_lib->initialize($image);
					$this->image_lib->resize();
					$this->image_lib->clear();
				}
			}
		}
		
		$data=array(
			'id_jalan'=>$this->input->post('jalan'),
			'id_pel'=>$this->input->post('id_pel'),
			'no_gardu'=>$this->input->post('no_gardu'),
			'no_pal'=>$this->input->post('no_pal'),
			'jenis'=>$this->input->post('jenis'),
			'kwh'=>$this->input->post('kwh'),
			'daya'=>$this->input->post('daya'),
			'posisi'=>$this->input->post('posisi'),
			'kondisi'=>$this->input->post('kondisi'),
			'keterangan'=>$this->input->post('keterangan'),
			'lat'=>$this->input->post('lat'),
			'lng'=>$this->input->post('lng'),
		);
		$this->model_app->updateData('tbl_pju',$data,$id);
		redirect('adminpju');
	}
	
	public function hapus(){
		$id['id_pju'] = $this->uri->segment(3);
        $this->model_app->deleteData('tbl_pju',$id);
        redirect('adminpju');
	}
	
	public function peta(){
		$confmap = array(
			'center'=>'-6.99926531, 109.13596825',
			'zoom'=>11,
			'map_height'=>500,
			'map_type'=>'HYBRID',
		);
		$this->googlemaps->initialize($confmap);
		
		/*
		$pju = $this->model->getPetaPju();
		foreach($pju as $row){
			if($row->kondisi=='H'){
				$icon = base_url().'/assets/img/lampu-on.png';
			} else {
				$icon = base_url().'/assets/img/lampu-off.png';
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'infowindow_content'=>'<center><h6>'.$row->nama_jalan.'</h6></center><table><tr><td><b>ID PJU</b></td><td>: '.$row->id_pju.'</td></tr><tr><td><b>NAMA JALAN</b></td><td>: '.$row->nama_jalan.'</td></tr><tr><td><b>KECAMATAN</b></td><td>: '.$row->nama_kecamatan.'</td></tr><tr><td><b>JENIS LAMPU</b></td><td>: '.$row->jenis.'</td></tr><tr><td><b>DAYA LAMPU</b></td><td>: '.$row->daya.'</td></tr><tr><td><b>KONDISI LAMPU</b></td><td>: '.$row->kondisi.'</td></tr></table><br/><center><a href="'.site_url('adminpju/lihat/'.$row->id_pju).'">Lihat Selengkapnya</a></center>',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		*/
		
		$data=array(
			'title'=>'Peta Lampu PJU Kabupaten Tegal',
			'open_pju'=>'open',
			'pju_peta'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_jenis'=>$this->model->getAllJenisLampu(),
			'dt_kondisi'=>$this->model->getAllKondisiLampu(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_peta');
		$this->load->view('pages/v_footer');
	}
	
	public function fpeta(){
		if($this->input->post('kecamatan')!=""){
			$kec = $this->input->post('kecamatan');
		} else {
			$kec = "%%";
		}
		
		if($this->input->post('jalan')!=""){
			$jln = $this->input->post('jalan');
		} else {
			$jln = "%%";
		}
		
		if($this->input->post('jenis')!=""){
			$jns = $this->input->post('jenis');
		} else {
			$jns = "%%";
		}
		
		if($this->input->post('kondisi')!=""){
			$kds = $this->input->post('kondisi');
		} else {
			$kds = "%%";
		}
		
		$pju = $this->model_app->getFilterPeta($kec,$jln,$jns,$kds);
		
		$confmap = array(
			'center'=>'-6.99926531, 109.13596825',
			'zoom'=>'auto',
			'map_height'=>500,
			'map_type'=>'HYBRID',
		);
		$this->googlemaps->initialize($confmap);
		
		foreach($pju as $row){
			if($row->kondisi=='H'){
				$icon = base_url().'/assets/img/lampu-on.png';
			} else {
				$icon = base_url().'/assets/img/lampu-off.png';
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'infowindow_content'=>'<center><h6>'.$row->nama_jalan.'</h6></center><table><tr><td><b>ID PJU</b></td><td>: '.$row->id_pju.'</td></tr><tr><td><b>NAMA JALAN</b></td><td>: '.$row->nama_jalan.'</td></tr><tr><td><b>KECAMATAN</b></td><td>: '.$row->nama_kecamatan.'</td></tr><tr><td><b>JENIS LAMPU</b></td><td>: '.$row->jenis.'</td></tr><tr><td><b>DAYA LAMPU</b></td><td>: '.$row->daya.'</td></tr><tr><td><b>KONDISI LAMPU</b></td><td>: '.$row->kondisi.'</td></tr></table><br/><center><a href="'.site_url('adminpju/lihat/'.$row->id_pju).'">Lihat Selengkapnya</a></center><br/><center><a href="'.site_url('adminpju/edit/'.$row->id_pju).'">Edit PJU</a></center>',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		
		$data=array(
			'title'=>'Peta Lampu PJU Kabupaten Tegal',
			'open_pju'=>'open',
			'pju_peta'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_jenis'=>$this->model->getAllJenisLampu(),
			'dt_kondisi'=>$this->model->getAllKondisiLampu(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_peta');
		$this->load->view('pages/v_footer');
	}
	
	public function lihat(){
		$id = $this->uri->segment(3);
		$pju = $this->model_app->getLihatPju($id);
		
		foreach($pju as $row){
			$confmap = array(
				'map_height'=>400,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>18,
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
			'title'=>'Detail Lampu PJU',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_pju'=>$pju,
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pju/v_lihat_pju');
		$this->load->view('pages/v_footer');
	}
	
	public function get_jalan(){
		$id['id_kecamatan'] = $this->input->get('id', TRUE);
		$jalan = $this->model->getSelectedData('tbl_jalan',$id)->result();
		echo json_encode($jalan);
	}
}