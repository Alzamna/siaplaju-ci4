<?php

namespace App\Controllers;

use App\Models\Model_backend;
use CodeIgniter\Controller;
use IOFactory;
use PHPExcel;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;

class Adminrekap extends BaseController
{
    protected $model;
    protected $pagination;
    protected $googlemaps;

    public function __construct()
    {
        // load model
        $this->model = new Model_backend();

        // load services
        $this->pagination = \Config\Services::pager();
        $this->googlemaps = new \App\Libraries\Googlemaps();

        // load helper
        helper(['date', 'text']);

        // cek login
        $session = session();
        if ($session->get('login') != 1) {
            return redirect()->to('login');
        }
    }
	
	public function pju(){
		$data=array(
			'title'=>'Rekap PJU Kabupaten Tegal',
			'open_rekap'=>'open',
			'rekap_pju'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
		);
		return view('pages/v_header',$data);
		return view('rekap/v_rekap_pju');
		return view('pages/v_footer');
	}
	
	public function fpju(){
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
		
		$data=array(
			'title'=>'Rekap PJU Kabupaten Tegal',
			'open_rekap'=>'open',
			'rekap_pju'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_rekap'=>$this->model->getFilterRekapPju($kec,$jln,$jns,$kds),
			'export'=>'?kec='.$kec.'&jln='.$jln.'&jns='.$jns.'&kds='.$kds,
		);
		return view('pages/v_header',$data);
		return view('rekap/v_rekap_pju');
		return view('pages/v_footer');
	}
	
