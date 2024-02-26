<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataKota extends CI_Controller
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
		$this->load->model('Model_Kota', 'data_kota');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Kota',
			'provinsi' => $this->data_kota->get_provinsi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('data_kota', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_data_kota()
	{
		$list = $this->data_kota->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $data_kota) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $data_kota->kot_nama;
			$row[] = $data_kota->prov_nama;
			$row[] = "<a href='#' onClick='ubah_data_kota(" . $data_kota->kab_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_data_kota(" . $data_kota->kab_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->data_kota->count_all(),
			"recordsFiltered" => $this->data_kota->count_filtered(),
			"data" => $data,
			"query" => $this->data_kota->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('kab_id');
		$data = $this->data_kota->cari_data_kota($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('kab_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->data_kota->simpan("wilayah_kabupaten", $data);
		} else {
			$insert = $this->data_kota->update("wilayah_kabupaten", array('kab_id' => $id), $data);
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
		$delete = $this->data_kota->delete('wilayah_kabupaten', 'kab_id', $id);
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
