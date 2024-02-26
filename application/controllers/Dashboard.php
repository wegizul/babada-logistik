<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Dashboard', 'dashboard');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		redirect(base_url("Dashboard/tampil"));
	}

	public function tampil()
	{
		$d = [];

		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('dashboard', $d);
		$this->load->view('background_bawah');
	}

	public function grafik_penjualan($thn)
	{
		$penjualan = $this->dashboard->get_booking_perbulan($thn);
		$dataset = array();
		$label = array();
		$arrJml2 = array();
		$obj = new stdClass();
		$total = 0;
		if ($penjualan) {
			foreach ($penjualan as $gji) {
				$label[] = date("M", strtotime($gji['bulan']));
				$total += $gji['jml'];
				$arrJml2[] = $total;
			}
			$obj->data = $arrJml2;
			$totalnya = number_format($total, 0, ",", ".");
			$obj->label = "Total Semua Booking = {$totalnya} Item";
			$obj->pointBorderColor = '#010536';
			$obj->fill = false;
			$obj->pointStyle = 'rectRounded';
			$obj->backgroundColor = '#010536';
			$obj->borderColor = '#010536';
			$obj->borderWidth = 2;
			$dataset[] = $obj;
		}
		echo json_encode(array("dataset" => $dataset, "label" => $label));
	}
}
