<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PremixDetail extends CI_Controller
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
		$this->load->model('Model_Premix', 'premix');
		$this->load->model('Model_PremixDetail', 'premix_detail');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Material', 'material');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'pmx_id' => $id,
			'page' => 'Premix Detail',
			'premix' => $this->premix->cari_premix($id),
			'material' => $this->material->get_material(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('premix_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_premix_detail($id)
	{
		$list = $this->premix_detail->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $premix_detail) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $premix_detail->pxd_mtl_nama;
			$row[] = $premix_detail->pxd_qty;
			$row[] = "Rp. " . number_format($premix_detail->pxd_hpp, 0);
			$row[] = "Rp. " . number_format($premix_detail->pxd_harga, 0);
			$row[] = "<a href='#' onClick='ubah_premix_detail(" . $premix_detail->pxd_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_premix_detail(" . $premix_detail->pxd_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->premix_detail->count_all(),
			"recordsFiltered" => $this->premix_detail->count_filtered($id),
			"data" => $data,
			"query" => $this->premix_detail->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pxd_id');
		$data = $this->premix_detail->cari_premix_detail($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('pxd_id');
		$data = $this->input->post();

		$get_material = $this->material->cari_material($data['pxd_mtl_id']);

		$data['pxd_mtl_nama'] = $get_material->mtl_nama;
		$data['pxd_harga'] = $data['pxd_qty'] * $data['pxd_hpp'];

		$data3['mtl_stok'] = $get_material->mtl_stok - $data['pxd_qty'];

		if ($id == 0) {
			$insert = $this->premix->simpan("premix_detail", $data);

			$getHarga = $this->premix_detail->getTotal($data['pxd_pmx_id']);
			$data2['pmx_harga'] = $getHarga->total;

			$this->premix->update("premix", array('pmx_id' => $data['pxd_pmx_id']), $data2);
			$this->material->update("material", array('mtl_id' => $data['pxd_mtl_id']), $data3);
		} else {
			$insert = $this->premix->update("premix_detail", array('pxd_id' => $id), $data);

			$getHarga = $this->premix_detail->getTotal($data['pxd_pmx_id']);
			$data2['pmx_harga'] = $getHarga->total;

			$this->premix->update("premix", array('pmx_id' => $data['pxd_pmx_id']), $data2);
			$this->material->update("material", array('mtl_id' => $data['pxd_mtl_id']), $data3);
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
		$delete = $this->premix_detail->delete('premix_detail', 'pxd_id', $id);
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
