<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
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
		$this->load->model('Model_Booking', 'booking');
		$this->load->model('Model_Login', 'pengguna');
		$this->load->model('Model_Kecamatan', 'kecamatan');
		$this->load->model('Model_JenisProduk', 'jenis_produk');
		$this->load->model('Model_StatusPengiriman', 'status_pengiriman');
		$this->load->model('Model_TipeAlamat', 'tipe_alamat');
		$this->load->model('Model_TipeKomoditas', 'tipe_komoditas');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'kota' => $this->kecamatan->get_kota(),
			'jenisproduk' => $this->jenis_produk->get_jenis_produk(),
			'statuspengiriman' => $this->status_pengiriman->get_status_pengiriman(),
			'tipealamat' => $this->tipe_alamat->get_tipe_alamat(),
			'tipekomoditas' => $this->tipe_komoditas->get_tipe_komoditas(),
			'page' => 'Buat Booking',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('booking', $d);
		$this->load->view('background_bawah');
	}

	public function riwayat()
	{
		$d = [
			'page' => 'Riwayat Booking',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('riwayat', $d);
		$this->load->view('background_bawah');
	}

	public function laporan($tgl)
	{
		if ($tgl == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $tgl;
		}
		$d = [
			'page' => 'Laporan Booking',
			'bulan' => $nama_bulan,
			'data' => $this->booking->ekspor_excel($tgl),
		];
		$this->load->helper('url');
		$this->load->view('ekspor_excel', $d);
	}

	public function ajax_list_booking()
	{
		$list = $this->booking->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $booking) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $booking->bk_kode;
			$row[] = $booking->bk_tanggal;
			$row[] = $booking->jp_nama;
			$row[] = $booking->bk_nama_pengirim;
			$row[] = $booking->bk_notelp_pengirim;
			$row[] = $booking->bk_nama_penerima;
			$row[] = $booking->bk_notelp_penerima;
			$row[] = "<a href='" . base_url('BookingDetail/tampil/') . $booking->bk_id . "' class='btn btn-default btn-sm mb-1' title='Detail'><i class='fa fa-boxes'></i></a> <a href='" . base_url('Booking/cetak_resi2/') . $booking->bk_id . "' class='btn btn-warning btn-sm mb-1' target='_blank' title='Cetak Resi'><i class='fa fa-print'></i></a> <a href='#' onClick='hapus_booking(" . $booking->bk_id . ")' class='btn btn-danger btn-sm mb-1' title='Hapus Data'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->booking->count_all(),
			"recordsFiltered" => $this->booking->count_filtered(),
			"data" => $data,
			"query" => $this->booking->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('bk_id');
		$data = $this->booking->cari_booking($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('bk_id');
		$kode = "BK";
		$jp = $this->input->post('bk_jenis_produk');
		$tk = $this->input->post('bk_tipe_komoditas');
		$data = $this->input->post();

		$buat_kode = $kode . $jp . $tk . date('YmdHis');

		$data['bk_kode'] = $buat_kode;
		$data['bk_status_pengiriman'] = $kode;
		$data['bk_tanggal'] = date('Y-m-d');
		$data['bk_user'] = $this->session->userdata('id_user');

		$tempdir = "assets/files/barcode/";

		unset($data['bd_berat_barang']);
		unset($data['bd_panjang']);
		unset($data['bd_lebar']);
		unset($data['bd_tinggi']);

		if ($id == 0) {
			$insert = $this->booking->simpan("booking", $data);

			$get_id_booking = $this->booking->get_last_booking();
			$data2 = $this->input->post();
			$no = 1;
			$gambar = array();
			foreach ($data2['bd_berat_barang'] as $idx => $kd) {

				$data2['bd_kode'] = $buat_kode . "-" . $no;

				if (!file_exists($tempdir)) mkdir($tempdir, 0755);
				$target_path = $tempdir . $buat_kode . "-" . $no . ".png";
				/*using server online
				$protocol=stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
				$fileImage=$protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $_POST['kode_barang'] . "&codetype=code128&print=true&size=55";
				*/
				/*using server localhost*/
				$fileImage = base_url("assets/php-barcode-master/barcode.php?text=" . $buat_kode . "-" . $no . "&codetype=code128&print=true&size=55");
				/*get content from url*/
				$content = file_get_contents($fileImage);
				/*save file */
				$gambar[$idx] = file_put_contents($target_path, $content);
				$data2['bd_barcode'] = $content;

				$detail = [
					"bd_bk_id" => $get_id_booking->bk_id,
					"bd_kode" => $data2['bd_kode'],
					"bd_berat_barang" => $data2['bd_berat_barang'][$idx],
					"bd_panjang" => $data2['bd_panjang'][$idx],
					"bd_lebar" => $data2['bd_lebar'][$idx],
					"bd_tinggi" => $data2['bd_tinggi'][$idx],
					"bd_barcode" => $data2['bd_barcode'][$idx],
					"bd_sp_kode" => $kode,
				];
				if ($data2['bd_berat_barang']) $insert = $this->booking->simpan("booking_detail", $detail);

				$data3['tr_bd_kode'] = $data2['bd_kode'];
				$data3['tr_sp_kode'] = "BK";
				$data3['tr_waktu_scan'] = date('Y-m-d H:i:s');
				$data3['tr_jenis'] = 0;
				$data3['tr_user'] = $this->session->userdata('id_user');

				if ($insert) $this->booking->simpan("tracking", $data3);
				$no++;
			}
		} else {
			$insert = $this->booking->update("booking", array('bk_id' => $id), $data);
		}

		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			$resp['status'] = 1;
			$resp['desc'] = "Booking berhasil dibuat";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->booking->delete('booking', 'bk_id', $id);
		if ($delete) {
			$this->booking->delete('booking_detail', 'bd_bk_id', $id);
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
		$get_last_booking = $this->booking->get_last_booking();
		$data = [
			'data' => $this->booking->ambil_booking($get_last_booking->bk_id),
			'jumlah' => $this->booking->get_jumlah_bd($get_last_booking->bk_id),
		];
		$this->load->view('cetak_resi', $data);
	}

	public function cetak_resi2($bk_id)
	{
		$jumlah = $this->booking->get_jumlah_bd($bk_id);
		$ambil = $this->booking->ambil_booking($bk_id);
		$data = [
			'data' => $ambil,
			'jumlah' => $jumlah,
		];
		$this->load->view('cetak_resi', $data);
	}
}
