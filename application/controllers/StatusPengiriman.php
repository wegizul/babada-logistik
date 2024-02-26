<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StatusPengiriman extends CI_Controller
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
		$this->load->model('Model_StatusPengiriman', 'status_pengiriman');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Status Pengiriman',
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('status_pengiriman', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_status_pengiriman()
	{
		$list = $this->status_pengiriman->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $status_pengiriman) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $status_pengiriman->sp_nama;
			$row[] = $status_pengiriman->sp_kode;
			$row[] = $status_pengiriman->sp_ket;
			$row[] = "<a href='#' onClick='ubah_status_pengiriman(" . $status_pengiriman->sp_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_status_pengiriman(" . $status_pengiriman->sp_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->status_pengiriman->count_all(),
			"recordsFiltered" => $this->status_pengiriman->count_filtered(),
			"data" => $data,
			"query" => $this->status_pengiriman->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('sp_id');
		$data = $this->status_pengiriman->cari_status_pengiriman($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('sp_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->status_pengiriman->simpan("status_pengiriman", $data);
		} else {
			$insert = $this->status_pengiriman->update("status_pengiriman", array('sp_id' => $id), $data);
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
		$delete = $this->status_pengiriman->delete('status_pengiriman', 'sp_id', $id);
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
