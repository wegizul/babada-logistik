<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenjualanDetail extends CI_Controller
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
		$this->load->model('Model_PenjualanDetail', 'penjualan_detail');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Reject', 'reject');
		$this->load->model('Model_SatuanMaterial', 'satuan');
		$this->load->model('Model_Material', 'material');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'pjl_id' => $id,
			'page' => 'Detail Penjualan',
			'faktur' => $this->penjualan->cari_penjualan($id),
			'satuan' => $this->satuan->get_satuan_material(),
			'material' => $this->material->get_material()
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('penjualan_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_penjualan_detail($id)
	{
		$list = $this->penjualan_detail->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan_detail) {
			switch ($penjualan_detail->pjd_status) {
				case 0:
					$status = "<span class='badge badge-success'>Tersedia</span>";
					break;
				case 1:
					$status = "<span class='badge badge-success'>Tersedia</span>";
					break;
				case 2:
					$status = "<span class='badge badge-info'>Dikonfirmasi Logistik</span>";
					break;
				case 3:
					$status = "<span class='badge badge-info'>Dikirim</span>";
					break;
				case 4:
					$status = "<span class='badge badge-success'>Selesai</span>";
					break;
				case 5:
					$status = "<span class='badge badge-warning'>Diklaim</span>";
					break;
				case 6:
					$status = "<span class='badge badge-danger'>Tidak Tersedia</span>";
					break;
			}

			$tolak = "<a href='#' onClick='tolak(" . $penjualan_detail->pjd_pjl_id . "," . $penjualan_detail->pjd_id . ")' class='btn btn-danger btn-xs' title='Tandai Sebagai Tidak Tersedia'><i class='fa fa-times-circle'></i></a>";
			$kon = "<a href='#' onClick='konfirmasi(" . $penjualan_detail->pjd_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Klaim'><i class='fa fa-check-circle'></i></a>";
			$edit = "<a href='#' onClick='edit(" . $penjualan_detail->pjd_id . ")' class='btn btn-dark btn-xs' title='Edit Qty'><i class='fa fa-edit'></i></a>";

			if ($penjualan_detail->pjd_status == 5) {
				$aksi = $kon . ' ' . $tolak;
			} else if ($penjualan_detail->pjd_status < 4) {
				$aksi = $tolak . ' ' . $edit;
			} else {
				$aksi = '';
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $penjualan_detail->mtl_nama;
			if ($penjualan_detail->pjd_status < 6) {
				$row[] = "<input type='number' min='0' step='0.001' class='form-control form-control-sm' value='" . $penjualan_detail->pjd_qty . "' onChange='ubahQty(" . $penjualan_detail->pjd_pjl_id . ", " . $penjualan_detail->pjd_id . ", this.value)'>";
				$row[] = $penjualan_detail->smt_nama;
				$row[] = "<div class='input-group input-group-sm'>
				<div class='input-group-prepend'>
					<span class='input-group-text input-group-sm'>Rp</span>
				</div><input type='number' min='0' step='0.001' class='form-control form-control-sm' value='" . $penjualan_detail->pjd_harga . "' onChange='ubahHrg(" . $penjualan_detail->pjd_pjl_id . ", " . $penjualan_detail->pjd_id . ", this.value)'>
				</div>";
			} else {
				$row[] = $penjualan_detail->pjd_qty;
				$row[] = $penjualan_detail->smt_nama;
				$row[] = "Rp " . number_format($penjualan_detail->pjd_harga, 0, ",", ".");
			}
			$row[] = $status;
			$row[] = $aksi;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan_detail->count_all(),
			"recordsFiltered" => $this->penjualan_detail->count_filtered($id),
			"data" => $data,
			"query" => $this->penjualan_detail->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pjd_id');
		$data = $this->penjualan_detail->cari_penjualan_detail($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->penjualan_detail->delete('penjualan_detail', 'pjd_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function tolak($pjl, $pjd)
	{
		$set = [
			'pjd_status' => 6,
			'pjd_ket' => 'item tidak tersedia',
		];
		$this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $pjd), $set);

		$getHarga = $this->penjualan->ambil_total($pjl);
		$update = [
			'pjl_jumlah_bayar' => $getHarga->htot,
			'pjl_total_item' => $getHarga->itot,
		];
		$update = $this->penjualan_detail->update("penjualan", array('pjl_id' => $getHarga->pjd_pjl_id), $update);

		if ($update) {
			$resp['status'] = 1;
			$resp['desc'] = "Item ditandai sebagai tidak tersedia";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal memproses request!";
		}
		echo json_encode($resp);
	}

	public function get_klaim($pjd)
	{
		$data = $this->reject->ambil_reject($pjd);

		echo json_encode($data);
	}

	public function konfirm_klaim()
	{
		$pjd = $this->input->post('pjd_id');
		$pjl = $this->input->post('pjd_pjl_id');
		if ($this->input->post('pjd_status') == 6) {
			$set = [
				'pjd_status' => 6,
				'pjd_ket' => 'item tidak tersedia',
			];
			$update_stt = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $pjd), $set);
		} else {
			$set = [
				'pjd_status' => 3,
			];
			$update_stt = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $pjd), $set);

			$this->penjualan_detail->delete('reject', 'rjt_pjd_id', $pjd);
		}

		$getHarga = $this->penjualan->ambil_total($pjl);
		$update = [
			'pjl_jumlah_bayar' => $getHarga->htot,
			'pjl_total_item' => $getHarga->itot,
		];
		$this->penjualan_detail->update("penjualan", array('pjl_id' => $pjl), $update);

		if ($update_stt) {
			$resp['status'] = 1;
			$resp['desc'] = "Klaim item berhasil dikonfirmasi";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal memproses request!";
		}
		echo json_encode($resp);
	}
	
	public function simpan_edit()
	{
		$id = $this->input->post('pjd_id');
		$pjl = $this->input->post('pjd_pjl_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->penjualan_detail->simpan("penjualan_detail", $data);
			
			$getHarga = $this->penjualan->ambil_total($pjl);
			$update = [
				'pjl_jumlah_bayar' => $getHarga->htot,
				'pjl_total_item' => $getHarga->itot,
			];
			$this->penjualan_detail->update("penjualan", array('pjl_id' => $pjl), $update);
			
		} else {
			$insert = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $id), $data);
			
			$getHarga = $this->penjualan->ambil_total($pjl);
			$update = [
				'pjl_jumlah_bayar' => $getHarga->htot,
				'pjl_total_item' => $getHarga->itot,
			];
			$this->penjualan_detail->update("penjualan", array('pjl_id' => $pjl), $update);

		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengedit qty item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
	
	public function ubah_qty($pjl, $pjd, $qty)
	{
		$insert = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $pjd), array('pjd_qty' => $qty));

		$getHarga = $this->penjualan->ambil_total($pjl);
		$update = [
			'pjl_jumlah_bayar' => $getHarga->htot,
			'pjl_total_item' => $getHarga->itot,
		];
		$this->penjualan->update("penjualan", array('pjl_id' => $pjl), $update);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengedit Qty item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function ubah_harga($pjl, $pjd, $hrg)
	{
		$insert = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $pjd), array('pjd_harga' => $hrg));

		$getHarga = $this->penjualan->ambil_total($pjl);
		$update = [
			'pjl_jumlah_bayar' => $getHarga->htot,
			'pjl_total_item' => $getHarga->itot,
		];
		$this->penjualan->update("penjualan", array('pjl_id' => $pjl), $update);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengedit Harga item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
	
	public function add_item()
	{
		$id = $this->input->post('pjd_id');
		$pjl = $this->input->post('pjd_pjl_id');
		$data = $this->input->post();

		if ($id == 0) {
			$insert = $this->penjualan_detail->simpan("penjualan_detail", $data);

			$getHarga = $this->penjualan->ambil_total($pjl);
			$update = [
				'pjl_jumlah_bayar' => $getHarga->htot,
				'pjl_total_item' => $getHarga->itot,
			];
			$this->penjualan_detail->update("penjualan", array('pjl_id' => $pjl), $update);
		} else {
			$insert = $this->penjualan_detail->update("penjualan_detail", array('pjd_id' => $id), $data);

			$getHarga = $this->penjualan->ambil_total($pjl);
			$update = [
				'pjl_jumlah_bayar' => $getHarga->htot,
				'pjl_total_item' => $getHarga->itot,
			];
			$this->penjualan_detail->update("penjualan", array('pjl_id' => $pjl), $update);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menambahkan item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
}
