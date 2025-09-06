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

	
	public function index()
    {
        helper('text'); // buat word_limiter di view

        // ambil segment ke-3 untuk pagination offset
        $dari = $this->request->getUri()->getTotalSegments() >= 3 
            ? (int) $this->request->getUri()->getSegment(3) 
            : 0;

        $perPage = 12; 
        $num     = $this->model->getJmlPengaduan();

        // data dari model
        $pengaduan = $this->model->getAllPengaduan($perPage, $dari);

        // pagination bawaan CI4
        $pager = \Config\Services::pager();
        $links = $pager->makeLinks($dari, $perPage, $num, 'default_full');

        $data = [
            'title'           => 'Pengaduan Lampu Penerangan Jalan Umum',
            'pengaduan'       => 'active',
            'aktif_pengaduan' => 'active',
            'dt_pengaduan'    => $pengaduan,
            'pager'           => $links,
        ];

        return view('home/pages/v_header', $data)
             . view('home/pengaduan/v_pengaduan', $data)
             . view('home/pages/v_footer');
    }

	
		public function input(){
			$data = [
			'title'           => 'Input Pengaduan Lampu Penerangan Jalan Umum',
			'pengaduan'       => 'active',
			'aktif_pengaduan' => 'active',
		];

		return view('home/pages/v_header', $data)
			. view('home/pengaduan/v_pengaduan_input', $data)
			. view('home/pages/v_footer');
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
		return $short_url->id;
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
			$data = [
				'title'           => 'Input Pengaduan Lampu Penerangan Jalan Umum',
				'aktif_pengaduan' => 'active',
				'error'           => $this->upload->display_errors(),
			];

			return view('home/pages/v_header', $data)
				. view('home/pengaduan/v_pengaduan_input', $data)
				. view('home/pages/v_footer');

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
		return view('home/pages/v_header',$data);
		return view('home/pengaduan/v_pengaduan_lihat');
		return view('home/pages/v_footer');
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