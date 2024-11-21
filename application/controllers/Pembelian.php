<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
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
		$this->load->model('Model_Pembelian', 'pembelian');
		$this->load->model('Model_PembelianDetail', 'pembelian_detail');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Material', 'material');
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Supplier', 'supplier');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'supplier' => $this->supplier->get_supplier(),
			'material' => $this->material->get_material(),
			'satuan_material' => $this->satuan_material->get_satuan_material(),
			'page' => 'Pembelian / Barang Masuk',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('pembelian', $d);
		$this->load->view('background_bawah');
	}

	public function laporan()
	{
		$d = [
			'page' => 'Laporan Pembelian',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('laporan_pembelian', $d);
		$this->load->view('background_bawah');
	}

	public function export($bln)
	{
		if ($bln == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $bln;
		}
		$d = [
			'page' => 'Laporan Pembelian',
			'bulan' => $nama_bulan,
			'data' => $this->pembelian->export_excel($bln),
		];
		$this->load->helper('url');
		$this->load->view('export_pembelian', $d);
	}

	public function ajax_list_pembelian($bln)
	{
		$list = $this->pembelian->get_datatables($bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pembelian) {
			$ppn = 0;
			if ($pembelian->ppn_true == 1) {
				$ppn = number_format($pembelian->pbl_ppn, 0, ",", ".");
			}
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pembelian->pbl_tanggal;
			$row[] = "<a href='" . base_url('PembelianDetail/tampil/') . $pembelian->pbl_id . "'>" . $pembelian->pbl_no_faktur . "</a>";
			$row[] = $pembelian->pbl_supplier;
			$row[] = $pembelian->pbl_total_item . " Item";
			$row[] = "Rp " . number_format($pembelian->pbl_jumlah_harga, 0, ",", ".");
			$row[] = "Rp " . number_format($pembelian->pbl_ongkos_bongkar, 0, ",", ".");
			$row[] = "Rp " . $ppn;
			$row[] = "Rp " . number_format($pembelian->pbl_total_harga, 0, ",", ".");

			if ($this->session->userdata('level') == 1) {
				$row[] = "<a href='" . base_url('Pembelian/edit/') . $pembelian->pbl_id . "' class='btn btn-dark btn-xs' title='Edit Pembelian'><i class='fas fa-edit'></i></a> <a href='#' onClick='hapus_pembelian(" . $pembelian->pbl_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			}
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pembelian->count_all(),
			"recordsFiltered" => $this->pembelian->count_filtered($bln),
			"data" => $data,
			"query" => $this->pembelian->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pbl_id');
		$data = $this->pembelian->cari_pembelian($id);
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
		$id = $this->input->post('pbl_id');
		$data = $this->input->post();

		$data['pbl_user'] = $this->session->userdata('id_user');

		unset($data['pbd_mtl_id']);
		unset($data['pbd_qty']);
		unset($data['pbd_satuan']);
		unset($data['pbd_harga']);
		unset($data['pbd_ppn']);
		
		if ($id == 0) {
			$insert = $this->pembelian->simpan("pembelian", $data);

			$get_id_pembelian = $this->pembelian->get_last_pembelian();
			$data2 = $this->input->post();
			$total_item = 0;
			
			foreach ($data2['pbd_qty'] as $idx => $kd) {
				$parameter_item = 1;
				$detail = [
					"pbd_pbl_id" => $get_id_pembelian->pbl_id,
					"pbd_mtl_id" => $data2['pbd_mtl_id'][$idx],
					"pbd_qty" => $data2['pbd_qty'][$idx],
					"pbd_satuan" => $data2['pbd_satuan'][$idx],
					"pbd_harga" => $data2['pbd_harga'][$idx],
					"pbd_ppn" => $data2['pbd_ppn'][$idx],
				];
				if ($data2['pbd_qty']) $insert = $this->pembelian->simpan("pembelian_detail", $detail);

				$get_material = $this->material->cari_material($data2['pbd_mtl_id'][$idx]);

				$data3['mtl_stok'] = $get_material->mtl_stok + $data2['pbd_qty'][$idx];
				$data3['mtl_date_updated'] = date('Y-m-d H:i:s');

				if ($insert) $this->material->update("material", array('mtl_id' => $data2['pbd_mtl_id'][$idx]), $data3);

				$total_item += $parameter_item;
			}

			$update['pbl_total_item'] = $total_item;
			$this->pembelian->update("pembelian", array('pbl_id' => $get_id_pembelian->pbl_id), $update);

		} else {
			$insert = $this->pembelian->update("pembelian", array('pbl_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "pembelian berhasil diinputkan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pembelian->delete('pembelian', 'pbl_id', $id);
		if ($delete) {
			$this->pembelian->delete('pembelian_detail', 'pbd_pbl_id', $id);
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}
	
	public function edit($pbl_id)
	{
		$d = [
			'page' => 'Edit Pembelian',
			'pbl_id' => $pbl_id,
			'inv' => $this->pembelian->cari_pembelian($pbl_id),
			'item' => $this->pembelian_detail->ambil_pembelian_detail($pbl_id),
			'material' => $this->material->get_material(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('pembelian_edit', $d);
		$this->load->view('background_bawah');
	}

	public function getPembelian($pbl_id)
	{
		$cari = $this->pembelian_detail->ambil_pembelian_detail($pbl_id);
		foreach ($cari as $p) {
			$data[$p->pbd_id] = "<tr><td width='45%'>" . $p->mtl_nama . "</td><td width='15%'><input type='number' min='0' value='" . $p->pbd_qty . "' class='form-control' onchange='ubah_qty(" . $p->pbd_id . ", this.value)'></td><td width='15%'>" . $p->pbd_satuan . "</td><td width='20%'><input type='number' min='0' value='" . $p->pbd_harga . "' class='form-control' onchange='ubah_harga(" . $p->pbd_id . ", this.value)'></td><td><span onClick='hapus_item(" . $p->pbd_id . "," . $p->pbd_pbl_id . ")' class='btn btn-danger btn-xs' title='Hapus Item'><i class='fa fa-trash-alt'></i></span></td></tr>";
		}

		$json_data = json_encode($data);

		echo $json_data;
	}

	public function simpan_edit()
	{
		$id = $this->input->post('pbl_id');
		$data = $this->input->post();

		if ($data['parameter'] > 1) {
			foreach ($data['pbd_qty'] as $idx => $kd) {
				$detail = [
					"pbd_pbl_id" => $id,
					"pbd_mtl_id" => $data['pbd_mtl_id'][$idx],
					"pbd_qty" => $data['pbd_qty'][$idx],
					"pbd_satuan" => $data['pbd_satuan'][$idx],
					"pbd_harga" => $data['pbd_harga'][$idx],
					"pbd_ppn" => $data['pbd_ppn'][$idx],
				];
				if ($data['pbd_qty']) $insert = $this->pembelian->simpan("pembelian_detail", $detail);

				$get_material = $this->material->cari_material($data['pbd_mtl_id'][$idx]);

				$data3['mtl_stok'] = $get_material->mtl_stok + $data['pbd_qty'][$idx];
				$data3['mtl_date_updated'] = date('Y-m-d H:i:s');

				if ($insert) $this->material->update("material", array('mtl_id' => $data['pbd_mtl_id'][$idx]), $data3);
			}
		}

		$getJumlahBayar = $this->pembelian_detail->jumlah_bayar($id);
		$update = [
			'pbl_total_item' => $getJumlahBayar->total_item,
			'pbl_jumlah_harga' => $data['pbl_jumlah_harga'],
			'ppn_true' => $data['ppn_true'],
			'pbl_ppn' => $data['pbl_ppn'],
			'pbl_ongkos_bongkar' => $data['pbl_ongkos_bongkar'],
			'pbl_total_harga' => $data['pbl_total_harga'],
		];
		$simpan_edit = $this->pembelian->update("pembelian", array('pbl_id' => $id), $update);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($simpan_edit) {
			$resp['status'] = 1;
			$resp['desc'] = "pembelian berhasil diinputkan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function editQty($id, $qty)
	{
		$getPembelianDetail = $this->pembelian_detail->cari_pembelian_detail($id);
		$get_material = $this->material->cari_material($getPembelianDetail->pbd_mtl_id);

		if ($qty > $getPembelianDetail->pbd_qty) {
			$lebih = $qty - $getPembelianDetail->pbd_qty;
			$data3['mtl_stok'] = $get_material->mtl_stok + $lebih;
		} else {
			$kurang = $getPembelianDetail->pbd_qty - $qty;
			$data3['mtl_stok'] = $get_material->mtl_stok - $kurang;
		}
		$data3['mtl_date_updated'] = date('Y-m-d H:i:s');

		$edit = [
			'pbd_qty' => $qty,
		];
		$update = $this->pembelian->update("pembelian_detail", array('pbd_id' => $id), $edit);
		if ($update) $this->material->update("material", array('mtl_id' => $get_material->mtl_id), $data3);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($update) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengubah quantity";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		echo json_encode($resp);
	}

	public function editHarga($id, $harga, $ppn)
	{
		$getPembelianDetail = $this->pembelian_detail->cari_pembelian_detail($id);

		$edit = [
			'pbd_harga' => $harga,
			'pbd_ppn' => $ppn,
		];
		$update = $this->pembelian->update("pembelian_detail", array('pbd_id' => $id), $edit);

		$getJumlahBayar = $this->pembelian_detail->jumlah_bayar($getPembelianDetail->pbd_pbl_id);

		$edit_jml_byr = [
			'pbl_total_item' => $getJumlahBayar->total_item,
			'pbl_jumlah_harga' => $getJumlahBayar->jumlah_bayar,
			'pbl_ppn' => $getJumlahBayar->jumlah_ppn,
			'pbl_total_harga' => $getJumlahBayar->jumlah_bayar + $getJumlahBayar->jumlah_ppn,
		];

		$this->pembelian->update("pembelian", array('pbl_id' => $getPembelianDetail->pbd_pbl_id), $edit_jml_byr);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($update) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengubah harga item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		echo json_encode($resp);
	}

	public function hapusItem($id, $pbl_id)
	{
		$getPembelianDetail = $this->pembelian_detail->cari_pembelian_detail($id);
		$get_material = $this->material->cari_material($getPembelianDetail->pbd_mtl_id);

		$data3['mtl_stok'] = $get_material->mtl_stok - $getPembelianDetail->pbd_qty;
		$data3['mtl_date_updated'] = date('Y-m-d H:i:s');

		$update_stok = $this->material->update("material", array('mtl_id' => $get_material->mtl_id), $data3);

		$delete = $this->pembelian->delete('pembelian_detail', 'pbd_id', $id);

		$getJumlahBayar = $this->pembelian_detail->jumlah_bayar($pbl_id);

		$edit = [
			'pbl_total_item' => $getJumlahBayar->total_item,
			'pbl_jumlah_harga' => $getJumlahBayar->jumlah_bayar,
			'pbl_ppn' => $getJumlahBayar->jumlah_ppn,
			'pbl_total_harga' => $getJumlahBayar->jumlah_bayar + $getJumlahBayar->jumlah_ppn,
		];

		if ($delete) $update_total = $this->pembelian->update("pembelian", array('pbl_id' => $pbl_id), $edit);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($update_total) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menghapus item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam proses hapus!";
			$resp['error'] = $err;
		}

		echo json_encode($resp);
	}
}
