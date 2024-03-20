<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Premix extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Premix', 'premix');
		$this->load->model('Model_PremixDetail', 'premix_detail');
		$this->load->model('Model_Material', 'material');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Premix',
			'satuan' => $this->satuan_material->get_satuan_material(),
			'premix' => $this->premix->get_premix(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('premix', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_premix()
	{
		$list = $this->premix->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $premix) {
			$no++;
			$total = 0;
			$harga = $this->premix_detail->getTotal($premix->pmx_id);
			if ($harga->total) $total = number_format($harga->total, 0);

			$row = array();
			$row[] = $no;
			$row[] = "<a href='" . base_url('PremixDetail/tampil/') . $premix->pmx_id . "'>" . $premix->pmx_nama . "</a>";
			$row[] = "Rp. " . number_format($premix->pmx_harga, 0);
			$row[] = $premix->pmx_harga_jual ? "Rp. " . number_format($premix->pmx_harga_jual, 0) : "Rp. 0";
			$row[] = $premix->pmx_stok . " Karung";
			$row[] = $premix->pmx_status == 1 ? "<span class='badge badge-dark'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>";
			$row[] = "<a href='#' onClick='ubah_premix(" . $premix->pmx_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_premix(" . $premix->pmx_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->premix->count_all(),
			"recordsFiltered" => $this->premix->count_filtered(),
			"data" => $data,
			"query" => $this->premix->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pmx_id');
		$data = $this->premix->cari_premix($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('pmx_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->premix->simpan("premix", $data);
		} else {
			$insert = $this->premix->update("premix", array('pmx_id' => $id), $data);
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
		$delete = $this->premix->delete('premix', 'pmx_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function stok_premix()
	{
		$id = $this->input->post('pxs_pmx_id');
		$data = $this->input->post();
		$data['pxs_user'] = $this->session->userdata('id_user');

		$getPremix = $this->premix->cari_premix($id);
		$get_premix_detail = $this->premix_detail->ambil_premix_detail($id);

		if ($data['pxs_tipe'] == 1) {
			$data2['pmx_stok'] = $getPremix->pmx_stok + $data['pxs_qty'];

			foreach ($get_premix_detail as $pd) {
				$get_material = $this->material->cari_material($pd->pxd_mtl_id);
				$data3['mtl_stok'] = $get_material->mtl_stok - $pd->pxd_qty;
				$this->material->update("material", array('mtl_id' => $pd->pxd_mtl_id), $data3);
			}
		} else {
			$data2['pmx_stok'] = $getPremix->pmx_stok - $data['pxs_qty'];

			foreach ($get_premix_detail as $pd) {
				$get_material = $this->material->cari_material($pd->pxd_mtl_id);
				$data3['mtl_stok'] = $get_material->mtl_stok + $pd->pxd_qty;
				$this->material->update("material", array('mtl_id' => $pd->pxd_mtl_id), $data3);
			}
		}

		$insert = $this->premix->update("premix", array('pmx_id' => $id), $data2);
		if ($insert) $this->premix->simpan("premix_stok", $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil update stok premix";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
}
