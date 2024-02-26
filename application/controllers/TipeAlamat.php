<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TipeAlamat extends CI_Controller
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
		$this->load->model('Model_TipeAlamat', 'tipe_alamat');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Tipe Alamat',
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('tipe_alamat', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_tipe_alamat()
	{
		$list = $this->tipe_alamat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $tipe_alamat) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $tipe_alamat->ta_nama;
			$row[] = $tipe_alamat->ta_ket;
			$row[] = "<a href='#' onClick='ubah_tipe_alamat(" . $tipe_alamat->ta_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_tipe_alamat(" . $tipe_alamat->ta_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tipe_alamat->count_all(),
			"recordsFiltered" => $this->tipe_alamat->count_filtered(),
			"data" => $data,
			"query" => $this->tipe_alamat->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('ta_id');
		$data = $this->tipe_alamat->cari_tipe_alamat($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('ta_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->tipe_alamat->simpan("tipe_alamat", $data);
		} else {
			$insert = $this->tipe_alamat->update("tipe_alamat", array('ta_id' => $id), $data);
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
		$delete = $this->tipe_alamat->delete('tipe_alamat', 'ta_id', $id);
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
