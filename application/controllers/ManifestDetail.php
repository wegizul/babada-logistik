<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManifestDetail extends CI_Controller
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
		$this->load->model('Model_ManifestDetail', 'tracking');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'mf_kode' => $id,
			'page' => 'Detail Manifest',
			'faktur' => $this->tracking->cari_invoice($id)
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('manifest_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_manifest_detail($id)
	{
		$list = $this->tracking->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tracking) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $tracking->tr_pjl_faktur;
			$row[] = $tracking->pjl_total_item;
			$row[] = $tracking->tr_tujuan;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tracking->count_all(),
			"recordsFiltered" => $this->tracking->count_filtered($id),
			"data" => $data,
			"query" => $this->tracking->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('tr_id');
		$data = $this->tracking->cari_tracking($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->tracking->delete('tracking', 'tr_id', $id);
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
