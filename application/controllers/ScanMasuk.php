<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ScanMasuk extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Booking', 'booking');
		$this->load->model('Model_Kecamatan', 'kecamatan');
		$this->load->model('Model_JenisProduk', 'jenis_produk');
		$this->load->model('Model_StatusPengiriman', 'status_pengiriman');
		$this->load->model('Model_TipeAlamat', 'tipe_alamat');
		$this->load->model('Model_TipeKomoditas', 'tipe_komoditas');
		$this->load->model('Model_Tracking', 'tracking');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$data = [
			'bd_kode' => '',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('scan_masuk', $data);
		$this->load->view('background_bawah');
	}

	public function ajax_list_tracking()
	{
		$list = $this->tracking->get_datatables(1);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tracking) {
			$status = "<span class='badge badge-success'><i class='fas fa-check-circle'></i> Berhasil update pengiriman</span>";
			$ket = "";
			if ($this->session->userdata('level') == 4) {
				$ket = "Paket telah tiba di HUB " . $this->session->userdata('agen');
			} elseif ($this->session->userdata('level') == 5) {
				$ket = "Paket telah tiba di SUBHUB " . $this->session->userdata('agen');
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
			"recordsTotal" => $this->tracking->count_all(1),
			"recordsFiltered" => $this->tracking->count_filtered(1),
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
		$data['tr_bd_kode'] = $this->input->post('bd_kode');
		$data['tr_sp_kode'] = $this->input->post('sp_kode');
		$data['tr_waktu_scan'] = date('Y-m-d H:i:s');
		$data['tr_jenis'] = 1;
		$data['tr_user'] = $this->session->userdata('id_user');

		$where = [
			'bd_sp_kode' => $data['tr_sp_kode'],
		];

		$insert = $this->tracking->simpan("tracking", $data);
		if ($insert) $insert = $this->booking->update("booking_detail", array('bd_kode' => $data['tr_bd_kode']), $where);

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
}
