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
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$total = 0;
		$getTotal = $this->pengeluaran->total_pengeluaran();
		if ($getTotal) $total = $getTotal->total;
		$d = [
			'page' => 'Data Pengeluaran Operasional',
			'total_pengeluaran' => $total,
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('pengeluaran', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_pengeluaran()
	{
		$list = $this->pengeluaran->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengeluaran) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pengeluaran->kel_tanggal;
			$row[] = $pengeluaran->kel_nama;
			$row[] = "Rp " . number_format($pengeluaran->kel_jml, 0, ',', '.');
			$row[] = "<a href='#' onClick='ubah_pengeluaran(" . $pengeluaran->kel_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_pengeluaran(" . $pengeluaran->kel_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengeluaran->count_all(),
			"recordsFiltered" => $this->pengeluaran->count_filtered(),
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

		if ($id == 0) {
			$insert = $this->pengeluaran->simpan("pengeluaran", $data);
		} else {
			$insert = $this->pengeluaran->update("pengeluaran", array('kel_id' => $id), $data);
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
}
