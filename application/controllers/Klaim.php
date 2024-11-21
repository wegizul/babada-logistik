<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klaim extends CI_Controller
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
		$this->load->model('Model_Reject', 'klaim');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Material', 'material');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Pengajuan Klaim',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->klaim->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('klaim', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_klaim()
	{
		$list = $this->klaim->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $klaim) {
			$aksi = "<a href='#' onClick='konfirmasi(" . $klaim->rjt_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Klaim'><i class='fa fa-check-circle'></i></a>&nbsp;<a href='#' onClick='hapus_klaim(" . $klaim->rjt_id . ")' class='btn btn-danger btn-xs' title='Hapus Klaim'><i class='fa fa-trash-alt'></i></a>";
			if ($klaim->rjt_status == 1) {
				$aksi = "<span class='badge badge-success'>Dikonfirmasi</span>";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $klaim->rjt_date_created;
			$row[] = $klaim->pjl_faktur;
			$row[] = $klaim->mtl_nama;
			$row[] = $klaim->pjd_qty;
			$row[] = $klaim->rjt_keterangan;
			$row[] = $aksi;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->klaim->count_all(),
			"recordsFiltered" => $this->klaim->count_filtered(),
			"data" => $data,
			"query" => $this->klaim->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('rjt_id');
		$data = $this->klaim->cari_reject($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('rjt_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->klaim->simpan("klaim", $data);
		} else {
			$insert = $this->klaim->update("klaim", array('rjt_id' => $id), $data);
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
		$delete = $this->klaim->delete('klaim', 'rjt_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function get_klaim($id)
	{
		$data = $this->klaim->cari_reject($id);

		echo json_encode($data);
	}

	public function konfirm_klaim()
	{
		$pjd = $this->input->post('rjt_pjd_id');
		$pjl = $this->input->post('rjt_pjl_id');
		$data = $this->input->post();

		$get_material = $this->material->cari_material($data['rjt_material']);

		if ($this->input->post('pjd_status') == 5) {
			$set = [
				'pjd_status' => 5,
				'pjd_ket' => 'diklaim',
			];

			$upd_klaim = [
				'rjt_status' => 1,
				'rjt_tindakan' => $data['rjt_tindakan'],
			];

			if ($data['rjt_tindakan'] == 'Tukar') {
				$upd_stok['mtl_stok'] = $get_material->mtl_stok + $data['rjt_qty'];

				$this->material->update("material", array('mtl_id' => $data['rjt_material']), $upd_stok);
			}
			
			$this->klaim->update("penjualan_detail", array('pjd_id' => $pjd), $set);
			$update_stt = $this->klaim->update("reject", array('rjt_pjd_id' => $pjd), $upd_klaim);
		} else {
			$set = [
				'pjd_status' => 3,
			];

			$upd_klaim = [
				'rjt_status' => 2,
				'rjt_catatan' => $data['rjt_catatan'],
			];

			$update_stt = $this->klaim->update("penjualan_detail", array('pjd_id' => $pjd), $set);
			$update_stt = $this->klaim->update("reject", array('rjt_pjd_id' => $pjd), $upd_klaim);
		}

		$getHarga = $this->penjualan->ambil_total($pjl);
		$update = [
			'pjl_jumlah_bayar' => $getHarga->htot,
			'pjl_total_item' => $getHarga->itot,
		];
		$this->klaim->update("penjualan", array('pjl_id' => $pjl), $update);

		if ($update_stt) {
			$resp['status'] = 1;
			$resp['desc'] = "Klaim item berhasil dikonfirmasi";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal memproses request!";
		}
		echo json_encode($resp);
	}
}
