<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
		$this->load->model('Model_Supplier', 'supplier');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Supplier',
		];
		$this->load->helper('url');
		$this->load->view('background_atas');
		$this->load->view('supplier', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_supplier()
	{
		$list = $this->supplier->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $supplier) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $supplier->spl_nama;
			$row[] = $supplier->spl_notelp;
			$row[] = $supplier->spl_alamat;
			$row[] = "<a href='#' onClick='ubah_supplier(" . $supplier->spl_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_supplier(" . $supplier->spl_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->supplier->count_all(),
			"recordsFiltered" => $this->supplier->count_filtered(),
			"data" => $data,
			"query" => $this->supplier->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('spl_id');
		$data = $this->supplier->cari_supplier($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('spl_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->supplier->simpan("supplier", $data);
		} else {
			$insert = $this->supplier->update("supplier", array('spl_id' => $id), $data);
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
		$delete = $this->supplier->delete('supplier', 'spl_id', $id);
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
