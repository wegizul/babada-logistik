<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_Material', 'material');
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Premix', 'premix');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Material',
			'satuan' => $this->satuan_material->get_satuan_material(),
			'premix' => $this->premix->get_premix(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('material', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_material()
	{
		$list = $this->material->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $material) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<img src= " . base_url("assets/files/material/{$material->mtl_foto}") . " width='50px'>";
			$row[] = $material->mtl_nama;
			$row[] = $material->mtl_stok . ' ' . $material->smt_nama;
			$row[] = "Rp. " . number_format($material->mtl_harga_modal, 0);
			$row[] = "Rp. " . number_format($material->mtl_harga_jual, 0);
			$row[] = "<a href='#' onClick='ubah_material(" . $material->mtl_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_material(" . $material->mtl_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->material->count_all(),
			"recordsFiltered" => $this->material->count_filtered(),
			"data" => $data,
			"query" => $this->material->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('mtl_id');
		$data = $this->material->cari_material($id);
		echo json_encode($data);
	}

	public function detail()
	{
		$id = $this->input->post('mtl_id');
		$data = $this->material->cari_material($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('mtl_id');
		$data = $this->input->post();

		$nmfile = "mtl_" . time();

		$config['upload_path'] = 'assets/files/material/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name'] = $nmfile;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($_FILES['mtl_foto']['name']) {
			if (!$this->upload->do_upload('mtl_foto')) {
				$error = array('error' => $this->upload->display_errors());
				$resp['errorFoto'] = $error;
			} else {
				$data['mtl_foto'] = $this->upload->data('file_name');
			}
		}

		if ($id == 0) {
			$insert = $this->material->simpan("material", $data);
		} else {
			$insert = $this->material->update("material", array('mtl_id' => $id), $data);
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
		$delete = $this->material->delete('material', 'mtl_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function ecommerce()
	{
		$d = [
			'page' => 'E-Commerce',
			'satuan' => $this->satuan_material->get_satuan_material(),
			'data' => $this->material->get_material(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('ecommerce', $d);
		$this->load->view('background_bawah');
	}
}
