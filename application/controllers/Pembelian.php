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
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Material', 'material');
		$this->load->model('Model_SatuanMaterial', 'satuan_material');
		$this->load->model('Model_Supplier', 'supplier');
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
			$total_item = $this->pembelian->get_jumlah_pbd($pembelian->pbl_id);
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pembelian->pbl_tanggal;
			$row[] = $pembelian->pbl_no_faktur;
			$row[] = $pembelian->pbl_supplier;
			$row[] = $total_item . " Item";
			$row[] = "Rp " . number_format($pembelian->pbl_total_harga, 0, ",", ".");
			$row[] = $pembelian->log_nama;
			$row[] = "<a href='" . base_url('PembelianDetail/tampil/') . $pembelian->pbl_id . "' class='btn btn-default btn-sm mb-1' title='Detail'><i class='fa fa-boxes'></i></a> <a href='#' onClick='hapus_pembelian(" . $pembelian->pbl_id . ")' class='btn btn-danger btn-sm mb-1' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
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
		
		if ($id == 0) {
			$insert = $this->pembelian->simpan("pembelian", $data);

			$get_id_pembelian = $this->pembelian->get_last_pembelian();
			$data2 = $this->input->post();

			foreach ($data2['pbd_qty'] as $idx => $kd) {
				$detail = [
					"pbd_pbl_id" => $get_id_pembelian->pbl_id,
					"pbd_mtl_id" => $data2['pbd_mtl_id'][$idx],
					"pbd_qty" => $data2['pbd_qty'][$idx],
					"pbd_satuan" => $data2['pbd_satuan'][$idx],
					"pbd_harga" => $data2['pbd_harga'][$idx],
				];
				if ($data2['pbd_qty']) $insert = $this->pembelian->simpan("pembelian_detail", $detail);

				$get_material = $this->material->cari_material($data2['pbd_mtl_id'][$idx]);

				$data3['mtl_stok'] = $get_material->mtl_stok + $data2['pbd_qty'][$idx];
				$data3['mtl_date_updated'] = date('Y-m-d H:i:s');

				if ($insert) $this->material->update("material", array('mtl_id' => $data2['pbd_mtl_id'][$idx]), $data3);
			}

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
			$resp['desc'] = "pembelian berhasil dibuat";
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

	public function cetak_resi()
	{
		$get_last_pembelian = $this->pembelian->get_last_pembelian();
		$data = [
			'data' => $this->pembelian->ambil_pembelian($get_last_pembelian->pbl_id),
			'jumlah' => $this->pembelian->get_jumlah_pbd($get_last_pembelian->pbl_id),
		];
		$this->load->view('cetak_resi', $data);
	}

	public function cetak_resi2($pbl_id)
	{
		$jumlah = $this->pembelian->get_jumlah_pbd($pbl_id);
		$ambil = $this->pembelian->ambil_pembelian($pbl_id);
		$data = [
			'data' => $ambil,
			'jumlah' => $jumlah,
		];
		$this->load->view('cetak_resi', $data);
	}
}
