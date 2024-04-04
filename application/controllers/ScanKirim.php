<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ScanKirim extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Tracking', 'tracking');
		$this->load->model('Model_Login', 'pengguna');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$data = [
			'bd_kode' => '',
			'tujuan' => $this->pengguna->get_unit_kerja(),
			'manifest' => $this->tracking->get_manifest(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('scan_kirim', $data);
		$this->load->view('background_bawah');
	}

	public function ajax_list_tracking()
	{
		$list = $this->tracking->get_datatables(2);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tracking) {
			$status = "<span class='badge badge-success'><i class='fas fa-check-circle'></i> Success</span>";
			$ket = "";
			if ($this->session->userdata('level') < 4) {
				$ket = "Paket akan dikirimkan ke " . $tracking->tr_tujuan;
			}

			$row = array();
			$row[] = $tracking->tr_waktu_scan;
			$row[] = $tracking->tr_pjl_faktur;
			$row[] = $status;
			$row[] = $ket;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tracking->count_all(2),
			"recordsFiltered" => $this->tracking->count_filtered(2),
			"data" => $data,
			"query" => $this->tracking->getlastquery(),
		);
		echo json_encode($output);
	}

	public function get_resi($kode)
	{
		$data = $this->penjualan->lacak_paket($kode);
		if ($data) {
			$result = $data->pjl_faktur;
		} else {
			$result = '';
		}
		echo $result;
	}

	public function simpan()
	{
		$log_id = $this->input->post('tr_tujuan');

		$data['tr_pjl_faktur'] = $this->input->post('tr_pjl_faktur');
		$data['tr_waktu_scan'] = date('Y-m-d H:i:s');
		$data['tr_jenis'] = 2;
		$data['tr_sp_kode'] = "TR";
		$data['tr_user'] = $this->session->userdata('id_user');

		$ambil = $this->pengguna->cari_pengguna($log_id);

		$data['tr_tujuan'] = $ambil->log_unit_kerja;

		$insert = $this->tracking->simpan("tracking", $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menambahkan invoice";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function simpan_manifest()
	{
		$log_id = $this->session->userdata('id_user');
		$data = $this->input->post();
		$data['mf_kode'] = "PUM" . date('ymdHis');
		$data['mf_tgl_pickup'] = date('Y-m-d');
		$data['mf_user'] = $log_id;

		$update = [
			'tr_kode_manifest' => $data['mf_kode'],
		];

		$where = [
			'DATE(tr_waktu_scan)' => $data['mf_tgl_pickup'],
			'tr_user' => $log_id,
			'tr_kode_manifest' => NULL,
		];

		$update = $this->tracking->update("tracking", $where, $update);

		$ambil_paket = $this->tracking->ambil_paket($data['mf_kode']);

		foreach ($ambil_paket as $ap) {
			$data['mf_total_paket'] = $ap->pjl_total_item;
		}

		$insert = '';
		if ($update) $insert = $this->tracking->simpan("manifest", $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil membuat manifest";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Tidak ada paket yang akan dikirim";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function cetak_manifest($kode)
	{
		$get_manifest = $this->tracking->ambil_manifest($kode);
		$get_tracking = $this->tracking->ambil_tracking($kode);
		$data = [
			'manifest' => $get_manifest,
			'tracking' => $get_tracking,
		];
		$this->load->view('cetak_manifest', $data);
	}
}
