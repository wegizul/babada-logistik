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
		$d = [
			'stok' => $this->dashboard->stok_sedikit(),
			'pesanan' => $this->dashboard->pesanan_baru(),
		];

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
		$penjualan = $this->dashboard->get_penjualan_perbulan($thn);
		$dataset = array();
		$label = array();
		$arrJml2 = array();
		$obj = new stdClass();
		$total = 0;
		if ($penjualan) {
			foreach ($penjualan as $p) {
				$label[] = date("M", strtotime($p['bulan']));
				$total += $p['jml'];
				$arrJml2[] = $total;
			}
			$obj->data = $arrJml2;
			$total = number_format($total, 0, ",", ".");
			$obj->label = "Total Penjualan Tahun Ini = {$total} Transaksi";
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

	public function grafik_produk($thn)
	{
		$produk = $this->dashboard->get_produk_perbulan($thn);
		$dataset = array();
		$label = array();
		$arrJml2 = array();
		$obj = new stdClass();
		$total = 0;
		if ($produk) {
			foreach ($produk as $p) {
				$label[] = $p['material'];
				$satuan[] = $p['satuan'];
				$total = $p['jml'];
				$arrJml2[] = $total;
			}
			$obj->data = $arrJml2;
			$obj->label = "Terjual";
			$obj->pointBorderColor = '#010536';
			$obj->fill = false;
			$obj->pointStyle = 'rectRounded';
			$obj->backgroundColor = '#010536';
			$obj->borderColor = '#010536';
			$obj->borderWidth = 2;
			$dataset[] = $obj;
		}
		echo json_encode(array("dataset" => $dataset, "label" => $label, "satuan" => $satuan));
	}

	public function detail_pesanan($id)
	{
		$getPenjualan = $this->penjualan->ambil_penjualan($id);
		foreach ($getPenjualan as $p) {
			$data[$p->pjd_id] = "<tr><td>" . $p->mtl_nama . "</td><td>" . $p->pjd_qty . "</td><td>" . $p->smt_nama . "</td></tr>";
		}
		echo json_encode($data);
	}
}
