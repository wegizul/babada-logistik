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

	public function laporan()
	{
		$d = [
			'page' => 'Laporan Penjualan',
			'data' => $this->penjualan->get_penjualan(),
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('laporan_penjualan', $d);
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
			'page' => 'Laporan Penjualan',
			'bulan' => $nama_bulan,
			'data' => $this->penjualan->export_excel($bln),
		];
		$this->load->helper('url');
		$this->load->view('export_penjualan', $d);
	}

	public function ajax_list_penjualan($bln)
	{
		$list = $this->penjualan->get_datatables($bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			$no++;
			$status = '';
			$pembayaran = '';
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
			switch ($penjualan->pjl_status_bayar) {
				case 0:
					$pembayaran = "<span class='badge badge-warning'>Tertunda</span>";
					break;
				case 1:
					$pembayaran = "<span class='badge badge-danger'>Jatuh Tempo</span>";
					break;
				case 2:
					$pembayaran = "<span class='badge badge-success'>Lunas</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_date_created;
			$row[] = $penjualan->pjl_faktur;
			$row[] = $penjualan->pjl_customer;
			$row[] = $penjualan->pjl_total_item . " Item";
			$row[] = "Rp " . number_format($penjualan->pjl_jumlah_bayar, 0, ",", ".");
			$row[] = $pembayaran;
			$row[] = $status;
			$row[] = "<a href='#' onClick='konfirmasi(" . $penjualan->pjl_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Pembelian'><i class='fa fa-check-circle'></i></a> <a href='" . base_url('Penjualan/cetak_resi/') . $penjualan->pjl_id . "' class='btn btn-warning btn-xs' target='_blank' title='Cetak Resi'><i class='fa fa-print'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan->count_all(),
			"recordsFiltered" => $this->penjualan->count_filtered($bln),
			"data" => $data,
			"query" => $this->penjualan->getlastquery(),
		);
		echo json_encode($output);
	}

	public function ajax_list_laporan($bln)
	{
		$list = $this->riwayat->get_datatables($bln);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $riwayat) {
			$no++;
			$status = '';
			$pembayaran = '';
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
			switch ($riwayat->pjl_status_bayar) {
				case 0:
					$pembayaran = "<span class='badge badge-warning'>Tertunda</span>";
					break;
				case 1:
					$pembayaran = "<span class='badge badge-danger'>Jatuh Tempo</span>";
					break;
				case 2:
					$pembayaran = "<span class='badge badge-success'>Lunas</span>";
					break;
			}

			$row = array();
			$row[] = $no;
			$row[] = $riwayat->pjl_date_created;
			$row[] = $riwayat->pjl_faktur;
			$row[] = $riwayat->pjl_customer;
			$row[] = $riwayat->pjl_total_item . " Item";
			$row[] = "Rp " . number_format($riwayat->pjl_jumlah_bayar, 0, ",", ".");
			$row[] = $pembayaran;
			$row[] = $status;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->riwayat->count_all(),
			"recordsFiltered" => $this->riwayat->count_filtered($bln),
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
		$total_item = 0;
			
		foreach ($data2['pjd_qty'] as $idx => $kd) {
			$parameter_item = 1;
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
			$total_item += $parameter_item;
		}

		$tempdir = "assets/files/barcode/";
		$invoice = "INV" . sprintf("%04s", $getLastPenjualan->pjl_id);

		if (!file_exists($tempdir)) mkdir($tempdir, 0755);
		$target_path = $tempdir . $invoice . '-' . date('YmdHis') . ".png";
		/*using server online */
		$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
		$fileImage = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55";
		/*using server localhost*/
		// $fileImage = base_url("assets/php-barcode-master/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55");
		/*get content from url*/
		$content = file_get_contents($fileImage);
		/*save file */
		file_put_contents($target_path, $content);

		$update = [
			'pjl_faktur' => $invoice,
			'pjl_jumlah_bayar' => $total_harga,
			'pjl_total_item' => $total_item,
			'pjl_barcode' => $content
		];
		$this->penjualan->update("penjualan", array('pjl_id' => $getLastPenjualan->pjl_id), $update);

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
			$resp['desc'] = "Ada kesalahan dalam transaksi!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->penjualan->delete('penjualan', 'pjl_id', $id);
		if ($delete) {
			$this->penjualan->delete('penjualan_detail', 'pjd_pjl_id', $id);
			// $ambil_stok = $this->material->cari_material($mtl_id);
			// $stok = [
			// 	'mtl_stok' => $ambil_stok->mtl_stok + $jumlah,
			// ];
			// $this->penjualan->update("material", array('mtl_id' => $mtl_id), $stok);

			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp; Berhasil menghapus item";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus item !";
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

	public function cetak_resi()
	{
		$get_last = $this->penjualan->getLast($this->session->userdata('id_user'));
		$data = [
			'data' => $this->penjualan->ambil_penjualan($get_last->pjl_id),
			'penjualan' => $this->penjualan->cari_penjualan($get_last->pjl_id),
		];
		$this->load->view('cetak_resi', $data);
	}
}
