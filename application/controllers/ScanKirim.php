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
		$this->load->model('Model_Reject', 'reject');
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
			'klaim' => $this->reject->notifikasi(),
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
		$cek = $this->tracking->cek_invoice($kode);
		if (!$cek) {
			$data = $this->penjualan->lacak_paket($kode);
			if ($data) {
				$result = [
					'faktur' => $data->pjl_faktur,
					'cust' => $data->pjl_customer,
				];
			} else {
				$result = '';
			}
		} else {
			$result = '';
		}
		echo json_encode($result);
	}

	public function simpan()
	{
		$data['tr_pjl_faktur'] = $this->input->post('tr_pjl_faktur');
		$data['tr_waktu_scan'] = date('Y-m-d H:i:s');
		$data['tr_jenis'] = 2;
		$data['tr_sp_kode'] = "TR";
		$data['tr_user'] = $this->session->userdata('id_user');
		$data['tr_tujuan'] = $this->input->post('tr_tujuan');

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

		$update_tr = [
			'tr_kode_manifest' => $data['mf_kode'],
		];

		$where = [
			'DATE(tr_waktu_scan)' => $data['mf_tgl_pickup'],
			'tr_user' => $log_id,
			'tr_kode_manifest' => NULL,
		];

		$update = $this->tracking->update("tracking", $where, $update_tr);

		$ambil_paket = $this->tracking->ambil_paket($data['mf_kode']);
		$total = 0;
		foreach ($ambil_paket as $ap) {
			$total += $ap->pjl_total_item;
			$this->tracking->update("penjualan", array('pjl_faktur' => $ap->tr_pjl_faktur), array('pjl_status' => 3, 'pjl_date_send' => date('Y-m-d H:i:s')));
			$this->tracking->update("penjualan_detail", array('pjd_pjl_id' => $ap->pjl_id, 'pjd_status' => 2), array('pjd_status' => 3));
		}
		$data['mf_total_paket'] = $total;

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

		$item = [];
		foreach ($get_tracking as $gt) {
			$item[$gt->tr_pjl_faktur] = $this->tracking->ambil_item($gt->tr_pjl_faktur);
		}
		
		$data = [
			'manifest' => $get_manifest,
			'tracking' => $get_tracking,
			'detail' => $item,
		];
		$this->load->view('cetak_manifest', $data);
	}
}
