<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PembelianDetail extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		if ($this->session->userdata("level") > 3) {
			redirect(base_url("Dashboard"));
		}
		$this->load->model('Model_PembelianDetail', 'pembelian_detail');
		$this->load->model('Model_Pembelian', 'pembelian');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'pbl_id' => $id,
			'page' => 'Pembelian Detail',
			'faktur' => $this->pembelian->cari_pembelian($id)
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('pembelian_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pembelian_detail($id)
	{
		$list = $this->pembelian_detail->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pembelian_detail) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pembelian_detail->mtl_nama;
			$row[] = $pembelian_detail->pbd_qty;
			$row[] = $pembelian_detail->pbd_satuan;
			$row[] = "Rp " . number_format($pembelian_detail->pbd_harga, 0, ",", ".");
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pembelian_detail->count_all(),
			"recordsFiltered" => $this->pembelian_detail->count_filtered($id),
			"data" => $data,
			"query" => $this->pembelian_detail->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pbd_id');
		$data = $this->pembelian_detail->cari_pembelian_detail($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->pembelian_detail->delete('pembelian_detail', 'pbd_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}
}
