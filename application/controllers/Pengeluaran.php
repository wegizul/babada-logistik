<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		if ($this->session->userdata("level") > 2) {
			redirect(base_url("Dashboard"));
		}
		$this->load->model('Model_Pengeluaran', 'pengeluaran');
		$this->load->model('Model_Dana', 'dana');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$getSaldo = $this->dana->ambil_dana_operasional(date('m'));
		$d = [
			'page' => 'Data Pengeluaran Operasional',
			'cek_saldo' => $getSaldo,
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('pengeluaran', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pengeluaran($bln, $tipe)
	{
		$list = $this->pengeluaran->get_datatables($bln, $tipe);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengeluaran) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pengeluaran->kel_tanggal;
			$row[] = $pengeluaran->kel_nama;
			$row[] = "Rp " . number_format($pengeluaran->kel_jml, 0, ',', '.');
			$row[] = $pengeluaran->kel_tipe;
			$row[] = "<a href='#' onClick='ubah_pengeluaran(" . $pengeluaran->kel_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_pengeluaran(" . $pengeluaran->kel_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengeluaran->count_all(),
			"recordsFiltered" => $this->pengeluaran->count_filtered($bln, $tipe),
			"data" => $data,
			"query" => $this->pengeluaran->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kel_id');
		$data = $this->pengeluaran->cari_pengeluaran($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kel_id');
		$data = $this->input->post();
		$data['kel_user'] = $this->session->userdata('id_user');

		$getSaldo = $this->dana->ambil_dana_operasional(date('m', strtotime($data['kel_tanggal'])));

		if ($id == 0) {
			$insert = $this->pengeluaran->simpan("pengeluaran", $data);
			$getTotal = $this->pengeluaran->total_pengeluaran(date('m', strtotime($data['kel_tanggal'])));
			$update = [
				'dop_terpakai' => $getTotal->total,
				'dop_sisa' => $getSaldo->dop_jumlah - $getTotal->total,
			];
			$this->pengeluaran->update("dana_operasional", array('MONTH(dop_tanggal)' => date('m', strtotime($data['kel_tanggal']))), $update);
		} else {
			$insert = $this->pengeluaran->update("pengeluaran", array('kel_id' => $id), $data);
			$getTotal = $this->pengeluaran->total_pengeluaran(date('m', strtotime($data['kel_tanggal'])));
			$update = [
				'dop_terpakai' => $getTotal->total,
				'dop_sisa' => $getSaldo->dop_jumlah - $getTotal->total,
			];
			$this->pengeluaran->update("dana_operasional", array('MONTH(dop_tanggal)' => date('m', strtotime($data['kel_tanggal']))), $update);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Pengeluaran berhasil ditambahkan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pengeluaran->delete('pengeluaran', 'kel_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function total_pengeluaran($bln)
	{
		$getSaldo = $this->dana->ambil_dana_operasional($bln);
		if ($getSaldo) {
			echo "<h6 style='margin-bottom: 0px;'><b>Total Pengeluaran " . $this->pengeluaran->bulan($bln) .
				"</b></h6>
			<h1 style='font-weight: bolder; margin-bottom: -5px;'>Rp " . number_format($getSaldo->dop_terpakai, 0, ',', '.') . "</h1>
			<small style='font-weight: bolder;'><i>Saldo Rp " . number_format($getSaldo->dop_sisa, 0, ',', '.') . "</i></small>";
		} else {
			echo "<h6 style='margin-bottom: 0px;'><b>Total Pengeluaran " . $this->pengeluaran->bulan($bln) .
				"</b></h6>
			<h1 style='font-weight: bolder;'>Rp 0</h1>";
		}
	}

	public function simpan_saldo()
	{
		$id = $this->input->post('dop_id');
		$data = $this->input->post();
		$data['dop_sisa'] = $data['dop_jumlah'];

		if ($id == 0) {
			$insert = $this->pengeluaran->simpan("dana_operasional", $data);
		} else {
			$insert = $this->pengeluaran->update("dana_operasional", array('dop_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Dana Operasional berhasil ditambahkan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
}
