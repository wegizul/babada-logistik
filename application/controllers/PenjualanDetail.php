<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenjualanDetail extends CI_Controller
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
		$this->load->model('Model_PenjualanDetail', 'penjualan_detail');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'pjl_id' => $id,
			'page' => 'Detail Penjualan',
			'faktur' => $this->penjualan->cari_penjualan($id)
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('penjualan_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_penjualan_detail($id)
	{
		$list = $this->penjualan_detail->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan_detail) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $penjualan_detail->mtl_nama;
			$row[] = $penjualan_detail->pjd_qty;
			$row[] = $penjualan_detail->smt_nama;
			$row[] = "Rp " . number_format($penjualan_detail->pjd_harga, 0, ",", ".");
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan_detail->count_all(),
			"recordsFiltered" => $this->penjualan_detail->count_filtered($id),
			"data" => $data,
			"query" => $this->penjualan_detail->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pjd_id');
		$data = $this->penjualan_detail->cari_penjualan_detail($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->penjualan_detail->delete('penjualan_detail', 'pjd_id', $id);
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
