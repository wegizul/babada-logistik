<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataKecamatan extends CI_Controller
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
		$this->load->model('Model_Kecamatan', 'data_kecamatan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Kecamatan',
			'kabupaten' => $this->data_kecamatan->get_kabupaten(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('data_kecamatan', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_data_kecamatan()
	{
		$list = $this->data_kecamatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $data_kecamatan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kecamatan->kot_nama;
			$row[] = $data_kecamatan->kec_nama;
			$row[] = "<a href='#' onClick='ubah_data_kecamatan(" . $data_kecamatan->kec_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_data_kecamatan(" . $data_kecamatan->kec_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->data_kecamatan->count_all(),
			"recordsFiltered" => $this->data_kecamatan->count_filtered(),
			"data" => $data,
			"query" => $this->data_kecamatan->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kec_id');
		$data = $this->data_kecamatan->cari_data_kecamatan($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kec_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->data_kecamatan->simpan("data_kecamatan", $data);
		} else {
			$insert = $this->data_kecamatan->update("data_kecamatan", array('kec_id' => $id), $data);
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
		$delete = $this->data_kecamatan->delete('data_kecamatan', 'kec_id', $id);
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
