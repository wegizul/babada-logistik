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
		$this->load->model('Model_JenisProduk', 'jenis_produk');
		$this->load->model('Model_Pembelian', 'pembelian');
		$this->load->model('Model_Penjualan', 'penjualan');
		$this->load->model('Model_Premix', 'premix');
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Data Material',
			'satuan' => $this->satuan_material->get_satuan_material(),
			'jenis' => $this->jenis_produk->get_jenis_produk(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('material', $d);
		$this->load->view('background_bawah');
	}

	public function laporan()
	{
		$d = [
			'page' => 'Laporan Rekap Material',
			'satuan' => $this->satuan_material->get_satuan_material(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('laporan_rekap_material', $d);
		$this->load->view('background_bawah');
	}

	public function export($bln)
	{
		if ($bln == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $bln;
		}

		$list = $this->material->get_material();
		$data = array();
		foreach ($list as $material) {
			$total_pembelian = $this->material->getTobel($material->mtl_id, $bln);
			$total_penjualan = $this->material->getToju($material->mtl_id, $bln);

			$data[] = [
				'jp_nama' => $material->jp_nama,
				'mtl_nama' => $material->mtl_nama,
				'topel' => $total_pembelian->tot,
				'topen' => $total_penjualan->tot,
				'stok' => $material->mtl_stok,
			];
		}

		$d = [
			'page' => 'Laporan Rekap Material',
			'bulan' => $nama_bulan,
			'data' => $data,
		];
		$this->load->helper('url');
		$this->load->view('export_material', $d);
	}

	public function ajax_list_material()
	{
		$list = $this->material->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $material) {
			$aksi = "<a href='#' onClick='ubah_material(" . $material->mtl_id . ")' class='btn btn-dark btn-xs' title='Ubah Data'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_material(" . $material->mtl_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			if ($material->mtl_pmx_id) {
				$aksi = "<a href='#' onClick='hapus_material(" . $material->mtl_id . ")' class='btn btn-danger btn-xs' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<img src= " . base_url("assets/files/material/{$material->mtl_foto}") . " width='50px'>";
			$row[] = "<a href='#' onClick='lihat_transaksi(" . $material->mtl_id . ")' title='Lihat Transaksi'>" . $material->mtl_nama . "</a>";
			$row[] = "Rp " . number_format($material->mtl_harga_modal, 2, ",", ".");
			$row[] = "Rp " . number_format($material->mtl_harga_jual, 2, ",", ".");
			$row[] = $material->mtl_stok . ' ' . $material->smt_nama;
			$row[] = $aksi;
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

	public function ajax_list_laporan($bln)
	{
		$list = $this->material->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $material) {
			$no++;

			$total_pembelian = $this->material->getTobel($material->mtl_id, $bln);
			$total_penjualan = $this->material->getToju($material->mtl_id, $bln);
			$stok_bulan_terlewat = $this->material->getStokBerlalu($material->mtl_id, $bln);
			$sisa_stok = $material->mtl_stok - $stok_bulan_terlewat->tot;

			$row = array();
			$row[] = $no;
			$row[] = $material->jp_nama;
			$row[] = $material->mtl_nama;
			$row[] = $total_pembelian->tot ? $total_pembelian->tot . ' ' . $material->smt_nama : "0 " . $material->smt_nama;
			$row[] = $total_penjualan->tot ? $total_penjualan->tot . ' ' . $material->smt_nama : "0 " . $material->smt_nama;
			// $row[] = $sisa_stok . ' ' . $material->smt_nama;
			$row[] = $material->mtl_stok . ' ' . $material->smt_nama;
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

	public function simpan()
	{
		$id = $this->input->post('mtl_id');
		$data = $this->input->post();
		$data['mtl_date_created'] = date('Y-m-d H:i:s');

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

	public function lihat_transaksi($id)
	{
		$getPjl = $this->penjualan->penjualan_material($id);
		$getPbl = $this->pembelian->pembelian_material($id);
		$getTobel = $this->material->getTotalBeli($id);
		$getToju = $this->material->getTotalJual($id);

		$tblPembelian = [];
		foreach ($getPbl as $pbl) {
			$tblPembelian[$pbl->pbl_id] = "<tr>
				<td>{$pbl->pbl_tanggal}</td>
				<td>{$pbl->pbl_supplier}</td>
				<td>{$pbl->mtl_nama}</td>
				<td>{$pbl->pbd_qty} {$pbl->pbd_satuan}</td>
			</tr>";
		}

		$tblPenjualan = [];
		foreach ($getPjl as $pjl) {
			$tblPenjualan[$pjl->pjl_id] = "<tr>
				<td>{$pjl->pjl_tanggal}</td>
				<td>{$pjl->pjl_faktur}</td>
				<td>{$pjl->pjl_customer}</td>
				<td>{$pjl->mtl_nama}</td>
				<td>{$pjl->pjd_qty} {$pjl->smt_nama}</td>
			</tr>";
		}

		$data['pembelian'] = $tblPembelian;
		$data['penjualan'] = $tblPenjualan;
		$data['stok'] = $getTobel->tobel - $getToju->toju;
		$data['tobel'] = $getTobel->tobel;
		$data['toju'] = $getToju->toju;
		echo json_encode($data);
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
