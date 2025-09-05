<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app','model');
		$this->load->library('googlemaps');
	}
	
	public function index(){
		$confmap = array(
			'center'=>'-6.99926531, 109.13596825',
			'zoom'=>10,
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
			'aktif_peta'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_jenis'=>$this->model->getAllJenisLampu(),
			'dt_kondisi'=>$this->model->getAllKondisiLampu(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/peta/v_peta');
		$this->load->view('home/pages/v_footer');
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
		
		$pju = $this->model_app->getFilterPetaPublik($kec,$jln);
		
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
				'infowindow_content'=>'<center><h6>'.$row->nama_jalan.'</h6></center><table><tr><td><b>ID PJU</b></td><td>: '.$row->id_pju.'</td></tr><tr><td><b>NAMA JALAN</b></td><td>: '.$row->nama_jalan.'</td></tr><tr><td><b>KECAMATAN</b></td><td>: '.$row->nama_kecamatan.'</td></tr><tr><td><b>JENIS LAMPU</b></td><td>: '.$row->jenis.'</td></tr><tr><td><b>DAYA LAMPU</b></td><td>: '.$row->daya.'</td></tr><tr><td><b>KONDISI LAMPU</b></td><td>: '.$row->kondisi.'</td></tr></table><center><a href="'.site_url('peta/lihat/'.$row->id_pju).'" target="_blank">Lihat Selengkapnya</a></center></center>',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		$data=array(
			'title'=>'Peta Lampu PJU Kabupaten Tegal',
			'aktif_peta'=>'active',
			'dt_pju'=>$this->model->getGroupFilterPeta($kec,$jln),
			'dt_jln'=>$jln,
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_jenis'=>$this->model->getAllJenisLampu(),
			'dt_kondisi'=>$this->model->getAllKondisiLampu(),
			'peta'=>$this->googlemaps->create_map(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/peta/v_peta');
		$this->load->view('home/pages/v_footer');
	}
	
	public function lihat(){
		$id = $this->uri->segment(3);
		$pju = $this->model_app->getLihatPju($id);
		
		foreach($pju as $row){
			$confmap = array(
				'map_height'=>300,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>19,
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
			'title'=>'Lihat Lampu PJU',
			'aktif_peta'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_pju'=>$pju,
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/peta/v_lihat_peta');
		$this->load->view('home/pages/v_footer');
	}
	
	public function get_jalan(){
		$id['id_kecamatan'] = $this->input->get('id', TRUE);
		$jalan = $this->model->getSelectedData('tbl_jalan',$id)->result();
		echo json_encode($jalan);
	}
}