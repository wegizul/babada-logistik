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
		$this->load->model('Model_Reject', 'reject');
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
			'klaim' => $this->reject->notifikasi(),
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

	public function ajax_list_penjualan($bln, $tgl)
	{
		$list = $this->laporan->get_datatables($bln, $tgl);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			$no++;

			$total_transaksi = $this->laporan->getTotalTransaksi($penjualan->pjl_cust_id, $bln);
			$total_item = $this->laporan->getTotalItem($penjualan->pjl_cust_id, $bln);
			$total_bayar = $this->laporan->getTotalBayar($penjualan->pjl_cust_id, $bln);

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_customer;
			$row[] = $total_item->total ? "<a href='#' onClick='detail($penjualan->pjl_cust_id, $bln)' style='cursor:pointer;'>" . $total_item->total . " Item</a>" : "0 Item";
			$row[] = $total_bayar->total ? "Rp " . number_format($total_bayar->total, 0, ",", ".") : "Rp 0";
			$row[] = $total_transaksi . " Invoice";
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

	public function detail_laporderan($cust, $bln)
	{
		$getPenjualan = $this->laporan->ambil_penjualan($cust, $bln);
		foreach ($getPenjualan as $p) {
			$data[$p->pjd_id] = "<tr><td>" . $p->mtl_nama . "</td><td>" . $p->total . "</td><td>" . $p->smt_nama . "</td><td>Dipesan " . $p->total_dipesan . "x</td></tr>";
		}
		echo json_encode($data);
	}
}
