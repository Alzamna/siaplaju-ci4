<?php

namespace App\Controllers;

use App\Models\Model_backend;
use CodeIgniter\Controller;
use Config\Services;

class Adminpju extends BaseController
{
    protected $model;
    protected $pagination;
    protected $googlemaps;
    protected $upload;

    public function __construct()
    {
        $this->model = new Model_backend();

        helper(['text']); 
        $this->pagination = Services::pager();
        $this->googlemaps = new \App\Libraries\Googlemaps();
        $this->upload = Services::upload();

        $session = session();
        if ($session->get('login') != 1) {
            return redirect()->to(base_url('login'));
        }
    }

	
	public function index()
	{
		$perPage = 20;
		$page = (int) ($this->request->getGet('page') ?? 1); // ambil ?page=
		$offset = ($page - 1) * $perPage;

		$num = $this->model->getJmlPju();
		$pju = $this->model->getAllPju($perPage, $offset);

		$pager = \Config\Services::pager();
		$pager->makeLinks($page, $perPage, $num);

		$data = [
			'title' => 'Data PJU',
			'dt_pju' => $pju,
			'pager'  => $pager,
			'start'  => $offset
		];

		return view('pages/v_header', $data)
			. view('pju/v_pju', $data)
			. view('pages/v_footer');
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
		return view('pages/v_header', $data)
		. view('pju/v_tambah_pju', $data)
		. view('pages/v_footer');
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
					$this->model->insertData('tbl_pju_foto',$foto[$i]);
					
					$image = \Config\Services::image()
					->withFile('./upload/temp/' . $upload['file_name'])
					->resize(600, 600, true, 'auto')   // maintain_ratio = TRUE
					->save('./upload/foto/' . $upload['file_name']);

				}
			}
		}
		
		$data=array(
			'id_jalan'=>$this->request->getPost('jalan'),
			'id_pel'=>$this->request->getPost('id_pel'),
			'no_gardu'=>$this->request->getPost('no_gardu'),
			'no_pal'=>$this->request->getPost('no_pal'),
			'jenis'=>$this->request->getPost('jenis'),
			'kwh'=>$this->request->getPost('kwh'),
			'daya'=>$this->request->getPost('daya'),
			'posisi'=>$this->request->getPost('posisi'),
			'kondisi'=>$this->request->getPost('kondisi'),
			'keterangan'=>$this->request->getPost('keterangan'),
			'lat'=>$this->request->getPost('lat'),
			'lng'=>$this->request->getPost('lng'),
		);
		$this->model->insertData('tbl_pju',$data);
		redirect('adminpju');
	}
	
	public function cari(){
		$id = $this->request->getPost('cari');
		$data=array(
			'title'=>'Data PJU Kabupaten Tegal',
			'open_pju'=>'open',
			'pju_data'=>'active',
			'dt_pju'=>$this->model->getCariPju($id),
			'start'=>0,
		);
		return view('pages/v_header', $data)
		. view('pju/v_pju', $data)
		. view('pages/v_footer');
	}
	
	public function edit(){
		$id = $this->request->getUri()->getSegment(3);
		$pju = $this->model->getDataPju($id);
		
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
		return view('pages/v_header', $data)
		. view('pju/v_edit_pju', $data)
		. view('pages/v_footer');
	}
	
	public function proses_edit(){
		$id['id_pju'] = $this->request->getUri()->getSegment(3);
		
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
					$this->model->insertData('tbl_pju_foto',$foto[$i]);
					
					$image = \Config\Services::image()
					->withFile('./upload/temp/' . $upload['file_name'])
					->resize(600, 600, true, 'auto') 
					->save('./upload/foto/' . $upload['file_name']);

				}
			}
		}
		
		$data=array(
			'id_jalan'=>$this->request->getPost('jalan'),
			'id_pel'=>$this->request->getPost('id_pel'),
			'no_gardu'=>$this->request->getPost('no_gardu'),
			'no_pal'=>$this->request->getPost('no_pal'),
			'jenis'=>$this->request->getPost('jenis'),
			'kwh'=>$this->request->getPost('kwh'),
			'daya'=>$this->request->getPost('daya'),
			'posisi'=>$this->request->getPost('posisi'),
			'kondisi'=>$this->request->getPost('kondisi'),
			'keterangan'=>$this->request->getPost('keterangan'),
			'lat'=>$this->request->getPost('lat'),
			'lng'=>$this->request->getPost('lng'),
		);
		$this->model->updateData('tbl_pju',$data,$id);
		redirect('adminpju');
	}
	
	public function hapus(){
		$id['id_pju'] = $this->request->getUri()->getSegment(3);
        $this->model->deleteData('tbl_pju',$id);
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
		return view('pages/v_header', $data)
		. view('pju/v_peta', $data)
		. view('pages/v_footer');
	}
	
	public function fpeta(){
		if($this->request->getPost('kecamatan')!=""){
			$kec = $this->request->getPost('kecamatan');
		} else {
			$kec = "%%";
		}
		
		if($this->request->getPost('jalan')!=""){
			$jln = $this->request->getPost('jalan');
		} else {
			$jln = "%%";
		}
		
		if($this->request->getPost('jenis')!=""){
			$jns = $this->request->getPost('jenis');
		} else {
			$jns = "%%";
		}
		
		if($this->request->getPost('kondisi')!=""){
			$kds = $this->request->getPost('kondisi');
		} else {
			$kds = "%%";
		}
		
		$pju = $this->model->getFilterPeta($kec,$jln,$jns,$kds);
		
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
		return view('pages/v_header', $data)
		. view('pju/v_peta', $data)
		. view('pages/v_footer');
	}
	
	public function lihat(){
		$id = $this->request->getUri()->getSegment(3);
		$pju = $this->model->getLihatPju($id);
		
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
		return view('pages/v_header', $data)
		. view('pju/v_lihat_pju', $data)
		. view('pages/v_footer');
	}
	
	public function get_jalan(){
		$id['id_kecamatan'] = $this->request->getPost('id', TRUE);
		$jalan = $this->model->getSelectedData('tbl_jalan',$id)->getResult();
		echo json_encode($jalan);
	}

	
}