<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SatuanMaterial extends CI_Controller
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
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Satuan Material',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('satuan_material', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_satuan_material()
	{
		$list = $this->satuan_material->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $satuan_material) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $satuan_material->smt_nama;
			$row[] = "<a href='#' onClick='ubah_satuan_material(" . $satuan_material->smt_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_satuan_material(" . $satuan_material->smt_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->satuan_material->count_all(),
			"recordsFiltered" => $this->satuan_material->count_filtered(),
			"data" => $data,
			"query" => $this->satuan_material->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('smt_id');
		$data = $this->satuan_material->cari_satuan_material($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('smt_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->satuan_material->simpan("satuan_material", $data);
		} else {
			$insert = $this->satuan_material->update("satuan_material", array('smt_id' => $id), $data);
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
		$delete = $this->satuan_material->delete('satuan_material', 'smt_id', $id);
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
