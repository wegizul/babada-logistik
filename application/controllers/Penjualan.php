<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
		$this->load->model('Model_RiwayatPesanan', 'riwayat');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'customer' => $this->penjualan->get_biller_dreampos(),
			'material' => $this->material->get_material(),
			'satuan_material' => $this->satuan_material->get_satuan_material(),
			'page' => 'Data Penjualan',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('penjualan', $d);
		$this->load->view('background_bawah');
	}

	public function cart()
	{
		$d = [
			'page' => 'Keranjang Saya',
			'data' => $this->penjualan->keranjang(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('keranjang', $d);
		$this->load->view('background_bawah');
	}

	public function riwayat()
	{
		$d = [
			'page' => 'Riwayat Belanja',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('riwayat_pesanan', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_penjualan()
	{
		$list = $this->penjualan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			$no++;
			$status = '';
			switch ($penjualan->pjl_status) {
				case 1:
					$status = "<span class='badge badge-warning'>Menunggu Konfirmasi</span>";
					break;
				case 2:
					$status = "<span class='badge badge-success'>Dikonfirmasi</span>";
					break;
				case 3:
					$status = "<span class='badge badge-danger'>Ditolak</span>";
					break;
			}
			$total_item = $this->penjualan->total_item($penjualan->pjl_id);

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_date_created;
			$row[] = $penjualan->log_nama;
			$row[] = $total_item;
			$row[] = "Rp. " . number_format($penjualan->pjl_jumlah_bayar, 0);
			$row[] = $status;
			$row[] = "<a href='#' onClick='konfirmasi(" . $penjualan->pjl_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Pembelian'><i class='fa fa-check-circle'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan->count_all(),
			"recordsFiltered" => $this->penjualan->count_filtered(),
			"data" => $data,
			"query" => $this->penjualan->getlastquery(),
		);
		echo json_encode($output);
	}

	public function ajax_list_riwayat()
	{
		$list = $this->riwayat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $riwayat) {
			$no++;
			$status = '';
			switch ($riwayat->pjl_status) {
				case 1:
					$status = "<span class='badge badge-warning'>Menunggu Konfirmasi</span>";
					break;
				case 2:
					$status = "<span class='badge badge-success'>Dikonfirmasi</span>";
					break;
				case 3:
					$status = "<span class='badge badge-danger'>Ditolak</span>";
					break;
			}
			$total_item = $this->riwayat->total_item($riwayat->pjl_id);

			$row = array();
			$row[] = $no;
			$row[] = $riwayat->pjl_date_created;
			$row[] = $riwayat->log_nama;
			$row[] = $total_item;
			$row[] = "Rp. " . number_format($riwayat->pjl_jumlah_bayar, 0);
			$row[] = $status;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->riwayat->count_all(),
			"recordsFiltered" => $this->riwayat->count_filtered(),
			"data" => $data,
			"query" => $this->riwayat->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pjl_id');
		$data = $this->penjualan->cari_penjualan($id);
		echo json_encode($data);
	}

	public function cari_material()
	{
		$id = $this->input->post('mtl_id');
		$data = $this->material->cari_material($id);
		echo json_encode($data);
	}
	
	public function simpan()
	{
		$user = $this->session->userdata('id_user');

		$data = $this->input->post();
		$data['pjl_user'] = $user;

		unset($data['pjd_mtl_id']);
		unset($data['pjd_qty']);
		unset($data['pjd_smt_id']);

		$insert = $this->penjualan->simpan("penjualan", $data);

		$data2 = $this->input->post();
		$getLastPenjualan = $this->penjualan->getLast($user);
		$total_harga = 0;

		foreach ($data2['pjd_qty'] as $idx => $kd) {
			$getMaterial = $this->material->cari_material($data2['pjd_mtl_id'][$idx]);

			if ($data['pjl_jenis_harga'] == 1) {
				$harga = $getMaterial->mtl_harga_jual;
			} else {
				$harga = $getMaterial->mtl_harga_modal;
			}

			$detail = [
				'pjd_pjl_id' => $getLastPenjualan->pjl_id,
				'pjd_mtl_id' => $data2['pjd_mtl_id'][$idx],
				'pjd_qty' => $data2['pjd_qty'][$idx],
				'pjd_smt_id' => $data2['pjd_smt_id'][$idx],
				'pjd_harga' => $harga * $data2['pjd_qty'][$idx],
				'pjd_status' => $data['pjl_status']
			];

			$data3['mtl_stok'] = $getMaterial->mtl_stok - $data2['pjd_qty'][$idx];

			if ($insert) $insert_detail = $this->penjualan->simpan("penjualan_detail", $detail);
			if ($insert_detail) $this->material->update("material", array('mtl_id' => $data2['pjd_mtl_id'][$idx]), $data3);

			$total_harga += ($harga * $data2['pjd_qty'][$idx]);
		}

		print_r($total_harga);
		die();
		$update['pjl_jumlah_bayar'] = $total_harga;
		$this->penjualan->update("penjualan", array('pjl_id' => $data['pjl_id']), $update);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert_detail) {
			$resp['status'] = 1;
			$resp['desc'] = "Transaksi penjualan berhasil";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function simpan2()
	{
		$mtl_id = $this->input->post('mtl_id');
		$jumlah = $this->input->post('pjd_jumlah');

		$data2 = [
			'pjd_mtl_id' => $mtl_id,
			'pjd_jumlah' => $jumlah,
			'pjd_user' => $this->session->userdata('id_user'),
			'pjd_status' => 1,
		];

		$ambil_stok = $this->material->cari_material($mtl_id);
		$stok = [
			'mtl_stok' => $ambil_stok->mtl_stok - $jumlah,
		];

		$insert = $this->penjualan->simpan("penjualan_detail", $data2);
		if ($insert) $this->penjualan->update("material", array('mtl_id' => $mtl_id), $stok);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menambahkan ke keranjang";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id, $mtl_id, $jumlah)
	{
		$delete = $this->penjualan->delete('penjualan_detail', 'pjd_id', $id);
		if ($delete) {

			$ambil_stok = $this->material->cari_material($mtl_id);
			$stok = [
				'mtl_stok' => $ambil_stok->mtl_stok + $jumlah,
			];
			$this->penjualan->update("material", array('mtl_id' => $mtl_id), $stok);

			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus item !";
		}
		echo json_encode($resp);
	}

	public function ubah_qty($id, $nilai)
	{
		$data2 = [
			'pjd_jumlah' => $nilai,
		];

		$insert = $this->penjualan->update("penjualan_detail", array('pjd_id' => $id), $data2);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menambahkan ke keranjang";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function checkout()
	{
		$data = $this->input->post();

		$data['pjl_status'] = 1;

		$insert = $this->penjualan->simpan("penjualan", $data);

		$where = [
			'pjd_user' => $data['pjl_user'],
			'pjd_status' => 1,
		];

		$ambil = $this->penjualan->getLast($data['pjl_user']);

		$data2 = [
			'pjd_pjl_id' => $ambil->pjl_id,
			'pjd_status' => 2,
		];

		if ($insert) $this->penjualan->update("penjualan_detail", $where, $data2);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Silahkan tunggu konfirmasi pembayaran dari admin kami";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam pembayaran!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function konfirmasi()
	{
		$id = $this->input->post('pjl_id');
		$data = [
			'pjl_status' => $this->input->post('pjl_status'),
		];

		$insert = $this->penjualan->update("penjualan", array('pjl_id' => $id), $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengkonfirmasi pembelian";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam konfirmasi!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}
}
