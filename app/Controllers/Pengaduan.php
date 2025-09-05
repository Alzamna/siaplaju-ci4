<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('model_app','model');
		$this->load->library('googlemaps');
		$this->load->library('pagination');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('text');
	}
	
	public function index(){
		if($this->uri->segment(3)==FALSE){
			$dari = 0;
		} else {
			$dari = $this->uri->segment(3);
		};
		
		$num = $this->model_app->getJmlPengaduan();
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
			'title'=>'Pengaduan Lampu Penerangan Jalan Umum',
			'pengaduan'=>'active',
			'aktif_pengaduan'=>'active',
			'dt_pengaduan'=>$this->model_app->getAllPengaduan($config['per_page'],$dari),
		);
		$this->pagination->initialize($config);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/pengaduan/v_pengaduan');
		$this->load->view('home/pages/v_footer');
	}
	
	public function input(){
		$data=array(
			'title'=>'Input Pengaduan Lampu Penerangan Jalan Umum',
			'pengaduan'=>'active',
			'aktif_pengaduan'=>'active',
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/pengaduan/v_pengaduan_input');
		$this->load->view('home/pages/v_footer');
	}
	
	public function proses_input_pengaduan(){
		$id = $this->model_app->getKodePengaduan();
		$nama = $this->input->post('nama');
		$phone = $this->input->post('telp');
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
				'laporan'=>$this->input->post('isi'),
				'tgl_pengaduan'=>date('Y-m-d H:i:s'),
				'status'=>1,
			);
			$status=array(
				'id_pengaduan'=>$id,
				'status'=>1,
				'keterangan'=>'Pengaduan Diterima',
				'tgl_status'=>date('Y-m-d H:i:s'),
			);
			$this->model_app->insertData('tbl_pengaduan_status',$status);
			$this->model_app->insertData('tbl_pengaduan',$data);
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
				$this->load->view('home/pages/v_header',$data);
				$this->load->view('home/pengaduan/v_pengaduan_input');
				$this->load->view('home/pages/v_footer');
			} else {
				$upload = $this->upload->data();
				$data=array(
					'id_pengaduan'=>$id,
					'pelapor'=>$this->input->post('nama'),
					'no_telp'=>$this->input->post('telp'),
					'laporan'=>$this->input->post('isi'),
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
				$this->model_app->insertData('tbl_pengaduan_status',$status);
				$this->model_app->insertData('tbl_pengaduan',$data);
				//$this->kirimpengaduan($id,$nama,$telp);
				$image=array(
					'image_library'=>'gd2',
					'source_image'=>'./upload/temp/'.$upload['file_name'],
					'new_image'=>'./upload/foto/pengaduan/'.$upload['file_name'],
					'create_thumb'=>TRUE,
					'thumb_marker'=>'',
					'maintain_ratio' => TRUE,
					'width' => 1200,
					'height' => 800,
				);
				$this->image_lib->initialize($image);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}
		}
		$this->session->set_flashdata('sukses', '<script>alert("Terima kasih laporan anda berhasil terkirim, Admin kami akan memverifikasi dan menampilkan laporan anda dalam 1x24 jam. Mohon untuk tidak menginputkan pengaduan yang sama.");</script>');
		redirect('pengaduan');
	}
	
	public function lihat(){
		$id = $this->uri->segment(3);
		$idx['id_pengaduan'] = $this->uri->segment(3);
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
			'dt_status'=>$this->model->getSelectedData('tbl_pengaduan_status',$idx)->result(),
			'dt_tindakan'=>$this->model->getSelectedData('tbl_tindakan',$idx)->result(),
			'dt_foto'=>$this->model->getSelectedData('tbl_tindakan_foto',$idx)->result(),
		);
		$this->load->view('home/pages/v_header',$data);
		$this->load->view('home/pengaduan/v_pengaduan_lihat');
		$this->load->view('home/pages/v_footer');
	}
	
	public function get_jalan(){
		$id['id_kecamatan'] = $this->input->get('id', TRUE);
		$jalan = $this->model->getSelectedData('tbl_jalan',$id)->result();
		echo json_encode($jalan);
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