	public function export_pju(){
		$kec = $this->request->getPost('kec', TRUE);
		$jln = $this->request->getPost('jln', TRUE);
		$jns = $this->request->getPost('jns', TRUE);
		$kds = $this->request->getPost('kds', TRUE);
		$dtrekap = $this->model->getFilterRekapPju($kec,$jln,$jns,$kds);
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()
			->setCreator("ADMIN - SIAPLAJU") //creator
			->setTitle("REKAP PJU KAB TEGAL");  //file title

		$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
		$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

		$objget->setTitle('REKAP PJU'); //sheet title
		//Warna header tabel
		$objget->getStyle("A1:I1")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font' => array(
					'color' => array('rgb' => '000000')
				)
			)
		);
		
		//table header
		$cols = array("A","B","C","D","E","F","G","H","I");
		 
		$val = array("NO","RUAS JALAN","ID PEL","NO GARDU","NO PAL","JENIS","DAYA","POSISI","KONDISI");
		 
		for ($a=0;$a<9; $a++) {
			$objset->setCellValue($cols[$a].'1', $val[$a]);
		 
			//Setting lebar cell
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		 
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'font' => array(
					'bold' => 'true',
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
		}
		
		$baris  = 2;
		$no=1;
		foreach($dtrekap as $row){
			$objset->setCellValue("A".$baris, $no++);
			$objset->setCellValue("B".$baris, $row->nama_jalan);
			$objset->setCellValue("C".$baris, $row->id_pel);
			$objset->setCellValue("D".$baris, $row->no_gardu);
			$objset->setCellValue("E".$baris, $row->no_pal);
			$objset->setCellValue("F".$baris, $row->jenis);
			$objset->setCellValue("G".$baris, $row->daya);
			$objset->setCellValue("H".$baris, $row->posisi);
			$objset->setCellValue("I".$baris, $row->kondisi);
			
			$style = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':A'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris.':B'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris.':C'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris.':D'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris.':E'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris.':F'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris.':G'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris.':H'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$baris.':I'.$baris)->applyFromArray($style);
			
			$baris++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('REKAP PJU');

		$objPHPExcel->setActiveSheetIndex(0);  
		$filename = "REKAP PJU KAB TEGAL.xlsx";
		   
		  header('Content-Type: application/vnd.ms-excel'); //mime type
		  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		  header('Cache-Control: max-age=0'); //no cache

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');                
		$objWriter->save('php://output');
	}
	
	public function pengaduan(){
		$data=array(
			'title'=>'Rekap Pengaduan Kabupaten Tegal',
			'open_rekap'=>'open',
			'rekap_pengaduan'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
		);
		return view('pages/v_header',$data);
		return view('rekap/v_rekap_pengaduan');
		return view('pages/v_footer');
	}
	
	public function fpengaduan(){
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
		
		if($this->request->getPost('media')!=""){
			$mda = $this->request->getPost('media');
		} else {
			$mda = "%%";
		}
		
		if($this->request->getPost('status')!=""){
			$sts = $this->request->getPost('status');
		} else {
			$sts = "%%";
		}
		
		$tgl_awal = $this->request->getPost('tgl_awal');
		$tgl_akhir = $this->request->getPost('tgl_akhir');
		
		$data=array(
			'title'=>'Rekap Pengaduan Kabupaten Tegal',
			'open_rekap'=>'open',
			'rekap_pengaduan'=>'active',
			'dt_kecamatan'=>$this->model->getAllKecamatan(),
			'dt_rekap'=>$this->model->getFilterRekapPengaduan($kec,$jln,$mda,$sts,$tgl_awal,$tgl_akhir),
			'export'=>'?kec='.$kec.'&jln='.$jln.'&mda='.$mda.'&sts='.$sts.'&awal='.$tgl_awal.'&akhir='.$tgl_akhir,
		);
		return view('pages/v_header',$data);
		return view('rekap/v_rekap_pengaduan');
		return view('pages/v_footer');
	}
	
	public function export_pengaduan(){
		$kec = $this->request->getPost('kec', TRUE);
		$jln = $this->request->getPost('jln', TRUE);
		$mda = $this->request->getPost('mda', TRUE);
		$sts = $this->request->getPost('sts', TRUE);
		$tgl_awal = $this->request->getPost('awal', TRUE);
		$tgl_akhir = $this->request->getPost('akhir', TRUE);
		$dtrekap = $this->model->getFilterRekapPengaduan($kec,$jln,$mda,$sts,$tgl_awal,$tgl_akhir);
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()
			->setCreator("ADMIN - SIAPLAJU") //creator
			->setTitle("REKAP PENGADUAN PJU");  //file title

		$objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
		$objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

		$objget->setTitle('REKAP PENGADUAN PJU'); //sheet title
		//Warna header tabel
		$objget->getStyle("A1:H1")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'ffffff')
				),
				'font' => array(
					'color' => array('rgb' => '000000')
				)
			)
		);
		
		//table header
		$cols = array("A","B","C","D","E","F","G","H");
		 
		$val = array("NO","ID PENGADUAN","TGL PENGADUAN","MEDIA","PELAPOR","LAPORAN","RUAS JALAN","STATUS");
		 
		for ($a=0;$a<8; $a++) {
			$objset->setCellValue($cols[$a].'1', $val[$a]);
		 
			//Setting lebar cell
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		 
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'font' => array(
					'bold' => 'true',
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
		}
		
		$baris  = 2;
		$no=1;
		foreach($dtrekap as $row){
			$objset->setCellValue("A".$baris, $no++);
			$objset->setCellValue("B".$baris, $row->id_pengaduan);
			$objset->setCellValue("C".$baris, date("d M Y",strtotime($row->tgl_pengaduan)));
			$objset->setCellValue("D".$baris, $row->media);
			$objset->setCellValue("E".$baris, $row->pelapor);
			$objset->setCellValue("F".$baris, $row->laporan);
			$objset->setCellValue("G".$baris, $row->nama_jalan);
			$objset->setCellValue("H".$baris, $row->status);
			
			$style = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':A'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris.':B'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris.':C'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris.':D'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris.':E'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris.':F'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris.':G'.$baris)->applyFromArray($style);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris.':H'.$baris)->applyFromArray($style);
			
			$baris++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('REKAP PENGADUAN PJU');

		$objPHPExcel->setActiveSheetIndex(0);  
		$filename = "REKAP PENGADUAN PJU KABUPATEN TEGAL.xlsx";
		   
		  header('Content-Type: application/vnd.ms-excel'); //mime type
		  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		  header('Cache-Control: max-age=0'); //no cache

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');                
		$objWriter->save('php://output');
	}
}