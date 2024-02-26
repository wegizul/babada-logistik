<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends CI_Controller {

	function __construct() {
   	parent::__construct();
  	// if (!isset($this->session->userdata['id_user'])) {
  	// redirect(base_url("login"));
  	// }
  	$this->load->model('Model_Dashboard','dashboard');
	date_default_timezone_set('Asia/Jakarta');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$ba = [
			'judul' => "Halaman Tidak Ditemukan",
			'subjudul' => "under construction",
		];
		$this->load->view('background_atas', $ba);
		$this->load->view('maintenance');
		$this->load->view('background_bawah');
	}
	
	
}
