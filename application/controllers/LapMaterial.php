<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapMaterial extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_LapMaterial', 'material');
		$this->load->model('Model_Pembelian', 'pembelian');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Laporan Penjualan Material',
			'material' => $this->material->get_material(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('laporan_penjualan_material', $d);
		$this->load->view('background_bawah');
	}

	public function export($bln)
	{
		if ($bln == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $bln;
		}

		$list = $this->material->get_material();
		$data = array();
		foreach ($list as $material) {
			$total_pembelian = $this->material->getTobel($material->mtl_id, $bln);
			$total_penjualan = $this->material->getToju($material->mtl_id, $bln);

			$data[] = [
				'jp_nama' => $material->jp_nama,
				'mtl_nama' => $material->mtl_nama,
				'topel' => $total_pembelian->tot,
				'topen' => $total_penjualan->tot,
				'stok' => $material->mtl_stok,
			];
		}

		$d = [
			'page' => 'Laporan Material',
			'bulan' => $nama_bulan,
			'data' => $data,
		];
		$this->load->helper('url');
		$this->load->view('export_material', $d);
	}

	public function ajax_list_laporan($cus, $mtl, $bln, $tgl)
	{
		$list = $this->material->get_datatables($cus, $mtl, $bln, $tgl);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $material) {
			$no++;

			$total_penjualan = $this->material->getToju($material->pjl_cust_id, $material->mtl_id, $bln, $material->pjl_tanggal);

			$row = array();
			$row[] = $no;
			$row[] = $material->jp_nama;
			$row[] = $material->mtl_nama;
			$row[] = $total_penjualan->tot ? $total_penjualan->tot . ' ' . $material->smt_nama : "0 " . $material->smt_nama;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->material->count_all(),
			"recordsFiltered" => $this->material->count_filtered($cus, $mtl, $bln, $tgl),
			"data" => $data,
			"query" => $this->material->getlastquery(),
		);
		echo json_encode($output);
	}
}
