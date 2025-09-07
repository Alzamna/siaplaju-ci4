<?php

namespace App\Controllers;

use App\Models\Model_backend;
use CodeIgniter\Controller;

class Adminpengaduan extends BaseController
{
    protected $model;
    protected $pager;
    protected $googlemaps;
    protected $upload;
    protected $image;

    public function __construct()
    {
        $this->model = new Model_backend();

        $this->pager      = \Config\Services::pager();      
        $this->googlemaps = new \App\Libraries\Googlemaps(); 
        $this->upload     = \Config\Services::upload();     
        $this->image      = \Config\Services::image();      

        helper(['text', 'form']);

        $session = session();
        if ($session->get('login') != 1) {
            redirect()->to('login')->send(); 
            exit;
        }
	}
	
	public function index()
	{
		$perPage = 20; 

		$page = $this->request->getUri()->getSegment(2); 
		$dari = ($page && is_numeric($page)) ? ($page - 1) * $perPage : 0;

		$total = $this->model->getJmlPengaduan();

		$dt_pengaduan = $this->model->getAllPengaduan($perPage, $dari);

		$pager = \Config\Services::pager();
		$pagerConfig = [
			'base_url' => base_url('adminpengaduan'),
			'total' => $total,
			'perPage' => $perPage,
			'page' => $page ?: 1,
		];

		$data = [
			'title' => 'Pengaduan LPJU Kabupaten Tegal',
			'open_pengaduan' => 'open',
			'pengaduan_data' => 'active',
			'dt_pengaduan' => $dt_pengaduan,
			'pager' => $pager->makeLinks($page ?: 1, $perPage, $total),
			'start' => $dari,
		];

		echo view('pages/v_header', $data);
		echo view('pengaduan/v_pengaduan', $data);
		echo view('pages/v_footer', $data);
	}

	
	public function verifikasi(){
		$id = $this->request->getUri()->getSegment(3);
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
			'title'=>'Verifikasi Pengaduan LPJU',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_pengaduan'=>$this->model->getDataPengaduan($id),
			'peta'=>$this->googlemaps->create_map(),
		);
		return view('pages/v_header',$data);
		return view('pengaduan/v_verifikasi');
		return view('pages/v_footer');
	}
	
	public function proses_verifikasi(){
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$id = $this->request->getUri()->getSegment(3);
		$tgl = date('Y-m-d H:i:s');
		$data=array(
			'id_jalan'=>$this->request->getPost('jalan'),
			'laporan'=>$this->request->getPost('laporan'),
			'media'=>$this->request->getPost('media'),
			'lat'=>$this->request->getPost('lat'),
			'lng'=>$this->request->getPost('lng'),
			'status'=>2,
			'aktif'=>1,
		);
		$tindakan=array(
			'id_pengaduan'=>$id,
			'tgl_tindakan'=>$tgl,
			'tindakan'=>$this->request->getPost('tindakan'),
		);
		$status=array(
			'id_pengaduan'=>$id,
			'status'=>2,
			'keterangan'=>'Pengaduan Diverifikasi',
			'tgl_status'=>$tgl,
		);
		$this->model->updateData('tbl_pengaduan',$data,$idx);
		$this->model->insertData('tbl_tindakan',$tindakan);
		$this->model->insertData('tbl_pengaduan_status',$status);
		redirect('adminpengaduan');
	}
	
	public function proses_pengaduan(){
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$id = $this->request->getUri()->getSegment(3);
		$tgl = date('Y-m-d H:i:s');
		$data=array(
			'status'=>3,
		);
		$tindakan=array(
			'id_pengaduan'=>$id,
			'tgl_tindakan'=>$tgl,
			'tindakan'=>$this->request->getPost('tindakan'),
		);
		$status=array(
			'id_pengaduan'=>$id,
			'status'=>3,
			'keterangan'=>'Pengaduan Dalam Proses',
			'tgl_status'=>$tgl,
		);
		$this->model->updateData('tbl_pengaduan',$data,$idx);
		$this->model->insertData('tbl_tindakan',$tindakan);
		$this->model->insertData('tbl_pengaduan_status',$status);
		redirect('adminpengaduan');
	}
	
	public function inputperbaikan(){
		$id = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$pgn = $this->model->getJalanPengaduan($id);
		
		foreach($pgn as $row){
			$confmap = array(
				'map_height'=>350,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>19,
			);
			$this->googlemaps->initialize($confmap);
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'animation'=>'DROP',
				'icon'=> base_url().'/assets/img/lampu-repair.png',
			);
			$this->googlemaps->add_marker($marker);
		}
		$data=array(
			'title'=>'Input Hasil Pengaduan',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_pengaduan'=>$pgn,
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_perbaikan')
		. view('pages/v_footer');
	}
	
	public function proses_perbaikan(){
		$id = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$dtpengaduan = $this->model->getSelectedData('tbl_pengaduan',$idx)	;
		foreach($dtpengaduan as $row){
			$nama = $row->pelapor;
			$telp = $row->no_telp;
		}
		$tgl = $this->request->getPost('tgl_perbaikan');
		if(!empty($_FILES['foto']['name'])){
			$length = count($_FILES['foto']['name']);
			for($i = 0; $i < $length; $i++){
				$_FILES['files']['name'] = $_FILES['foto']['name'][$i];
                $_FILES['files']['type'] = $_FILES['foto']['type'][$i];
                $_FILES['files']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                $_FILES['files']['error'] = $_FILES['foto']['error'][$i];
                $_FILES['files']['size'] = $_FILES['foto']['size'][$i];
				
				$config=array(
					'file_name'=>$id.'_MT'.$i,
					'upload_path'=>'./upload/temp/',
					'allowed_types'=>'jpg|png|jpeg|bmp',
					'max_size'=>'0',
				);
				$this->upload->initialize($config);
				if($this->upload->do_upload('files')){
					$upload = $this->upload->data();
					$foto[$i]=array(
						'id_pengaduan'=>$id,
						'nama_foto'=>$upload['file_name'],
					);
					$this->model->insertData('tbl_tindakan_foto',$foto[$i]);
					
					$image = \Config\Services::image()
					->withFile('./upload/temp/' . $upload['file_name'])
					->resize(600, 600, true, 'auto') // maintain_ratio TRUE
					->save('./upload/foto/perbaikan/' . $upload['file_name']);

				}
			}
		}

		$data=array(
			'status'=>4,
		);
		$tindakan=array(
			'id_pengaduan'=>$id,
			'tgl_tindakan'=>$tgl,
			'tindakan'=>$this->request->getPost('tindakan'),
		);
		$status=array(
			'id_pengaduan'=>$id,
			'status'=>4,
			'keterangan'=>'Pengaduan Selesai Diproses',
			'tgl_status'=>$tgl,
		);
		$this->model->updateData('tbl_pengaduan',$data,$idx);
		$this->model->insertData('tbl_tindakan',$tindakan);
		$this->model->insertData('tbl_pengaduan_status',$status);
		//$this->kirimsurvey($id,$nama,$telp);
		redirect('adminpengaduan');
	}
	
	public function lihat(){
		$id = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$pgn = $this->model->getJalanPengaduan($id);
		
		foreach($pgn as $row){
			$confmap = array(
				'map_height'=>350,
				'map_type'=>'HYBRID',
				'center'=>$row->lat.','.$row->lng,
				'zoom'=>17,
			);
			$this->googlemaps->initialize($confmap);
			if($row->status=='2'){
				$icon = base_url().'/assets/img/lampu-off.png';
			} else if($row->status=='3'){
				$icon = base_url().'/assets/img/lampu-repair.png';
			} else if($row->status=='4'){
				$icon = base_url().'/assets/img/lampu-fix.png';
			} else {
				$icon = "";
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'animation'=>'DROP',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		$data=array(
			'title'=>'Lihat Pengaduan',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_pengaduan'=>$pgn,
			'dt_status'   => $this->model->getSelectedData('tbl_pengaduan_status', $idx),
			'dt_tindakan' => $this->model->getSelectedData('tbl_tindakan', $idx),
			'dt_foto'     => $this->model->getSelectedData('tbl_tindakan_foto', $idx),
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_lihat_pengaduan')
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
			'title'=>'Tambah Perbaikan Lampu PJU',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'peta'=>$this->googlemaps->create_map(),
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_tambah_pengaduan')
		. view('pages/v_footer');
	}
	
	public function proses_tambah(){
		$tgl = date("Y-m-d",strtotime($this->request->getPost('tgl_pengaduan')));
		$id = $this->model->getKodePengaduan();
		if(empty($_FILES['foto']['name'])){
			$data=array(
				'id_pengaduan'=>$id,
				'pelapor'=>$this->request->getPost('nama'),
				'no_telp'=>$this->request->getPost('telp'),
				'id_jalan'=>$this->request->getPost('jalan'),
				'laporan'=>$this->request->getPost('laporan'),
				'media'=>$this->request->getPost('media'),
				'tgl_pengaduan'=>$tgl,
				'lat'=>$this->request->getPost('lat'),
				'lng'=>$this->request->getPost('lng'),
				'status'=>3,
				'aktif'=>1,
			);
			$status=array(
				'id_pengaduan'=>$id,
				'status'=>3,
				'keterangan'=>'Pengaduan Dalam Proses',
				'tgl_status'=>$tgl,
			);
			$tindakan=array(
				'id_pengaduan'=>$id,
				'tgl_tindakan'=>$tgl,
				'tindakan'=>$this->request->getPost('tindakan'),
			);
			$this->model->insertData('tbl_pengaduan',$data);
			$this->model->insertData('tbl_pengaduan_status',$status);
			$this->model->insertData('tbl_tindakan',$tindakan);
		} else {
			$config=array(
				'upload_path'=>'./upload/temp/',
				'allowed_types'=>'gif|jpg|png|jpeg|bmp',
				'max_size'=>'10240',
				'file_name'=>$id,
			);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload($foto='foto')){
				$data=array(
					'title'=>'Tambah Perbaikan Lampu PJU',
					'open_pengaduan'=>'open',
					'pengaduan_data'=>'active',
					'error'=> $this->upload->display_errors(),
					'dt_kecamatan'=>$this->model->getAllKecamatan(),
					'peta'=>$this->googlemaps->create_map(),
				);
				return view('pages/v_header',$data)
				. view('pengaduan/v_tambah_pengaduan')
				. view('pages/v_footer');
			} else {
				$upload = $this->upload->data();
				$data=array(
					'id_pengaduan'=>$id,
					'pelapor'=>$this->request->getPost('nama'),
					'no_telp'=>$this->request->getPost('telp'),
					'id_jalan'=>$this->request->getPost('jalan'),
					'laporan'=>$this->request->getPost('laporan'),
					'tgl_pengaduan'=>$tgl,
					'lat'=>$this->request->getPost('lat'),
					'lng'=>$this->request->getPost('lng'),
					'status'=>3,
					'aktif'=>1,
					'foto'=>$upload['file_name'],
				);
				$status=array(
					'id_pengaduan'=>$id,
					'status'=>3,
					'keterangan'=>'Pengaduan Dalam Proses',
					'tgl_status'=>$tgl,
				);
				$tindakan=array(
					'id_pengaduan'=>$id,
					'tgl_tindakan'=>$tgl,
					'tindakan'=>$this->request->getPost('tindakan'),
				);
				$this->model->insertData('tbl_pengaduan',$data);
				$this->model->insertData('tbl_pengaduan_status',$status);
				$this->model->insertData('tbl_tindakan',$tindakan);
				$image = \Config\Services::image()
				->withFile('./upload/temp/' . $upload['file_name'])
				->resize(1200, 800, true, 'auto') // maintain_ratio TRUE
				->save('./upload/foto/pengaduan/' . $upload['file_name']);

			}
		}
		redirect('adminpengaduan');
	}
	
	public function peta(){
		$confmap = array(
			'center'=>'-6.99926531,109.13596825',
			'zoom'=>'auto',
			'map_height'=>500,
			'map_type'=>'HYBRID',
		);
		$this->googlemaps->initialize($confmap);
		
		$pgn = $this->model->getPetaPengaduan();
		foreach($pgn as $row){
			if($row->status=='2'){
				$icon = base_url().'/assets/img/lampu-off.png';
			} else if($row->status=='3'){
				$icon = base_url().'/assets/img/lampu-repair.png';
			} else if($row->status=='4'){
				$icon = base_url().'/assets/img/lampu-fix.png';
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'infowindow_content'=>'<center><h6>'.$row->id_pengaduan.'</h6></center><table><tr><td><b>ID PENGADUAN</b></td><td>: '.$row->id_pengaduan.'</td></tr><tr><td><b>TGL PENGADUAN</b></td><td>: '.date("d M Y H:i:s",strtotime($row->tgl_pengaduan)).'</td></tr><tr><td><b>PELAPOR</b></td><td>: '.$row->pelapor.'</td></tr><tr><td><b>RUAS JALAN</b></td><td>: '.$row->nama_jalan.'</td></tr></table><br/><center><a href="'.site_url('adminpengaduan/lihat/'.$row->id_pengaduan).'">Lihat Selengkapnya</a></center>',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		
		$data=array(
			'title'=>'Peta Pengaduan PJU Kabupaten Tegal',
			'open_pengaduan'=>'open',
			'pengaduan_peta'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'peta'=>$this->googlemaps->create_map(),
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_peta')
		. view('pages/v_footer');
	}
	
	public function cari(){
		$id = $this->request->getPost('cari');
		$data=array(
			'title'=>'Pengaduan LPJU Kabupaten Tegal',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'dt_pengaduan'=>$this->model->getCariPengaduan($id),
			'start'=>0,
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_pengaduan')
		. view('pages/v_footer');
	}
	
	public function tolak(){
		$id['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$tgl = date('Y-m-d H:i:s');

		$data=array(
			'aktif'=>0,
			'status'=>0,
		);
        $tindakan=array(
			'id_pengaduan'=>$id,
			'tgl_tindakan'=>$tgl=date('Y-m-d H:i:s'),
			'tindakan'=>$this->request->getPost('tindakan'),
		);
		$status=array(
			'id_pengaduan'=>$id,
			'status'=>0,
			'keterangan'=>'Pengaduan Ditolak',
			'tgl_status'=>$tgl,
		);
		$this->model->updateData('tbl_pengaduan',$data,$idx);
		$this->model->insertData('tbl_tindakan',$tindakan);
		$this->model->insertData('tbl_pengaduan_status',$status);
		redirect('adminpengaduan');
	}
	
	public function hapus(){
		$id['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$table = array('tbl_pengaduan','tbl_tindakan','tbl_tindakan_foto','tbl_pengaduan_status');
        $this->model->deleteData($table,$id);
        redirect('adminpengaduan');
	}
	
	public function edit(){
		$id = $this->request->getUri()->getSegment(3);
		$pgn = $this->model->getJalanPengaduan($id);
		foreach($pgn as $row){
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
			if($row->status=='2'){
				$icon = base_url().'/assets/img/lampu-off.png';
			} else if($row->status=='3'){
				$icon = base_url().'/assets/img/lampu-repair.png';
			} else if($row->status=='4'){
				$icon = base_url().'/assets/img/lampu-fix.png';
			} else {
				$icon = "";
			}
			$marker=array(
				'position'=>$row->lat.','.$row->lng,
				'animation'=>'DROP',
				'icon'=>$icon,
			);
			$this->googlemaps->add_marker($marker);
		}
		
		$data=array(
			'title'=>'Edit Pengaduan LPJU',
			'open_pengaduan'=>'open',
			'pengaduan_data'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_pengaduan'=>$this->model->getJalanPengaduan($id),
			'peta'=>$this->googlemaps->create_map(),
		);
		return view('pages/v_header',$data)
		. view('pengaduan/v_edit_pengaduan')
		. view('pages/v_footer');
	}
	
	public function proses_edit(){
		$id = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$data=array(
			'id_jalan'=>$this->request->getPost('jalan'),
			'laporan'=>$this->request->getPost('laporan'),
			'media'=>$this->request->getPost('media'),
			'lat'=>$this->request->getPost('lat'),
			'lng'=>$this->request->getPost('lng'),
		);	
		$this->model->updateData('tbl_pengaduan',$data,$idx);
		redirect('adminpengaduan/lihat/'.$id);
	}
	
	private function kirimsurvey($id,$nama,$telp){
		$curl = curl_init();
		$token = "QFwj8Vv0WtXpoaDa3N364PoACrhZCkaESjzkpKKDHs9XnaoeR17jiKA9vd0DAH74";
		$data = [
			'phone' => $telp,
			'message' => '*[SIAPLAJU]*'. PHP_EOL .''. PHP_EOL .'Hi sdr/i *'.$nama.'*, '. PHP_EOL .'Pengaduan anda telah selesai di proses. Silahkan klik link dibawah ini untuk melihat pengaduan anda.'. PHP_EOL .'<a>'.base_url('pengaduan/lihat/'.$id).'</a> '. PHP_EOL .''. PHP_EOL .'Guna meningkatkan kualitas pelayanan kami. Mohon kesediaan waktunya untuk mengisi formulir survey kepuasan masyarakat pada link dibawah ini. '. PHP_EOL .'<a>http://webgis.siaplaju.com/survey</a> '. PHP_EOL .''. PHP_EOL .'Terima kasih. '. PHP_EOL .'Dishub Kab. Tegal',
		];
		
		curl_setopt($curl, CURLOPT_HTTPHEADER,
			array(
				"Authorization: $token",
			)
		);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_URL, "https://console.wablas.com/api/send-message");
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
	}
}