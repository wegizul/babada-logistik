<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LacakPaket extends CI_Controller
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
		$this->load->view('lacak_paket', $data);
		$this->load->view('background_bawah');
	}

	public function cari()
	{
		$kode = $this->input->post('kode');
		$data = $this->booking->lacak_paket2($kode);
		$tampil = "";
		// $data = $this->booking->lacak_paket($kode);
		$data2 = array();
		$data2['bd_kode'] = '';
		if ($data) {
			$tampil = [
				'kode' => $kode,
				'data' => $data,
				'bd_kode' => 'ada',
			];
			$this->session->set_flashdata('message', '');
		} else {
			$tampil = $data2;
			$this->session->set_flashdata('message', '<br><small style="color: red;"><i>Nomor Resi Tidak Ditemukan</i></small>');
		}

		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];

		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('lacak_paket', $tampil);
		$this->load->view('background_bawah');
	}
}
