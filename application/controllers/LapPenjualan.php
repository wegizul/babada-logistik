<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapPenjualan extends CI_Controller
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
		$this->load->model('Model_RiwayatPesanan', 'riwayat');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'material' => $this->material->ambil_material(),
			'satuan_material' => $this->satuan_material->get_satuan_material(),
			'page' => 'Laporan Penjualan',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('laporan_penjualan', $d);
		$this->load->view('background_bawah');
	}

	public function export($bln, $tgl)
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

	public function ajax_list_penjualan($bln, $tgl)
	{
		$list = $this->penjualan->get_datatables($bln, $tgl);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			$no++;
			$status = '';
			$pembayaran = '';
			switch ($penjualan->pjl_status) {
				case 0:
					$status = "<span class='badge badge-warning'>Menunggu Konfirmasi</span>";
					break;
				case 1:
					$status = "<span class='badge badge-info'>Dikonfirmasi AM</span>";
					break;
				case 2:
					$status = "<span class='badge badge-info'>Dikonfirmasi Logistik</span>";
					break;
				case 3:
					$status = "<span class='badge badge-info'>Dikirim</span>";
					break;
				case 4:
					$status = "<span class='badge badge-success'>Selesai</span>";
					break;
				case 6:
					$status = "<span class='badge badge-danger'>Ditolak</span>";
					break;
			}
			switch ($penjualan->pjl_status_bayar) {
				case 0:
					$pembayaran = "<span class='badge badge-warning'>Tertunda</span>";
					break;
				case 1:
					$pembayaran = "<span class='badge badge-danger'>Jatuh Tempo</span>";
					break;
				case 2:
					$pembayaran = "<span class='badge badge-success'>Lunas</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_tanggal;
			$row[] = "<span class='text-primary' onClick='detail(" . $penjualan->pjl_id . ")' style='cursor:pointer;'>" . $penjualan->pjl_faktur . "</span>";
			$row[] = $penjualan->pjl_customer;
			$row[] = $penjualan->pjl_total_item . " Item";
			$row[] = "Rp " . number_format($penjualan->pjl_jumlah_bayar, 0, ",", ".");
			$row[] = $pembayaran;
			$row[] = $status;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan->count_all(),
			"recordsFiltered" => $this->penjualan->count_filtered($bln, $tgl),
			"data" => $data,
			"query" => $this->penjualan->getlastquery(),
		);
		echo json_encode($output);
	}
}
