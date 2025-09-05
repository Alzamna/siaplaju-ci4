<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('login') != 1 ){
            redirect('login');
        };
	}
	
	public function index(){
		$data=array(
			'title'=>'Dashboard SIAPLAJU',
			'open_dashboard'=>'open',
			'aktif_dashboard'=>'active',
		);
		$this->load->view('pages/v_header',$data);
		$this->load->view('pages/v_dashboard');
		$this->load->view('pages/v_footer');
	}
}