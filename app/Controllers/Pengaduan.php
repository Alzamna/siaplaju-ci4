<?php 
namespace App\Controllers;

use App\Models\Model;
use App\Models\Model_app;

class Pengaduan extends BaseController
{
    protected $model;
    protected $googlemaps;
    protected $pagination;
    protected $upload;
    protected $imageLib;
	protected $session;


    public function __construct()
    {
        $this->model = new Model_app();
        $this->googlemaps = service('googlemaps'); 
        $this->pagination = \Config\Services::pager(); 
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
    }

	
	public function index(){
		if ($this->request->getUri()->getSegment(3) == null) {
			$dari = 0;
		} else {
			$dari = $this->request->getUri()->getSegment(3);
		}

		
		$num = $this->model->getJmlPengaduan();
		$router = service('router');
		$config=array(
			'base_url' => base_url($router->controllerName() . '/' . $router->methodName()),
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
			'title'=>'Pengaduan Lampu Penerangan Jalan Umum',
			'pengaduan'=>'active',
			'aktif_pengaduan'=>'active',
			'dt_pengaduan'=>$this->model->getAllPengaduan($config['per_page'],$dari),
		);
		$this->pagination->initialize($config);
		echo view('home/pages/v_header',$data);
		echo view('home/pengaduan/v_pengaduan');
		echo view('home/pages/v_footer');
	}
	
	public function input(){
		$data=array(
			'title'=>'Input Pengaduan Lampu Penerangan Jalan Umum',
			'pengaduan'=>'active',
			'aktif_pengaduan'=>'active',
		);
		echo view('home/pages/v_header',$data);
		echo view('home/pengaduan/v_pengaduan_input');
		echo view('home/pages/v_footer');
	}
	
	public function proses_input_pengaduan(){
		$id = $this->model->getKodePengaduan();
		$nama = $this->request->getPost('nama');
		$phone = $this->request->getPost('telp');
		$pertama = mb_substr($phone, 0, 1);
		if($pertama=="0"){
			$telp = substr_replace($phone,'62',0,1);
		} else {
			$telp = $phone;
		}
		
		/*
		$link = "siaplaju.com/pengaduan/lihat/".$id;
		$this->google_url_api->enable_debug(TRUE);
		$short_url = $this->google_url_api->shorten($link);
		echo $short_url->id;
		*/
		
		$foto = 'foto';
		if(empty($_FILES['foto']['name'])){
			$data=array(
				'id_pengaduan'=>$id,
				'pelapor'=>$nama,
				'no_telp'=>$telp,
				'laporan'=>$this->request->getPost('isi'),
				'tgl_pengaduan'=>date('Y-m-d H:i:s'),
				'status'=>1,
			);
			$status=array(
				'id_pengaduan'=>$id,
				'status'=>1,
				'keterangan'=>'Pengaduan Diterima',
				'tgl_status'=>date('Y-m-d H:i:s'),
			);
			$this->model->insertData('tbl_pengaduan_status',$status);
			$this->model->insertData('tbl_pengaduan',$data);
			//$this->kirimpengaduan($id,$nama,$telp);
		} else {
			$config=array(
				'upload_path'=>'./upload/temp/',
				'allowed_types'=>'gif|jpg|png|jpeg|bmp',
				'max_size'=>'10240',
				'file_name'=>$id,
			);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload($foto)){
				$data=array(
					'title'=>'Input Pengaduan Lampu Penerangan Jalan Umum',
					'aktif_pengaduan'=>'active',
					'error'=> $this->upload->display_errors(),
				);
				echo view('home/pages/v_header',$data);
				echo view('home/pengaduan/v_pengaduan_input');
				echo view('home/pages/v_footer');
			} else {
				$upload = $this->upload->data();
				$data=array(
					'id_pengaduan'=>$id,
					'pelapor'=>$this->request->getPost('nama'),
					'no_telp'=>$this->request->getPost('telp'),
					'laporan'=>$this->request->getPost('isi'),
					'tgl_pengaduan'=>date('Y-m-d H:i:s'),
					'status'=>1,
					'foto'=>$upload['file_name'],
				);
				$status=array(
					'id_pengaduan'=>$id,
					'status'=>1,
					'keterangan'=>'Pengaduan Diterima',
					'tgl_status'=>date('Y-m-d H:i:s'),
				);
				$this->model->insertData('tbl_pengaduan_status',$status);
				$this->model->insertData('tbl_pengaduan',$data);
				//$this->kirimpengaduan($id,$nama,$telp);
				$imageService = \Config\Services::image()
				->withFile('./upload/temp/' . $upload['file_name'])
				->resize(1200, 800, true, 'height') 
				->save('./upload/foto/pengaduan/' . $upload['file_name']);

			}
		}
		session()->setFlashdata('sukses', '<script>alert("Terima kasih laporan anda berhasil terkirim, Admin kami akan memverifikasi dan menampilkan laporan anda dalam 1x24 jam. Mohon untuk tidak menginputkan pengaduan yang sama.");</script>');
		redirect('pengaduan');
	}
	
	public function lihat(){
		$id = $this->request->getUri()->getSegment(3);
		$idx['id_pengaduan'] = $this->request->getUri()->getSegment(3);
		$pgn = $this->model->getLihatPengaduan($id);
		
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
			'pengaduan'=>'active',
			'aktif_pengaduan'=>'active',
			'peta'=>$this->googlemaps->create_map(),
			'dt_pengaduan'=>$pgn,
			'dt_status'   => $this->model->getSelectedData('tbl_pengaduan_status', $idx),
			'dt_tindakan' => $this->model->getSelectedData('tbl_tindakan', $idx),
			'dt_foto'     => $this->model->getSelectedData('tbl_tindakan_foto', $idx),

		);
		echo view('home/pages/v_header',$data);
		echo view('home/pengaduan/v_pengaduan_lihat');
		echo view('home/pages/v_footer');
	}
	
	public function get_jalan()
	{
		$id = ['id_kecamatan' => $this->request->getGet('id')];
		$jalan = $this->model->getSelectedData('tbl_jalan', $id); // sudah array of object
		return $this->response->setJSON($jalan);
	}


	
	private function kirimpengaduan($id,$nama,$telp){
		$curl = curl_init();
		$token = "QFwj8Vv0WtXpoaDa3N364PoACrhZCkaESjzkpKKDHs9XnaoeR17jiKA9vd0DAH74";
		$data = [
			'phone' => $telp,
			'message' => '*[SIAPLAJU]*'. PHP_EOL .''. PHP_EOL .'Hi sdr/i *'.$nama.'*,'. PHP_EOL .'Pengaduan anda telah kami terima dengan nomor pengaduan '.$id.'. '. PHP_EOL .'Silahkan klik link dibawah ini untuk melacak proses pengaduan anda. '. PHP_EOL .'<a>'.base_url('pengaduan/lihat/'.$id).'</a> '. PHP_EOL .''. PHP_EOL .'Terima kasih. '. PHP_EOL .'Dishub Kab. Tegal | http://siaplaju.com',
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