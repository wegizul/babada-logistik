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
			$status = "<span class='badge badge-success'><i class='fas fa-check-circle'></i> Berhasil update pengiriman</span>";
			$ket = "";
			if ($this->session->userdata('level') == 3) {
				$ket = "Paket akan dikirimkan ke " . $tracking->tr_tujuan;
			} elseif ($this->session->userdata('level') == 4) {
				$ket = "Paket akan dikirimkan ke " . $tracking->tr_tujuan;
			}
			$row = array();
			$row[] = $tracking->tr_waktu_scan;
			$row[] = $tracking->tr_bd_kode;
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
		$data = $this->booking->lacak_paket($kode);
		if ($data) {
			$result = $data->bd_kode;
		} else {
			$result = '';
		}
		echo $result;
	}

	public function simpan()
	{
		$log_id = $this->input->post('tr_tujuan');
		$data['tr_bd_kode'] = $this->input->post('bd_kode');
		$data['tr_waktu_scan'] = date('Y-m-d H:i:s');
		$data['tr_jenis'] = 2;
		$data['tr_sp_kode'] = "TR";
		$data['tr_user'] = $this->session->userdata('id_user');

		$ambil = $this->pengguna->cari_pengguna($log_id);
		switch ($ambil->log_level) {
			case 3:
				$ket = "POS";
				break;
			case 4:
				$ket = "HUB";
				break;
			case 5:
				$ket = "SUBHUB";
				break;
		};

		$data['tr_tujuan'] = $ket . ' ' . $ambil->log_agen;

		$insert = $this->tracking->simpan("tracking", $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
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
		$data['mf_kode'] = "PUM" . date('yymdHis');
		$data['mf_tgl_pickup'] = date('Y-m-d');
		$data['mf_user'] = $log_id;

		$ambil = $this->pengguna->cari_pengguna($log_id);

		$data['mf_pos'] = $ambil->log_nama;
		$data['mf_kota_asal'] = $ambil->log_agen;

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
			$data['mf_total_paket'] = $ap->total_paket;
			$data['mf_total_berat'] = $ap->total_berat;
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
