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
		$this->load->model('Model_Reject', 'reject');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'material' => $this->material->ambil_material(),
			'satuan_material' => $this->satuan_material->get_satuan_material(),
			'page' => 'Data Penjualan',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
			'klaim' => $this->reject->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('penjualan', $d);
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

	public function ajax_list_penjualan($bln, $tgl)
	{
		$list = $this->penjualan->get_datatables($bln, $tgl);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $penjualan) {
			$no++;
			$status = '';
			$pembayaran = '';
			switch ($penjualan->pjl_status) {
				case 0:
					$status = "<span class='badge badge-warning'>Menunggu Konfirmasi</span>";
					break;
				case 1:
					$status = "<span class='badge badge-info'>Dikonfirmasi AM</span>";
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
				case 6:
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

			$kon = '';
			$res = '';
			$inv = '';
			$pay = '';
			$del = '';
			if ($penjualan->pjl_status < 2) {
				$kon = "<button onClick='konfirmasi(" . $penjualan->pjl_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Pembelian'><i class='fa fa-check-circle'></i></button>";
				$res = " <a href='" . base_url('Penjualan/cetak_resi_cust/') . $penjualan->pjl_id . "' class='btn btn-warning btn-xs' target='_blank' title='Cetak Resi'><i class='fa fa-print'></i></a>";
			} else if ($penjualan->pjl_status == 2) {
				$kon = "<button onClick='konfirmasi(" . $penjualan->pjl_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Pembelian'><i class='fa fa-check-circle'></i></button>";
				$res = " <a href='" . base_url('Penjualan/cetak_resi_cust/') . $penjualan->pjl_id . "' class='btn btn-warning btn-xs' target='_blank' title='Cetak Resi'><i class='fa fa-print'></i></a>";
				$inv = " <a href='" . base_url('Penjualan/cetak_invoice/') . $penjualan->pjl_id . "' class='btn btn-success btn-xs' target='_blank' title='Cetak Invoice'><i class='fas fa-file-invoice'></i> Invoice</a>";
				$pay = " <button onClick='pembayaran(" . $penjualan->pjl_id . ")' class='btn btn-success btn-xs' title='Tambah Pembayaran'><i class='fa fa-hand-holding-usd'></i> Payment</button>";
			} else if ($penjualan->pjl_status == 3) {
				$inv = " <a href='" . base_url('Penjualan/cetak_invoice/') . $penjualan->pjl_id . "' class='btn btn-success btn-xs' target='_blank' title='Cetak Invoice'><i class='fas fa-file-invoice'></i> Invoice</a>";
				$pay = " <button onClick='pembayaran(" . $penjualan->pjl_id . ")' class='btn btn-success btn-xs' title='Tambah Pembayaran'><i class='fa fa-hand-holding-usd'></i> Payment</button>";
			} elseif ($penjualan->pjl_status == 4 && $penjualan->pjl_status_bayar == 2) {
				$inv = " <a href='" . base_url('Penjualan/cetak_invoice/') . $penjualan->pjl_id . "' class='btn btn-success btn-xs' target='_blank' title='Cetak Invoice'><i class='fas fa-file-invoice'></i> Invoice</a>";
			} else {
				$kon = "<button onClick='konfirmasi(" . $penjualan->pjl_id . ")' class='btn btn-dark btn-xs' title='Konfirmasi Pembelian'><i class='fa fa-check-circle'></i></button>";
			}

			if ($this->session->userdata('level') == 1) {
				$del = "<a href='#' onClick='hapus_penjualan(" . $penjualan->pjl_id . ")' class='btn btn-danger btn-xs ml-1' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			}

			$ctt = '';
			if ($penjualan->pjl_catatan) $ctt = "<a href='#' onClick='catatan(" . $penjualan->pjl_id . ")' class='btn btn-secondary btn-xs' title='Lihat Catatan'><i class='fa fa-comment'></i> Catatan</a>";

			$edit_tgl = "<a href='#' onClick='edit_tgl(" . $penjualan->pjl_id . ")' class='btn btn-secondary btn-block btn-xs' title='Ubah Tanggal'><i class='fa fa-calendar'></i>&nbsp;&nbsp;Ubah</a>";

			$row = array();
			$row[] = $no;
			$row[] = $penjualan->pjl_tanggal . '<br>' . $edit_tgl;
			$row[] = "<a href='" . base_url('PenjualanDetail/tampil/') . $penjualan->pjl_id . "'>" . $penjualan->pjl_faktur . "</a><br>" . $ctt;
			$row[] = $penjualan->pjl_customer;
			$row[] = $penjualan->pjl_total_item . " Item";
			$row[] = "Rp " . number_format($penjualan->pjl_jumlah_bayar, 0, ",", ".");
			$row[] = $pembayaran;
			$row[] = $status;
			$row[] = $kon . $res . $inv . $pay . $del;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penjualan->count_all(),
			"recordsFiltered" => $this->penjualan->count_filtered($bln, $tgl),
			"data" => $data,
			"query" => $this->penjualan->getlastquery(),
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

	public function ambil_catatan()
	{
		$id = $this->input->post('pjl_id');
		$data = $this->penjualan->cari_penjualan2($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id_cust = $this->input->post('pjl_cust_id');

		// Mendefinisikan URL API yang akan diakses
		$api_url = 'https://dreampos.id/admin/Api/findCustomer/' . $id_cust;

		// Membuat request menggunakan cURL
		$curl = curl_init($api_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);

		// Mengubah respons JSON menjadi array PHP
		$cust = json_decode($response, true);

		$user = $this->session->userdata('id_user');

		$data = $this->input->post();
		$data['pjl_user'] = $user;
		$data['pjl_customer'] = $cust['name'];

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
			$data9['pmx_stok'] = $getMaterial->mtl_stok - $data2['pjd_qty'][$idx];

			if ($insert) $insert_detail = $this->penjualan->simpan("penjualan_detail", $detail);

			if ($insert_detail) {
				$this->material->update("material", array('mtl_id' => $data2['pjd_mtl_id'][$idx]), $data3);
				if ($getMaterial->mtl_pmx_id) $this->material->update("premix", array('pmx_id' => $getMaterial->mtl_pmx_id), $data9);
			}

			$total_harga += ($harga * $data2['pjd_qty'][$idx]);
			$total_item += $parameter_item;
		}

		$tempdir = "assets/files/barcode/";
		$invoice = "INV" . sprintf("%04s", $getLastPenjualan->pjl_id);

		if (!file_exists($tempdir)) mkdir($tempdir, 0755);
		$target_path = $tempdir . $invoice . '-' . date('YmdHis') . ".png";
		/*using server online */
		// $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
		// $fileImage = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55";
		/*using server localhost*/
		$fileImage = base_url("assets/php-barcode-master/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55");
		/*get content from url*/
		$content = file_get_contents($fileImage);
		/*save file */
		// file_put_contents($target_path, $content);
		$data4['pjl_barcode'] = $content;

		$update = [
			'pjl_faktur' => $invoice,
			'pjl_jumlah_bayar' => $total_harga,
			'pjl_total_item' => $total_item,
			'pjl_barcode' => $data4['pjl_barcode']
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

	public function simpan_edit_tgl()
	{
		$data = $this->input->post();

		$edit = $this->penjualan->update("penjualan", array('pjl_id' => $data['pjl_id']), $data);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($edit) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil mengubah tanggal penjualan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function edit_harga_resi($id)
	{
		$data = $this->input->post();

		$total_harga = 0;
		foreach ($data['pjd_harga'] as $idx => $kd) {
			if (isset($data['pjd_harga'])) {
				$update = [
					'pjd_harga' => $data['pjd_harga'][$idx],
				];
				$where = [
					'pjd_id' => $data['pjd_id'][$idx],
				];
				$total_harga += (int)$data['pjd_harga'][$idx];

				$edit = [
					'pjl_jumlah_bayar' => $total_harga,
				];

				if ($total_harga > 0) {
					$this->penjualan->update("penjualan_detail", $where, $update);
					$this->penjualan->update("penjualan", array('pjl_id' => $id), $edit);
				}
			}
		}

		$cetak = [
			'data' => $this->penjualan->ambil_penjualan($id),
			'penjualan' => $this->penjualan->cari_penjualan($id),
		];
		$this->load->view('cetak_resi_pdf', $cetak);
	}

	public function hapus($id)
	{
		$delete = $this->penjualan->delete('penjualan', 'pjl_id', $id);
		if ($delete) {
			$this->penjualan->delete('penjualan_detail', 'pjd_pjl_id', $id);

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
		$id = $this->input->post('pjl_id2');
		$getdata = $this->input->post();

		$data = [
			'pjl_status' => $this->input->post('pjl_status2'),
		];

		$data2 = [
			'pjd_status' => $this->input->post('pjl_status2'),
		];

		$where = [
			'pjd_pjl_id' => $id,
			'pjd_status' => 1,
		];

		$this->penjualan->update("penjualan", array('pjl_id' => $id), $data);
		$insert = $this->penjualan->update("penjualan_detail", $where, $data2);

		if ($getdata['pjl_status2'] == 2) {
			$getPenjualan = $this->penjualan->item_penjualan($id);

			foreach ($getPenjualan as $p) {
				$getMaterial = $this->material->cari_material($p->pjd_mtl_id);

				$data3['mtl_stok'] = $getMaterial->mtl_stok - $p->pjd_qty;
				$data9['pmx_stok'] = $getMaterial->mtl_stok - $p->pjd_qty;

				$this->material->update("material", array('mtl_id' => $p->pjd_mtl_id), $data3);
				if ($getMaterial->mtl_pmx_id) $this->material->update("premix", array('pmx_id' => $getMaterial->mtl_pmx_id), $data9);
			}
		}

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

	public function pembayaran()
	{
		$id = $this->input->post('pjl_id3');
		$data = [
			'pjl_tanggal_bayar' => $this->input->post('pjl_tanggal3'),
			'pjl_jenis_bayar' => $this->input->post('pjl_jenis_bayar3'),
			'pjl_status_bayar' => $this->input->post('pjl_status_bayar3'),
			'pjl_status' => $this->input->post('pjl_status3'),
			'pjl_user_bayar' => $this->session->userdata('id_user'),
		];

		$data2 = [
			'pjd_status' => $this->input->post('pjl_status3'),
		];

		$where = [
			'pjd_pjl_id' => $id,
			'pjd_ket' => NULL,
		];

		$this->penjualan->update("penjualan", array('pjl_id' => $id), $data);
		$insert = $this->penjualan->update("penjualan_detail", $where, $data2);

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menambahkan pembayaran";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam proses simpan!";
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

	public function cetak_resi_cust($id)
	{
		$data = [
			'data' => $this->penjualan->ambil_penjualan($id),
			'penjualan' => $this->penjualan->cari_penjualan($id),
		];
		$this->load->view('cetak_resi', $data);
	}

	public function cetak_invoice($id)
	{
		$data = [
			'data' => $this->penjualan->ambil_penjualan($id),
			'penjualan' => $this->penjualan->cari_penjualan($id),
		];
		$this->load->view('cetak_invoice', $data);
	}
}
