<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manifest extends CI_Controller
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
		$this->load->model('Model_Manifest', 'manifest');
		$this->load->model('Model_Penjualan', 'penjualan');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$d = [
			'page' => 'Laporan Manifest',
		];
		$notif = [
			'notifikasi' => $this->penjualan->notifikasi(),
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $notif);
		$this->load->view('manifest', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_manifest()
	{
		$list = $this->manifest->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $manifest) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = "<a href='" . base_url('ManifestDetail/tampil/') . $manifest->mf_kode . "'>" . $manifest->mf_kode . "</a>";
			$row[] = $manifest->mf_tujuan;
			$row[] = $manifest->mf_tgl_pickup;
			$row[] = $manifest->mf_supir;
			$row[] = $manifest->mf_telp_supir;
			$row[] = $manifest->mf_total_paket;
			$row[] = "<a href='" . base_url('ScanKirim/cetak_manifest/' . $manifest->mf_kode) . "' class='btn btn-warning btn-xs' target='_blank'><i class='fas fa-print'></i> </a> ";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->manifest->count_all(),
			"recordsFiltered" => $this->manifest->count_filtered(),
			"data" => $data,
			"query" => $this->manifest->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('mf_id');
		$data = $this->manifest->cari_manifest($id);
		echo json_encode($data);
	}

	public function hapus($id)
	{
		$delete = $this->manifest->delete('manifest', 'mf_id', $id);
		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function export($bln)
	{
		if ($bln == 'null') {
			$nama_bulan = 'All Data';
		} else {
			$nama_bulan = $bln;
		}
		$d = [
			'page' => 'Laporan Manifest',
			'bulan' => $nama_bulan,
			'data' => $this->manifest->export_excel($bln),
		];
		$this->load->helper('url');
		$this->load->view('export_manifest', $d);
	}

}
