<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
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
		$this->load->library('upload');
		$this->load->model('Model_Login', 'pengguna');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Pengguna',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('pengguna', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pengguna()
	{
		$list = $this->pengguna->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengguna) {

			$hapus = " <a href='#' onClick='hapus_pengguna(" . $pengguna->log_id . ")' class='btn btn-danger btn-xs' title='Hapus data Pengguna'><i class='fa fa-trash-alt'></i></a>";
			if ($this->session->userdata("level") == 2) {
				if ($pengguna->log_level == 2) {
					$hapus = "";
				}
			}
			$no++;
			$level = "";
			switch ($pengguna->log_level) {
				case 2:
					$level = "Admin";
					break;
				case 3:
					$level = "Admin Gudang";
					break;
				case 4:
					$level = "Konsumen";
					break;
			}
			$row = array();
			$row[] = $no;
			$row[] = $pengguna->log_nama;
			$row[] = $pengguna->log_user;
			$row[] = $level;
			$row[] = $pengguna->log_unit_kerja;
			$row[] = "<a href='#' onClick='ubah_pengguna(" . $pengguna->log_id . ")' class='btn btn-dark btn-xs' title='Ubah data Pengguna'><i class='fa fa-edit'></i></a> {$hapus}";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengguna->count_all(),
			"recordsFiltered" => $this->pengguna->count_filtered(),
			"data" => $data,
			"query" => $this->pengguna->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('log_id');
		$data = $this->pengguna->cari_pengguna($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('log_id');
		$pass = $this->input->post('log_pass');
		$data = $this->input->post();

		if (!empty($pass)) {
			$data['log_pass'] = md5($pass);
		}

		if ($id == 0) {
			if (empty($pass)) {
				$data['log_pass'] = md5("wdp-babada123");
			}
			$insert = $this->pengguna->simpan("sys_login", $data);
		} else {
			$insert = $this->pengguna->update("sys_login", array('log_id' => $id), $data);
		}

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

	public function hapus($id)
	{
		$delete = $this->pengguna->delete('sys_login', 'log_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fas fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-triangle text-warning'></i>&nbsp;&nbsp;&nbsp; Pengguna tidak dapat dihapus";
		}
		echo json_encode($resp);
	}
}
