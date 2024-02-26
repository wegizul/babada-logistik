<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BookingDetail extends CI_Controller
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
		$this->load->model('Model_BookingDetail', 'booking_detail');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil($id)
	{
		$d = [
			'bk_id' => $id,
			'page' => 'Booking Detail',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('booking_detail', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_booking_detail($id)
	{
		$list = $this->booking_detail->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $booking_detail) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<img src= " . base_url("assets/files/barcode/{$booking_detail->bd_kode}.png") . " width='50%'>";
			$row[] = $booking_detail->bd_kode;
			$row[] = $booking_detail->bd_berat_barang;
			$row[] = $booking_detail->bd_panjang . ' x ' . $booking_detail->bd_lebar . ' x ' . $booking_detail->bd_tinggi . ' cm';
			$row[] = $booking_detail->sp_nama;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->booking_detail->count_all(),
			"recordsFiltered" => $this->booking_detail->count_filtered($id),
			"data" => $data,
			"query" => $this->booking_detail->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('bd_id');
		$data = $this->booking_detail->cari_booking_detail($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->booking_detail->delete('booking_detail', 'bd_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}
}
