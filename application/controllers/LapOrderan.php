<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapOrderan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Material', 'material');
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_OrderanOutlet', 'laporan');
		$this->load->model('Model_RiwayatPesanan', 'riwayat');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'material' => $this->material->get_material(),
			'satuan_material' => $this->satuan_material->get_satuan_material(),
			'page' => 'Laporan Orderan Outlet',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('lap_orderan', $d);
		$this->load->view('background_bawah');
	}

	public function export($bln)
	{
		if ($bln == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $bln;
		}
		$d = [
			'page' => 'Laporan Penjualan',
			'bulan' => $nama_bulan,
			'data' => $this->penjualan->export_excel($bln),
		];
		$this->load->helper('url');
		$this->load->view('export_penjualan', $d);
	}

	public function ajax_list_penjualan($bln)
	{
		$list = $this->laporan->get_datatables($bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			print_r($penjualan);
			die();
			$no++;
			$status = '';
			switch ($penjualan->pjl_status) {
				case 1:
					$status = "<span class='badge badge-warning'>Menunggu Konfirmasi</span>";
					break;
				case 2:
					$status = "<span class='badge badge-success'>Dikonfirmasi</span>";
					break;
				case 3:
					$status = "<span class='badge badge-danger'>Ditolak</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_customer;
			$row[] = $penjualan->total_item . " Item";
			$row[] = "Rp " . number_format($penjualan->total_bayar, 0, ",", ".");
			$row[] = $status;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan->count_all(),
			"recordsFiltered" => $this->penjualan->count_filtered($bln),
			"data" => $data,
			"query" => $this->penjualan->getlastquery(),
		);
		echo json_encode($output);
	}
}
